<?php

namespace App\Exports;

use App\Exports\Sheets\CustomerPreferencesSheet;
use App\Exports\Sheets\DashboardSummarySheet;
use App\Exports\Sheets\InventoryIntelligenceSheet;
use App\Exports\Sheets\StoreAnalyticsSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AnalyticsExport implements WithMultipleSheets
{
    protected $analyticsSummary;
    protected $questionnaireStats;
    protected $budgetStats;

    protected $questionnaireUsage;
    protected $wineTypePreferences;
    protected $countryPreferences;
    protected $budgetDistribution;
    protected $occasionPreferences;
    protected $tastePreferences;
    protected $topVarieties;
    protected $occasionBudgetPreferences;

    protected $topSellingWines;
    protected $revenueTrend;
    protected $wineTypeDistribution;
    protected $countryDistribution;
    protected $priceBandAnalytics;
    protected $domesticImportedSplit;
    protected $averageBottleValueTrend;

    protected $slowMovingWines;
    protected $lowStockWines;
    protected $highStockLowMovement;
    protected $reorderAttentionList;
    protected $promotionList;

    public function __construct(
        $analyticsSummary,
        $questionnaireStats,
        $budgetStats,

        $questionnaireUsage,
        $wineTypePreferences,
        $countryPreferences,
        $budgetDistribution,
        $occasionPreferences,
        $tastePreferences,
        $topVarieties,
        $occasionBudgetPreferences,

        $topSellingWines,
        $revenueTrend,
        $wineTypeDistribution,
        $countryDistribution,
        $priceBandAnalytics,
        $domesticImportedSplit,
        $averageBottleValueTrend,

        $slowMovingWines,
        $lowStockWines,
        $highStockLowMovement,
        $reorderAttentionList,
        $promotionList
    )
    {
        $this->analyticsSummary = $analyticsSummary;
        $this->questionnaireStats = $questionnaireStats;
        $this->budgetStats = $budgetStats;

        $this->questionnaireUsage = $questionnaireUsage;
        $this->wineTypePreferences = $wineTypePreferences;
        $this->countryPreferences = $countryPreferences;
        $this->budgetDistribution = $budgetDistribution;
        $this->occasionPreferences = $occasionPreferences;
        $this->tastePreferences = $tastePreferences;
        $this->topVarieties = $topVarieties;
        $this->occasionBudgetPreferences = $occasionBudgetPreferences;

        $this->topSellingWines = $topSellingWines;
        $this->revenueTrend = $revenueTrend;
        $this->wineTypeDistribution = $wineTypeDistribution;
        $this->countryDistribution = $countryDistribution;
        $this->priceBandAnalytics = $priceBandAnalytics;
        $this->domesticImportedSplit = $domesticImportedSplit;
        $this->averageBottleValueTrend = $averageBottleValueTrend;

        $this->slowMovingWines = $slowMovingWines;
        $this->lowStockWines = $lowStockWines;
        $this->highStockLowMovement = $highStockLowMovement;
        $this->reorderAttentionList = $reorderAttentionList;
        $this->promotionList = $promotionList;
    }

    public function sheets(): array
    {
        return [

            new DashboardSummarySheet(
                $this->analyticsSummary,
                $this->questionnaireStats,
                $this->budgetStats
            ),

            new CustomerPreferencesSheet(
                $this->questionnaireUsage,
                $this->wineTypePreferences,
                $this->countryPreferences,
                $this->budgetDistribution,
                $this->occasionPreferences,
                $this->tastePreferences,
                $this->topVarieties,
                $this->occasionBudgetPreferences
            ),

            new StoreAnalyticsSheet(
                $this->topSellingWines,
                $this->revenueTrend,
                $this->wineTypeDistribution,
                $this->countryDistribution,
                $this->priceBandAnalytics,
                $this->domesticImportedSplit,
                $this->averageBottleValueTrend
            ),

            new InventoryIntelligenceSheet(
                $this->slowMovingWines,
                $this->lowStockWines,
                $this->highStockLowMovement,
                $this->reorderAttentionList,
                $this->promotionList
            )

        ];
    }
}