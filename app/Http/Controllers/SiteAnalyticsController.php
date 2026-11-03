<?php

namespace App\Http\Controllers;

use App\Models\SiteAnalyticsEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Receives link / button clicks from logged-in kiosk pages (assets/js/site-analytics.js).
 * Only the label of what was clicked and where it leads are stored, never anything typed.
 */
class SiteAnalyticsController extends Controller
{
    public function click(Request $request): Response
    {
        $user = $request->user();

        // Only kiosk users are measured
        if (!$user || $user->role !== 'user') {
            return response()->noContent();
        }

        $validated = $request->validate([
            'label' => ['required', 'string', 'max:150'],
            'target' => ['nullable', 'string', 'max:255'],
            'route' => ['nullable', 'string', 'max:150'],
            'path' => ['required', 'string', 'max:255'],
            'product_id' => ['nullable', 'integer'],
        ]);

        SiteAnalyticsEvent::create([
            'event' => SiteAnalyticsEvent::CLICK,
            'user_id' => $user->id,
            'store_id' => $user->store_id,
            'route_name' => $validated['route'] ?? null,
            'path' => $validated['path'],
            'label' => trim(preg_replace('/\s+/', ' ', $validated['label'])),
            'target' => $validated['target'] ?? null,
            'product_id' => $validated['product_id'] ?? null,
        ]);

        return response()->noContent();
    }
}
