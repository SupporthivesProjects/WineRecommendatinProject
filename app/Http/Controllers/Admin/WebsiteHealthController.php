<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SiteAnalyticsEvent;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Website Health: how the logged-in kiosk pages are used.
 * Page views and clicks come from site_analytics_events (TrackPageView middleware and
 * assets/js/site-analytics.js); questionnaire figures come from the saved answers.
 */
class WebsiteHealthController extends Controller
{
    private const RANGES = [7 => 'Last 7 days', 30 => 'Last 30 days', 90 => 'Last 90 days', 365 => 'Last 12 months'];

    public function index(Request $request)
    {
        abort_unless($request->user()->role === 'admin', 403, 'Only the main administrator can view Website Health.');

        $days = (int) $request->input('days', 30);
        if (!array_key_exists($days, self::RANGES)) {
            $days = 30;
        }
        $storeId = $request->filled('store_id') ? (int) $request->input('store_id') : null;
        $since = now()->subDays($days - 1)->startOfDay();

        $events = fn (string $type) => SiteAnalyticsEvent::where('event', $type)
            ->where('created_at', '>=', $since)
            ->when($storeId, fn ($query) => $query->where('store_id', $storeId));

        // ---- Summary cards
        $pageViews = $events(SiteAnalyticsEvent::PAGE_VIEW)->count();
        $clicks = $events(SiteAnalyticsEvent::CLICK)->count();
        $activeUsers = $events(SiteAnalyticsEvent::PAGE_VIEW)->distinct()->count('user_id');
        $winesViewed = $events(SiteAnalyticsEvent::PAGE_VIEW)->whereNotNull('product_id')->distinct()->count('product_id');

        $responses = DB::table('question_responses as r')
            ->where('r.created_at', '>=', $since)
            ->when($storeId, fn ($query) => $query->join('users as u', 'u.id', '=', 'r.user_id')->where('u.store_id', $storeId));
        $questionnairesCompleted = (clone $responses)->distinct()->count('r.submission_id');

        // ---- Page views per day (chart)
        $perDay = $events(SiteAnalyticsEvent::PAGE_VIEW)
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');
        $dailyViews = collect(range($days - 1, 0))->map(function ($offset) use ($perDay) {
            $day = now()->subDays($offset)->toDateString();

            return ['day' => Carbon::parse($day)->format('d M'), 'views' => (int) ($perDay[$day] ?? 0)];
        });

        // ---- Most viewed pages (the two wine-page routes count as one page)
        $topPages = $events(SiteAnalyticsEvent::PAGE_VIEW)
            ->selectRaw('route_name, COUNT(*) as views, COUNT(DISTINCT user_id) as users')
            ->groupBy('route_name')
            ->get()
            ->groupBy(fn ($row) => SiteAnalyticsEvent::pageName($row->route_name))
            ->map(fn (Collection $rows, $name) => (object) [
                'name' => $name,
                'views' => $rows->sum('views'),
                'users' => $rows->max('users'),
            ])
            ->sortByDesc('views')
            ->values();

        // ---- Most clicked links and buttons
        $topClicks = $events(SiteAnalyticsEvent::CLICK)
            ->selectRaw('label, route_name, COUNT(*) as clicks')
            ->groupBy('label', 'route_name')
            ->orderByDesc('clicks')
            ->limit(25)
            ->get()
            ->map(function ($row) {
                $row->page = SiteAnalyticsEvent::pageName($row->route_name);

                return $row;
            });

        // ---- Most viewed wines, with how often they were added to the cart
        $wineViews = $events(SiteAnalyticsEvent::PAGE_VIEW)
            ->whereNotNull('product_id')
            ->selectRaw('product_id, COUNT(*) as views, COUNT(DISTINCT user_id) as users')
            ->groupBy('product_id')
            ->orderByDesc('views')
            ->limit(20)
            ->get();
        $cartAdds = $events(SiteAnalyticsEvent::CLICK)
            ->whereNotNull('product_id')
            ->where('label', 'like', '%Add to cart%')
            ->selectRaw('product_id, COUNT(*) as adds')
            ->groupBy('product_id')
            ->pluck('adds', 'product_id');
        $wineNames = Product::whereIn('id', $wineViews->pluck('product_id')->merge($cartAdds->keys()))
            ->pluck('wine_name', 'id');
        $topWines = $wineViews->map(fn ($row) => (object) [
            'id' => $row->product_id,
            'name' => $wineNames[$row->product_id] ?? ('Wine #' . $row->product_id),
            'views' => $row->views,
            'users' => $row->users,
            'adds' => (int) ($cartAdds[$row->product_id] ?? 0),
        ]);
        $topCartAdds = $cartAdds->sortDesc()->take(10)->map(fn ($adds, $id) => (object) [
            'name' => $wineNames[$id] ?? ('Wine #' . $id),
            'adds' => $adds,
        ])->values();

        // ---- Activity by store
        $storeViews = $events(SiteAnalyticsEvent::PAGE_VIEW)
            ->selectRaw('store_id, COUNT(*) as views, COUNT(DISTINCT user_id) as users')
            ->groupBy('store_id')
            ->get()
            ->keyBy('store_id');
        $storeClicks = $events(SiteAnalyticsEvent::CLICK)
            ->selectRaw('store_id, COUNT(*) as clicks')
            ->groupBy('store_id')
            ->pluck('clicks', 'store_id');
        $stores = Store::pluck('store_name', 'id');
        $byStore = $storeViews->keys()->merge($storeClicks->keys())->unique()->map(fn ($id) => (object) [
            'name' => $id ? ($stores[$id] ?? ('Store #' . $id)) : 'No store',
            'views' => (int) ($storeViews[$id]->views ?? 0),
            'users' => (int) ($storeViews[$id]->users ?? 0),
            'clicks' => (int) ($storeClicks[$id] ?? 0),
        ])->sortByDesc('views')->values();

        // ---- Questionnaires: completions and the most chosen options
        $templateNames = DB::table('questionnaire_templates')->pluck('name', 'id');
        $questionnaires = (clone $responses)
            ->selectRaw('r.template_id, COUNT(DISTINCT r.submission_id) as completed')
            ->groupBy('r.template_id')
            ->get()
            ->map(fn ($row) => (object) [
                'name' => $templateNames[$row->template_id] ?? ('Questionnaire #' . $row->template_id),
                'completed' => $row->completed,
            ])
            ->sortByDesc('completed')
            ->values();
        $topOptions = $this->topOptions(clone $responses, $templateNames);

        $storeList = $stores->sort();
        $ranges = self::RANGES;

        return view('admin.website-health.index', compact(
            'days', 'ranges', 'storeId', 'storeList',
            'pageViews', 'clicks', 'activeUsers', 'winesViewed', 'questionnairesCompleted',
            'dailyViews', 'topPages', 'topClicks', 'topWines', 'topCartAdds', 'byStore',
            'questionnaires', 'topOptions'
        ));
    }

