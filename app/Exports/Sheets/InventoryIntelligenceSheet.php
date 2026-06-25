<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class InventoryIntelligenceSheet implements FromArray, WithTitle
{
    protected $slowMovingWines;
    protected $lowStockWines;
    protected $highStockLowMovement;
    protected $reorderAttentionList;
    protected $promotionList;

    public function __construct(
        $slowMovingWines,
        $lowStockWines,
        $highStockLowMovement,
        $reorderAttentionList,
        $promotionList
    ) {
        $this->slowMovingWines = $slowMovingWines;
        $this->lowStockWines = $lowStockWines;
        $this->highStockLowMovement = $highStockLowMovement;
        $this->reorderAttentionList = $reorderAttentionList;
        $this->promotionList = $promotionList;
    }

    public function title(): string
    {
        return 'Inventory Intelligence';
    }

    public function array(): array
    {
        $rows = [];

        $this->addSection(
            $rows,
            'Slow Moving Wines',
            ['Wine', 'Bottles Sold'],
            $this->slowMovingWines,
            ['product_name', 'total_sold']
        );

        $this->addSection(
            $rows,
            'Low Stock Wines',
            ['Wine', 'Current Stock'],
            $this->lowStockWines,
            ['product_name', 'stock']
        );

        $this->addSection(
            $rows,
            'High Stock Low Movement',
            ['Wine', 'Current Stock', 'Sold'],
            $this->highStockLowMovement,
            ['product_name', 'stock', 'sold']
        );

        $this->addSection(
            $rows,
            'Reorder Attention List',
            ['Wine', 'Current Stock', 'Sold'],
            $this->reorderAttentionList,
            ['product_name', 'stock', 'sold']
        );

        $this->addSection(
            $rows,
            'Promotion Candidates',
            ['Wine', 'Current Stock', 'Sold'],
            $this->promotionList,
            ['product_name', 'stock', 'sold']
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