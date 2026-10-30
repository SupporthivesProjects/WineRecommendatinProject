<?php

namespace App\View;

/**
 * Works out which heavy front-end libraries a dashboard page actually needs,
 * so the layouts only load them on those pages.
 */
class PageLibraries
{
    /**
     * @param  string  $pageContent  The page's rendered content section plus its pushed scripts.
     * @return array{tables: bool, apexcharts: bool, chartjs: bool, jqueryui: bool}
     */
    public static function detect(string $pageContent): array
    {
        return [
            // The layout turns every <table> into a DataTable with export buttons
            'tables' => str_contains($pageContent, '<table') || preg_match('/\.(DataTable|dataTable)\s*\(/', $pageContent) === 1,

            // assets/js/index.js draws ApexCharts into these template ids
            'apexcharts' => str_contains($pageContent, 'ApexCharts')
                || preg_match('/id=["\'](ongoingprojects2?|todaytask|today-task|website-design|websitedesign|project)["\']/', $pageContent) === 1,

            // assets/js/chartjs-charts.js draws into the chartjs-* ids and sets Chart.js colour defaults
            'chartjs' => preg_match('/new\s+Chart\s*\(|id=["\']chartjs-/', $pageContent) === 1,

            'jqueryui' => preg_match('/\.(slider|datepicker|sortable|draggable|droppable|autocomplete|resizable|dialog|selectable)\s*\(|ui-slider/', $pageContent) === 1,
        ];
    }
}
