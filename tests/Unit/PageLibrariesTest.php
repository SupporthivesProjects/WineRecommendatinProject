<?php

namespace Tests\Unit;

use App\View\PageLibraries;
use PHPUnit\Framework\TestCase;

class PageLibrariesTest extends TestCase
{
    public function test_plain_page_needs_no_heavy_libraries(): void
    {
        $this->assertSame(
            ['tables' => false, 'apexcharts' => false, 'chartjs' => false, 'jqueryui' => false],
            PageLibraries::detect('<form><input name="wine_name"></form><script>toastr.success("ok")</script>')
        );
    }

    public function test_any_table_or_datatable_call_needs_datatables(): void
    {
        $this->assertTrue(PageLibraries::detect('<table class="table"></table>')['tables']);
        $this->assertTrue(PageLibraries::detect('<script>$("#x").DataTable({})</script>')['tables']);
    }

    public function test_chart_libraries_are_detected(): void
    {
        $this->assertTrue(PageLibraries::detect('new ApexCharts(el, options)')['apexcharts']);
        $this->assertTrue(PageLibraries::detect('<div id="todaytask"></div>')['apexcharts']);
        $this->assertTrue(PageLibraries::detect('const c = new Chart(ctx, cfg)')['chartjs']);
        $this->assertTrue(PageLibraries::detect('<canvas id="chartjs-line"></canvas>')['chartjs']);
    }

    public function test_jquery_ui_slider_is_detected(): void
    {
        $this->assertTrue(PageLibraries::detect('$("#price-slider").slider({range: true})')['jqueryui']);
    }
}
