<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class DashboardSummarySheet implements FromArray, WithTitle
{
    protected $analyticsSummary;
    protected $questionnaireStats;
    protected $budgetStats;

    public function __construct(
        $analyticsSummary,
        $questionnaireStats,
        $budgetStats
    ) {
        $this->analyticsSummary = $analyticsSummary;
        $this->questionnaireStats = $questionnaireStats;
        $this->budgetStats = $budgetStats;
    }

    public function title(): string
    {
        return 'Dashboard Summary';
    }

    public function array(): array
    {
        $rows = [];

        /*
        |--------------------------------------------------------------------------
        | Store Summary
        |--------------------------------------------------------------------------
        */

        $rows[] = ['STORE SUMMARY'];
        $rows[] = ['Metric', 'Value'];

        $rows[] = [
            'Total Revenue',
            $this->analyticsSummary['total_revenue'] ?? 0
        ];

        $rows[] = [
            'Total Bottles Sold',
            $this->analyticsSummary['total_bottles'] ?? 0
        ];

        $rows[] = [
            'Total Orders',
            $this->analyticsSummary['total_orders'] ?? 0
        ];

        $rows[] = [
            'Average Order Value',
            $this->analyticsSummary['avg_order_value'] ?? 0
        ];

        /*
        |--------------------------------------------------------------------------
        | Spacer
        |--------------------------------------------------------------------------
        */

        $rows[] = [];
        $rows[] = [];

        /*
        |--------------------------------------------------------------------------
        | Questionnaire Summary
        |--------------------------------------------------------------------------
        */

        $rows[] = ['QUESTIONNAIRE SUMMARY'];
        $rows[] = ['Metric', 'Value'];

        $rows[] = [
            'Completed Questionnaires',
            $this->questionnaireStats['completed'] ?? 0
        ];

        $rows[] = [
            'Most Popular Questionnaire',
            $this->questionnaireStats['popular_template'] ?? '-'
        ];

        $rows[] = [
            'Responses',
            $this->questionnaireStats['popular_template_count'] ?? 0
        ];

        /*
        |--------------------------------------------------------------------------
        | Spacer
        |--------------------------------------------------------------------------
        */

        $rows[] = [];
        $rows[] = [];

        /*
        |--------------------------------------------------------------------------
        | Budget Insights
        |--------------------------------------------------------------------------
        */

        $rows[] = ['BUDGET INSIGHTS'];
        $rows[] = ['Metric', 'Value'];

        $rows[] = [
            'Average Budget',
            $this->budgetStats['average_budget'] ?? 0
        ];

        $rows[] = [
            'Premium Customers (%)',
            $this->budgetStats['premium_percent'] ?? 0
        ];

        return $rows;
    }
}