@extends('layouts.bootdashboard')
@section('title', 'Website Health')

@section('admindashboardcontent')
    @push('styles')
    <style>
        .health-stat-card {
            height: 100%;
        }

        .health-stat-number {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 0;
        }

        .health-stat-label {
            color: #6c757d;
            margin-bottom: 8px;
        }

        .health-share {
            min-width: 120px;
        }

        .health-share .progress {
            height: 6px;
        }

        .health-note {
            font-size: 12px;
            color: #6c757d;
        }
    </style>
    @endpush

    <div class="main-content app-content">
        <div class="container-fluid">

            {{-- Page header --}}
            <div class="d-md-flex d-block align-items-center
                        justify-content-between page-header-breadcrumb mb-4">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">
                        Website Health
                    </h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Website Health
                        </li>
                    </ol>
                </div>

                {{-- Period and store --}}
                <form method="GET" action="{{ route('admin.website-health') }}" class="d-flex flex-wrap gap-2 mt-3 mt-md-0">
                    <select name="days" class="form-select" style="width:auto" aria-label="Period">
                        @foreach ($ranges as $value => $label)
                            <option value="{{ $value }}" @selected($days === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <select name="store_id" class="form-select" style="width:auto" aria-label="Store">
                        <option value="">All stores</option>
                        @foreach ($storeList as $id => $name)
                            <option value="{{ $id }}" @selected($storeId === $id)>{{ $name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">
                        <i class="fe fe-filter me-1"></i> Apply
                    </button>
                </form>
            </div>

            {{-- Summary cards --}}
            <div class="row g-3 mb-4">
                <div class="col-xl col-md-4 col-sm-6">
                    <div class="card custom-card health-stat-card">
                        <div class="card-body">
                            <p class="health-stat-label">Page views</p>
                            <h3 class="health-stat-number">{{ number_format($pageViews) }}</h3>
                            <small class="text-muted">Pages opened by kiosk users</small>
                        </div>
                    </div>
                </div>
                <div class="col-xl col-md-4 col-sm-6">
                    <div class="card custom-card health-stat-card">
                        <div class="card-body">
                            <p class="health-stat-label">Clicks</p>
                            <h3 class="health-stat-number">{{ number_format($clicks) }}</h3>
                            <small class="text-muted">Links and buttons pressed</small>
                        </div>
                    </div>
                </div>
                <div class="col-xl col-md-4 col-sm-6">
                    <div class="card custom-card health-stat-card">
                        <div class="card-body">
                            <p class="health-stat-label">Active kiosk accounts</p>
                            <h3 class="health-stat-number">{{ number_format($activeUsers) }}</h3>
                            <small class="text-muted">Store logins that opened a page</small>
                        </div>
                    </div>
                </div>
                <div class="col-xl col-md-6 col-sm-6">
                    <div class="card custom-card health-stat-card">
                        <div class="card-body">
                            <p class="health-stat-label">Questionnaires completed</p>
                            <h3 class="health-stat-number text-success">{{ number_format($questionnairesCompleted) }}</h3>
                            <small class="text-muted">Submitted questionnaires</small>
                        </div>
                    </div>
                </div>
                <div class="col-xl col-md-6 col-sm-12">
                    <div class="card custom-card health-stat-card">
                        <div class="card-body">
                            <p class="health-stat-label">Different wines viewed</p>
                            <h3 class="health-stat-number">{{ number_format($winesViewed) }}</h3>
                            <small class="text-muted">Wine detail pages opened</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Page views per day --}}
            <div class="card custom-card mb-4">
                <div class="card-header">
                    <div class="card-title">Page views per day</div>
                </div>
                <div class="card-body">
                    <div id="health-daily-views" style="min-height: 280px;"></div>
                </div>
            </div>

            <div class="row g-3">
                {{-- Most viewed pages --}}
                <div class="col-xl-6">
                    <div class="card custom-card h-100">
                        <div class="card-header">
                            <div class="card-title">Most viewed pages</div>
                        </div>
                        <div class="card-body">
                            @php $maxPageViews = max(1, $topPages->max('views') ?? 1); @endphp
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap w-100" data-order='[[1,"desc"]]'>
                                    <thead>
                                        <tr>
                                            <th>Page</th>
                                            <th>Views</th>
                                            <th>Kiosk accounts</th>
                                            <th>Share</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topPages as $page)
                                            <tr>
                                                <td>{{ $page->name }}</td>
                                                <td data-order="{{ $page->views }}">{{ number_format($page->views) }}</td>
                                                <td>{{ number_format($page->users) }}</td>
                                                <td class="health-share" data-order="{{ $page->views }}">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-primary" style="width: {{ round($page->views / $maxPageViews * 100) }}%"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Most clicked links and buttons --}}
                <div class="col-xl-6">
                    <div class="card custom-card h-100">
                        <div class="card-header">
                            <div class="card-title">Most clicked links and buttons</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap w-100" data-order='[[2,"desc"]]'>
                                    <thead>
                                        <tr>
                                            <th>Link / button</th>
                                            <th>On page</th>
                                            <th>Clicks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topClicks as $click)
                                            <tr>
                                                <td>{{ \Illuminate\Support\Str::limit($click->label, 60) }}</td>
                                                <td>{{ $click->page }}</td>
                                                <td>{{ number_format($click->clicks) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Most viewed wines --}}
                <div class="col-xl-8">
                    <div class="card custom-card h-100">
                        <div class="card-header">
                            <div class="card-title">Most viewed wines</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap w-100" data-order='[[1,"desc"]]'>
                                    <thead>
                                        <tr>
                                            <th>Wine</th>
                                            <th>Detail views</th>
                                            <th>Kiosk accounts</th>
                                            <th>Added to cart</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topWines as $wine)
                                            <tr>
                                                <td>{{ $wine->name }}</td>
                                                <td>{{ number_format($wine->views) }}</td>
                                                <td>{{ number_format($wine->users) }}</td>
                                                <td>{{ number_format($wine->adds) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Most added to cart --}}
                <div class="col-xl-4">
                    <div class="card custom-card h-100">
                        <div class="card-header">
                            <div class="card-title">Most added to cart</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap w-100" data-order='[[1,"desc"]]'>
                                    <thead>
                                        <tr>
                                            <th>Wine</th>
                                            <th>Times</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topCartAdds as $wine)
                                            <tr>
                                                <td>{{ \Illuminate\Support\Str::limit($wine->name, 40) }}</td>
                                                <td>{{ number_format($wine->adds) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Questionnaires --}}
                <div class="col-xl-4">
                    <div class="card custom-card h-100">
                        <div class="card-header">
                            <div class="card-title">Questionnaires completed</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap w-100" data-order='[[1,"desc"]]'>
                                    <thead>
                                        <tr>
                                            <th>Questionnaire</th>
                                            <th>Completed</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($questionnaires as $questionnaire)
                                            <tr>
                                                <td>{{ $questionnaire->name }}</td>
                                                <td>{{ number_format($questionnaire->completed) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Most chosen questionnaire options --}}
                <div class="col-xl-8">
                    <div class="card custom-card h-100">
                        <div class="card-header">
                            <div class="card-title">Most chosen questionnaire answers</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap w-100" data-order='[[2,"desc"]]'>
                                    <thead>
                                        <tr>
                                            <th>Answer</th>
                                            <th>Questionnaire</th>
                                            <th>Times chosen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topOptions as $option)
                                            <tr>
                                                <td>{{ \Illuminate\Support\Str::limit($option->option, 50) }}</td>
                                                <td>{{ $option->questionnaire }}</td>
                                                <td>{{ number_format($option->times) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <p class="health-note mb-0 mt-2">
                                Only the questionnaires' own answer choices are counted; typed answers such as names or phone numbers are never shown.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Activity by store --}}
                <div class="col-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Activity by store</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap w-100" data-order='[[1,"desc"]]'>
                                    <thead>
                                        <tr>
                                            <th>Store</th>
                                            <th>Page views</th>
                                            <th>Clicks</th>
                                            <th>Kiosk accounts</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($byStore as $store)
                                            <tr>
                                                <td>{{ $store->name }}</td>
                                                <td>{{ number_format($store->views) }}</td>
                                                <td>{{ number_format($store->clicks) }}</td>
                                                <td>{{ number_format($store->users) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="health-note mt-3">
                Page views and clicks are counted for logged-in kiosk users from the day this page was added;
                questionnaire figures use all saved answers in the period.
            </p>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const daily = @json($dailyViews);
        const element = document.getElementById('health-daily-views');
        if (!element || typeof ApexCharts === 'undefined') {
            return;
        }

        new ApexCharts(element, {
            chart: { type: 'area', height: 280, toolbar: { show: false }, zoom: { enabled: false } },
            series: [{ name: 'Page views', data: daily.map(point => point.views) }],
            xaxis: { categories: daily.map(point => point.day), tickAmount: Math.min(daily.length, 12), labels: { rotate: 0 } },
            yaxis: { min: 0, forceNiceScale: true, labels: { formatter: value => Math.round(value) } },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },
            colors: ['#7b1e3a'],
            fill: { type: 'gradient', gradient: { opacityFrom: 0.35, opacityTo: 0.05 } },
            tooltip: { y: { formatter: value => value + ' views' } }
        }).render();
    });
</script>
@endpush
