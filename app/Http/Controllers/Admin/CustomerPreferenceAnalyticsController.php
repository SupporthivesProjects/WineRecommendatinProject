<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class CustomerPreferenceAnalyticsController
{
    private static function getStoreUserIds($storeId)
    {
        return User::where(
            'store_id',
            $storeId
        )->pluck('id');
    }

    private static function applyDateFilter(
        $query,
        $range
    )
    {
        switch ($range) {

            case 'today':

                $query->whereDate(
                    'created_at',
                    today()
                );

                break;

            case '7days':

                $query->where(
                    'created_at',
                    '>=',
                    now()->subDays(7)
                );

                break;

            case '30days':

                $query->where(
                    'created_at',
                    '>=',
                    now()->subDays(30)
                );

                break;

            case 'month':

                $query->whereMonth(
                    'created_at',
                    now()->month
                )->whereYear(
                    'created_at',
                    now()->year
                );

                break;

            case 'year':

                $query->whereYear(
                    'created_at',
                    now()->year
                );

                break;

            case 'custom':

                if (
                    request('from') &&
                    request('to')
                ) {

                    $query->whereBetween(
                        'created_at',
                        [
                            request('from') . ' 00:00:00',
                            request('to') . ' 23:59:59'
                        ]
                    );
                }

                break;
        }

        return $query;
    }

    public static function getQuestionnaireStats(
        $storeId,
        $range = 'all'
    )
    {
        $userIds =
            self::getStoreUserIds(
                $storeId
            );

        $query = DB::table(
            'question_responses'
        )
        ->whereIn(
            'user_id',
            $userIds
        );

        self::applyDateFilter(
            $query,
            $range
        );

        $completed = (clone $query)
            ->distinct('submission_id')
            ->count('submission_id');

        $popularTemplate = (clone $query)
            ->select(
                'template_id',
                DB::raw(
                    'COUNT(DISTINCT submission_id) as total'
                )
            )
            ->groupBy(
                'template_id'
            )
            ->orderByDesc(
                'total'
            )
            ->first();

        return [

            'completed' =>
                $completed,

            'popular_template' =>
                $popularTemplate->template_id ?? '-',

            'popular_template_count' =>
                $popularTemplate->total ?? 0

        ];
    }


    public static function getQuestionnaireUsage(
        $storeId,
        $range = 'all'
    )
    {
        $userIds =
            self::getStoreUserIds(
                $storeId
            );
    
        $query = DB::table(
            'question_responses as qr'
        )
        ->join(
            'questionnaire_templates as t',
            't.id',
            '=',
            'qr.template_id'
        )
        ->whereIn(
            'qr.user_id',
            $userIds
        );
    
        self::applyDateFilter(
            $query,
            $range
        );
    
        return $query
            ->select(
                't.name',
                DB::raw(
                    'COUNT(DISTINCT qr.submission_id) as total'
                )
            )
            ->groupBy(
                't.name'
            )
            ->orderByDesc(
                'total'
            )
            ->get();
    }

    public static function getWineTypePreferences(
        $storeId,
        $range = 'all'
    )
    {
        $userIds =
            self::getStoreUserIds(
                $storeId
            );
    
        $query = DB::table(
            'question_responses as qr'
        )
        ->join(
            'questions as q',
            function ($join) {
    
                $join->on(
                    'q.template_id',
                    '=',
                    'qr.template_id'
                );
    
            }
        )
        ->whereIn(
            'qr.user_id',
            $userIds
        )
        ->where(function ($q) {
    
            $q->where(
                'q.question',
                'like',
                '%type of wine%'
            )
            ->orWhere(
                'q.question',
                'like',
                '%wine are you looking%'
            )
            ->orWhere(
                'q.question',
                'like',
                '%wine are you in the mood%'
            );
    
        });
    
        self::applyDateFilter(
            $query,
            $range
        );
    
        return $query
            ->select(
                'qr.answer',
                DB::raw(
                    'COUNT(*) as total'
                )
            )
            ->groupBy(
                'qr.answer'
            )
            ->orderByDesc(
                'total'
            )
            ->get();
    }

    public static function getCountryPreferences(
        $storeId,
        $range = 'all'
    )
    {
        $userIds = self::getStoreUserIds($storeId);
    
        $query = DB::table('question_responses as qr')
            ->join('questions as q', function ($join) {
                $join->on('q.template_id', '=', 'qr.template_id');
            })
            ->whereIn('qr.user_id', $userIds)
            ->where('q.question', 'like', '%country%');
    
        self::applyDateFilter($query, $range);
    
        return $query
            ->select(
                'qr.answer',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('qr.answer')
            ->orderByDesc('total')
            ->get();
    }

    public static function getBudgetDistribution(
        $storeId,
        $range = 'all'
    )
    {
        $userIds = self::getStoreUserIds($storeId);
    
        $query = DB::table('question_responses as qr')
            ->join('questions as q', function ($join) {
                $join->on('q.template_id', '=', 'qr.template_id');
            })
            ->whereIn('qr.user_id', $userIds)
            ->where(function ($q) {
    
                $q->where('q.question', 'like', '%budget%')
                  ->orWhere('q.question', 'like', '%price range%');
    
            });
    
        self::applyDateFilter($query, $range);
    
        return $query
            ->select(
                'qr.answer',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('qr.answer')
            ->orderByDesc('total')
            ->get();
    }

    public static function getOccasionPreferences(
        $storeId,
        $range = 'all'
    )
    {
        $userIds = self::getStoreUserIds($storeId);
    
        $query = DB::table('question_responses as qr')
            ->join('questions as q', function ($join) {
                $join->on('q.template_id', '=', 'qr.template_id');
            })
            ->whereIn('qr.user_id', $userIds)
            ->where('q.question', 'like', '%occasion%');
    
        self::applyDateFilter($query, $range);
    
        return $query
            ->select(
                'qr.answer',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('qr.answer')
            ->orderByDesc('total')
            ->get();
    }

    public static function getTastePreferences(
        $storeId,
        $range = 'all'
    )
    {
        $userIds = self::getStoreUserIds($storeId);
    
        $query = DB::table('question_responses as qr')
            ->join('questions as q', function ($join) {
                $join->on('q.template_id', '=', 'qr.template_id');
            })
            ->whereIn('qr.user_id', $userIds)
            ->where(function ($q) {
    
                $q->where('q.question', 'like', '%taste%')
                  ->orWhere('q.question', 'like', '%sweet%')
                  ->orWhere('q.question', 'like', '%dry%');
    
            });
    
        self::applyDateFilter($query, $range);
    
        return $query
            ->select(
                'qr.answer',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('qr.answer')
            ->orderByDesc('total')
            ->get();
    }

    public static function getTopVarieties(
        $storeId,
        $range = 'all'
    )
    {
        $userIds = self::getStoreUserIds($storeId);
    
        $query = DB::table('question_responses as qr')
            ->join('questions as q', function ($join) {
                $join->on('q.template_id', '=', 'qr.template_id');
            })
            ->whereIn('qr.user_id', $userIds)
            ->where(function ($q) {
    
                $q->where('q.question', 'like', '%grape%')
                  ->orWhere('q.question', 'like', '%variet%');
    
            });
    
        self::applyDateFilter($query, $range);
    
        return $query
            ->select(
                'qr.answer',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('qr.answer')
            ->orderByDesc('total')
            ->limit(10)
            ->get();
    }

    public static function getBudgetStats($storeId,$range = 'all')
    {
        $userIds =
            self::getStoreUserIds(
                $storeId
            );
    
        $query = DB::table(
            'question_responses as qr'
        )
        ->join(
            'questions as q',
            function ($join) {
    
                $join->on(
                    'q.template_id',
                    '=',
                    'qr.template_id'
                );
    
            }
        )
        ->whereIn(
            'qr.user_id',
            $userIds
        )
        ->where(function ($q) {
    
            $q->where(
                'q.question',
                'like',
                '%budget%'
            )
            ->orWhere(
                'q.question',
                'like',
                '%price range%'
            );
    
        });
    


        self::applyDateFilter(
            $query,
            $range
        );
    
        $answers =
            $query->pluck(
                'qr.answer'
            );
    
        $values = [];
    
        foreach ($answers as $answer) {
    
            preg_match_all(
                '/\d+/',
                $answer,
                $matches
            );
    
            $numbers =
                $matches[0] ?? [];
    
            if (
                count($numbers) >= 2
            ) {
    
                $values[] =
                    (
                        $numbers[0]
                        +
                        $numbers[1]
                    ) / 2;
            }
        }
    
        $average =
            count($values)
                ? round(
                    array_sum($values)
                    / count($values)
                )
                : 0;
    
        $premium =
            collect($values)
            ->filter(
                fn($v) => $v >= 5000
            )
            ->count();
    
        $premiumPercent =
            count($values)
                ? round(
                    ($premium
                    /
                    count($values))
                    * 100
                )
                : 0;
    
        return [
    
            'average_budget' =>
                $average,
    
            'premium_percent' =>
                $premiumPercent
    
        ];
    }
}