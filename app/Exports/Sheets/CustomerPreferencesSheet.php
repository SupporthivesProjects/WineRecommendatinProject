<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class CustomerPreferencesSheet implements FromArray, WithTitle
{
    protected $questionnaireUsage;
    protected $wineTypePreferences;
    protected $countryPreferences;
    protected $budgetDistribution;
    protected $occasionPreferences;
    protected $tastePreferences;
    protected $topVarieties;
    protected $occasionBudgetPreferences;

    public function __construct(
        $questionnaireUsage,
        $wineTypePreferences,
        $countryPreferences,
        $budgetDistribution,
        $occasionPreferences,
        $tastePreferences,
        $topVarieties,
        $occasionBudgetPreferences
    ) {
        $this->questionnaireUsage = $questionnaireUsage;
        $this->wineTypePreferences = $wineTypePreferences;
        $this->countryPreferences = $countryPreferences;
        $this->budgetDistribution = $budgetDistribution;
        $this->occasionPreferences = $occasionPreferences;
        $this->tastePreferences = $tastePreferences;
        $this->topVarieties = $topVarieties;
        $this->occasionBudgetPreferences = $occasionBudgetPreferences;
    }

    public function title(): string
    {
        return 'Customer Preferences';
    }

    public function array(): array
    {
        $rows = [];

        $this->addSection(
            $rows,
            'Questionnaire Usage',
            ['Questionnaire', 'Responses'],
            $this->questionnaireUsage,
            ['name', 'total']
        );

        $this->addSection(
            $rows,
            'Wine Type Preferences',
            ['Wine Type', 'Responses'],
            $this->wineTypePreferences,
            ['answer', 'total']
        );

        $this->addSection(
            $rows,
            'Country Preferences',
            ['Country', 'Responses'],
            $this->countryPreferences,
            ['answer', 'total']
        );

        $this->addSection(
            $rows,
            'Budget Distribution',
            ['Budget Band', 'Responses'],
            $this->budgetDistribution,
            ['answer', 'total']
        );

        $this->addSection(
            $rows,
            'Occasion Preferences',
            ['Occasion', 'Responses'],
            $this->occasionPreferences,
            ['answer', 'total']
        );

        $this->addSection(
            $rows,
            'Taste Preferences',
            ['Taste', 'Responses'],
            $this->tastePreferences,
            ['answer', 'total']
        );

        $this->addSection(
            $rows,
            'Top Varieties',
            ['Variety', 'Responses'],
            $this->topVarieties,
            ['answer', 'total']
        );

        $this->addSection(
            $rows,
            'Occasion Budget Preferences',
            ['Occasion', 'Preferred Budget', 'Responses'],
            $this->occasionBudgetPreferences,
            ['occasion', 'budget_band', 'responses']
        );

        return $rows;
    }

    private function addSection(&$rows, $title, $headers, $collection, $fields)
    {
        if (count($rows)) {
            $rows[] = [];
            $rows[] = [];
        }

        $rows[] = [$title];
        $rows[] = $headers;

        foreach ($collection as $item) {

            $row = [];

            foreach ($fields as $field) {
                $row[] = $item->{$field} ?? '';
            }

            $rows[] = $row;
        }
    }
}