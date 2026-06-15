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
        $range,
        $dateColumn = 'created_at'
    )
    {
        switch ($range) {
    
            case 'today':
                $query->whereDate(
                    $dateColumn,
                    today()
                );
                break;
    
            case '7days':
                $query->where(
                    $dateColumn,
                    '>=',
                    now()->subDays(7)
                );
                break;
    
            case '30days':
                $query->where(
                    $dateColumn,
                    '>=',
                    now()->subDays(30)
                );
                break;
    
            case 'month':
                $query->whereMonth(
                    $dateColumn,
                    now()->month
                )->whereYear(
                    $dateColumn,
                    now()->year
                );
                break;
    
            case 'year':
                $query->whereYear(
                    $dateColumn,
                    now()->year
                );
                break;
    
            case 'custom':
                if (
                    request('from')
                    &&
                    request('to')
                ) {
                    $query->whereBetween(
                        $dateColumn,
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

    public static function getQuestionnaireStats($storeId,$range = 'all')
    {
        $userIds =self::getStoreUserIds($storeId);

        $query = DB::table('question_responses')
        ->whereIn('user_id',$userIds);

        self::applyDateFilter($query,$range);

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

        return ['completed' =>$completed,
            'popular_template' =>
                $popularTemplate->template_id ?? '-',

            'popular_template_count' =>
                $popularTemplate->total ?? 0
        ];
    }


    public static function getQuestionnaireUsage($storeId,$range = 'all')
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
            $range,
            'qr.created_at'
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

    public static function getWineTypePreferences($storeId,$range = 'all')
    {
        $userIds = self::getStoreUserIds($storeId);

        $mappings = self::getQuestionMappings('wine_type');

        $query = DB::table('question_responses as qr')
            ->whereIn('qr.user_id', $userIds);

        self::applyDateFilter(
            $query,
            $range,
            'qr.created_at'
        );

        $query->where(function ($q) use ($mappings) {

            foreach ($mappings as $mapping) {

                $q->orWhere(function ($sub) use ($mapping) {

                    $sub->where(
                        'qr.template_id',
                        $mapping->template_id
                    )
                    ->where(
                        'qr.question_key',
                        $mapping->question_key
                    );

                });
            }
        });


        $results = $query
            ->select(
                'qr.answer',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('qr.answer')
            ->orderByDesc('total')
            ->get();

        $results->transform(function ($item) {

            $decoded = json_decode($item->answer, true);

            if (is_array($decoded) && count($decoded)) {
                $item->answer = $decoded[0];
            }

            return $item;
        });

        return $results;
    }

    public static function getCountryPreferences($storeId,$range = 'all')
    {
        $userIds = self::getStoreUserIds($storeId);

        $mappings = self::getQuestionMappings('country');

        $query = DB::table('question_responses as qr')
            ->whereIn('qr.user_id', $userIds);

        self::applyDateFilter(
            $query,
            $range,
            'qr.created_at'
        );

        $query->where(function ($q) use ($mappings) {

            foreach ($mappings as $mapping) {

                $q->orWhere(function ($sub) use ($mapping) {

                    $sub->where(
                        'qr.template_id',
                        $mapping->template_id
                    )
                    ->where(
                        'qr.question_key',
                        $mapping->question_key
                    );

                });
            }
        });

        $results = $query
            ->select(
                'qr.answer',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('qr.answer')
            ->orderByDesc('total')
            ->get();

        $results->transform(function ($item) {

            $decoded = json_decode(
                $item->answer,
                true
            );

            if (
                is_array($decoded)
                && count($decoded)
            ) {
                $item->answer = $decoded[0];
            }

            return $item;
        });

        return $results;
    }
    public static function getBudgetDistribution($storeId,$range = 'all')
    {
        $answers = self::getAnswersByType(
            $storeId,
            'budget',
            $range
        )->pluck('answer');

        $bands = [
            '0-25K'      => 0,
            '25K-50K'    => 0,
            '50K-75K'    => 0,
            '75K-100K'   => 0,
            '100K+'      => 0,
        ];

        foreach ($answers as $answer) {

            $value = (float) preg_replace(
                '/[^\d.]/',
                '',
                (string) $answer
            );

            if ($value <= 25000) {
                $bands['0-25K']++;
            }
            elseif ($value <= 50000) {
                $bands['25K-50K']++;
            }
            elseif ($value <= 75000) {
                $bands['50K-75K']++;
            }
            elseif ($value <= 100000) {
                $bands['75K-100K']++;
            }
            else {
                $bands['100K+']++;
            }
        }

        return collect($bands)
            ->map(function ($total, $range) {
                return (object) [
                    'answer' => $range,
                    'total'  => $total
                ];
            })
            ->values();
    }

    public static function getOccasionPreferences($storeId,$range = 'all')
    {
        $userIds = self::getStoreUserIds($storeId);

        $mappings = self::getQuestionMappings('occasion');

        $query = DB::table('question_responses as qr')
            ->whereIn('qr.user_id', $userIds);

        self::applyDateFilter(
            $query,
            $range,
            'qr.created_at'
        );

        $query->where(function ($q) use ($mappings) {

            foreach ($mappings as $mapping) {

                $q->orWhere(function ($sub) use ($mapping) {

                    $sub->where(
                        'qr.template_id',
                        $mapping->template_id
                    )
                    ->where(
                        'qr.question_key',
                        $mapping->question_key
                    );

                });
            }
        });

        $results = $query
            ->select(
                'qr.answer',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('qr.answer')
            ->orderByDesc('total')
            ->get();

        $results->transform(function ($item) {

            $decoded = json_decode(
                $item->answer,
                true
            );

            if (
                is_array($decoded)
                && count($decoded)
            ) {
                $item->answer = implode(', ', $decoded);
            }

            return $item;
        });

        return $results;
    }

    public static function getTastePreferences($storeId,$range = 'all')
    {
        $userIds = self::getStoreUserIds($storeId);

        $mappings = self::getQuestionMappings('taste');

        $query = DB::table('question_responses as qr')
            ->whereIn('qr.user_id', $userIds);

        self::applyDateFilter(
            $query,
            $range,
            'qr.created_at'
        );

        $query->where(function ($q) use ($mappings) {

            foreach ($mappings as $mapping) {

                $q->orWhere(function ($sub) use ($mapping) {

                    $sub->where(
                        'qr.template_id',
                        $mapping->template_id
                    )
                    ->where(
                        'qr.question_key',
                        $mapping->question_key
                    );

                });
            }
        });

        $results = $query
            ->select(
                'qr.answer',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('qr.answer')
            ->orderByDesc('total')
            ->get();

        $results->transform(function ($item) {

            $decoded = json_decode(
                $item->answer,
                true
            );

            if (
                is_array($decoded)
                && count($decoded)
            ) {
                $item->answer = implode(', ', $decoded);
            }

            return $item;
        });

        return $results;
    }

    public static function getTopVarieties($storeId,$range = 'all')
    {
        $userIds = self::getStoreUserIds($storeId);

        $mappings = self::getQuestionMappings('variety');

        $query = DB::table('question_responses as qr')
            ->whereIn('qr.user_id', $userIds);

        self::applyDateFilter(
            $query,
            $range,
            'qr.created_at'
        );

        $query->where(function ($q) use ($mappings) {

            foreach ($mappings as $mapping) {

                $q->orWhere(function ($sub) use ($mapping) {

                    $sub->where(
                        'qr.template_id',
                        $mapping->template_id
                    )
                    ->where(
                        'qr.question_key',
                        $mapping->question_key
                    );

                });

            }

        });

        $results = $query
            ->select(
                'qr.answer',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('qr.answer')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $results->transform(function ($item) {

            $decoded = json_decode(
                $item->answer,
                true
            );

            if (
                is_array($decoded)
                && count($decoded)
            ) {
                $item->answer = implode(', ', $decoded);
            }

            return $item;
        });

        return $results;
    }

    public static function getBudgetStats($storeId,$range = 'all')
    {
        $userIds =self::getStoreUserIds($storeId);
    
        $mappings = self::getQuestionMappings('budget');

        $query = DB::table('question_responses')
            ->whereIn('user_id', $userIds);
        
        self::applyDateFilter($query,$range);

        
        
        $query->where(function ($q) use ($mappings) {
            foreach ($mappings as $mapping) {
                $q->orWhere(function ($sub) use ($mapping) {
                    $sub->where(
                        'template_id',
                        $mapping->template_id
                    )
                    ->where(
                        'question_key',
                        $mapping->question_key
                    );
                });
            }
        });

        $answers = $query->pluck('answer');
        $values = [];
        $values = collect($answers)
        ->map(function ($answer) {
            $value = preg_replace(
                '/[^\d.]/',
                '',
                (string) $answer
            );
            return is_numeric($value)
                ? (float) $value
                : 0;
        })
        ->filter(fn ($value) => $value > 0)
        ->values()
        ->toArray();
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
                fn($v) => $v >= 25000
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

    private static function getQuestionMappings($questionType)
    {
        return DB::table('question_mappings')
            ->where('question_type', $questionType)
            ->where('is_active', 1)
            ->get();
    }


    private static function getAnswersByType(
        $storeId,
        $questionType,
        $range = 'all'
    )
    {
        $userIds =
            self::getStoreUserIds(
                $storeId
            );
    
        $mappings =
            self::getQuestionMappings(
                $questionType
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
    
        $query->where(function ($q) use ($mappings) {
    
            foreach ($mappings as $mapping) {
    
                $q->orWhere(function ($sub) use ($mapping) {
    
                    $sub->where(
                        'template_id',
                        $mapping->template_id
                    )
                    ->where(
                        'question_key',
                        $mapping->question_key
                    );
    
                });
    
            }
    
        });
    
        return $query;
    }

    public static function getOccasionBudgetPreferences(
        $storeId,
        $range = 'all'
    )
    {
        $occasions = self::getAnswersByType(
            $storeId,
            'occasion',
            $range
        )
        ->select(
            'submission_id',
            'answer'
        )
        ->get()
        ->keyBy('submission_id');
    
        $budgets = self::getAnswersByType(
            $storeId,
            'budget',
            $range
        )
        ->select(
            'submission_id',
            'answer'
        )
        ->get();
    
        $data = [];
    
        foreach ($budgets as $budget) {
    
            if (
                !isset(
                    $occasions[$budget->submission_id]
                )
            ) {
                continue;
            }
    
            $occasion =
                $occasions[
                    $budget->submission_id
                ]->answer;
    
            $decoded =
                json_decode(
                    $occasion,
                    true
                );
    
            if (
                is_array($decoded)
                &&
                count($decoded)
            ) {
                $occasion =
                    implode(
                        ', ',
                        $decoded
                    );
            }
    
            $value = (float) preg_replace(
                '/[^\d.]/',
                '',
                (string) $budget->answer
            );
    
            if ($value <= 25000) {
                $band = '0-25K';
            }
            elseif ($value <= 50000) {
                $band = '25K-50K';
            }
            elseif ($value <= 75000) {
                $band = '50K-75K';
            }
            elseif ($value <= 100000) {
                $band = '75K-100K';
            }
            else {
                $band = '100K+';
            }
    
            $data[$occasion][$band] =
                ($data[$occasion][$band] ?? 0)
                + 1;
        }
    
        $results = [];
    
        foreach ($data as $occasion => $bands) {
    
            arsort($bands);
    
            $results[] = (object)[
                'occasion' => $occasion,
                'budget_band' => array_key_first($bands),
                'responses' => reset($bands)
            ];
        }
    
        return collect($results)
            ->sortByDesc('responses')
            ->values();
    }
    


}