    /**
     * Most chosen questionnaire answers. Only real options of that questionnaire's choice
     * questions are counted, so typed answers (names, phone numbers, emails) never appear.
     */
    private function topOptions($responses, Collection $templateNames): Collection
    {
        $optionColumns = collect(\Schema::getColumnListing('questions'))
            ->filter(fn ($column) => preg_match('/^option_\d+$/', $column))
            ->values()
            ->all();

        $validOptions = [];
        DB::table('questions')
            ->whereIn('type', ['single', 'multiple'])
            ->select(array_merge(['template_id'], $optionColumns))
            ->orderBy('id')
            ->each(function ($question) use (&$validOptions, $optionColumns) {
                foreach ($optionColumns as $column) {
                    $value = trim((string) $question->{$column});
                    if ($value !== '') {
                        $validOptions[$question->template_id][$value] = true;
                    }
                }
            });

        $counts = [];
        $responses->select('r.id', 'r.template_id', 'r.answer')
            ->orderBy('r.id')
            ->chunk(2000, function ($rows) use (&$counts, $validOptions) {
                foreach ($rows as $row) {
                    $decoded = json_decode((string) $row->answer, true);
                    $values = is_array($decoded) ? $decoded : [$row->answer];

                    foreach ($values as $value) {
                        $value = trim((string) $value);
                        if ($value !== '' && isset($validOptions[$row->template_id][$value])) {
                            $key = $row->template_id . '|' . $value;
                            $counts[$key] = ($counts[$key] ?? 0) + 1;
                        }
                    }
                }
            });

        arsort($counts);

        return collect(array_slice($counts, 0, 25, true))->map(function ($times, $key) use ($templateNames) {
            [$templateId, $option] = explode('|', $key, 2);

            return (object) [
                'option' => $option,
                'questionnaire' => $templateNames[$templateId] ?? ('Questionnaire #' . $templateId),
                'times' => $times,
            ];
        })->values();
    }
}
