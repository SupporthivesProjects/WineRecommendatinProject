<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class StoreAnalyticsSheet implements FromArray, WithTitle
{
    protected $topSellingWines;
    protected $revenueTrend;
    protected $wineTypeDistribution;
    protected $countryDistribution;
    protected $priceBandAnalytics;
    protected $domesticImportedSplit;
    protected $averageBottleValueTrend;

    public function __construct(
        $topSellingWines,
        $revenueTrend,
        $wineTypeDistribution,
        $countryDistribution,
        $priceBandAnalytics,
        $domesticImportedSplit,
        $averageBottleValueTrend
    ) {
        $this->topSellingWines = $topSellingWines;
        $this->revenueTrend = $revenueTrend;
        $this->wineTypeDistribution = $wineTypeDistribution;
        $this->countryDistribution = $countryDistribution;
        $this->priceBandAnalytics = $priceBandAnalytics;
        $this->domesticImportedSplit = $domesticImportedSplit;
        $this->averageBottleValueTrend = $averageBottleValueTrend;
    }

    public function title(): string
    {
        return 'Store Analytics';
    }

    public function array(): array
    {
        $rows = [];

        $this->addSection(
            $rows,
            'Top Selling Wines',
            ['Wine', 'Bottles Sold'],
            $this->topSellingWines,
            ['product_name', 'total_sold']
        );

        $this->addSection(
            $rows,
            'Revenue Trend',
            ['Date', 'Revenue'],
            $this->revenueTrend,
            ['sale_date', 'revenue']
        );

        $this->addSection(
            $rows,
            'Wine Type Distribution',
            ['Wine Type', 'Sold'],
            $this->wineTypeDistribution,
            ['type', 'total_sold']
        );

        $this->addSection(
            $rows,
            'Country Distribution',
            ['Country', 'Sold'],
            $this->countryDistribution,
            ['country', 'total_sold']
        );

        $this->addSection(
            $rows,
            'Price Band Analytics',
            ['Price Band', 'Quantity'],
            $this->priceBandAnalytics,
            ['band', 'qty']
        );

        $this->addSection(
            $rows,
            'Domestic vs Imported',
            ['Category', 'Quantity'],
            $this->domesticImportedSplit,
            ['label', 'qty']
        );

        $this->addSection(
            $rows,
            'Average Bottle Value Trend',
            ['Date', 'Average Price'],
            $this->averageBottleValueTrend,
            ['sale_date', 'avg_price']
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

                if (is_array($item)) {
                    $row[] = $item[$field] ?? '';
                } else {
                    $row[] = $item->{$field} ?? '';
                }

            }

            $rows[] = $row;
        }
    }
}