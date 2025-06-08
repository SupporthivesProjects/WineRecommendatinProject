@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
    <style>
        .dataTables_filter input[type="search"] {
            width: 300px !important; 
            margin-bottom: 20px;
        }
        
        /* Compact Date Filter Styles */
        .compact-date-filter {
            background: #f8f9fa;
            border-radius: 4px;
            padding: 6px 8px;
            border: 1px solid #dee2e6;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        
        .compact-date-filter .filter-label {
            font-size: 11px;
            font-weight: 500;
            color: #6c757d;
            margin-bottom: 0;
            white-space: nowrap;
        }
        
        .compact-date-filter .form-control-xs {
            font-size: 11px;
            padding: 2px 6px;
            height: 26px;
            width: 110px;
            border: 1px solid #ced4da;
            border-radius: 3px;
        }
        
        .compact-date-filter .form-control-xs:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.1rem rgba(0, 123, 255, 0.25);
        }
        
        .compact-date-filter .btn-xs {
            padding: 3px 6px;
            font-size: 10px;
            line-height: 1.2;
            border-radius: 3px;
            height: 26px;
            width: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .compact-date-filter .btn-xs:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .compact-date-filter {
                flex-direction: column;
                gap: 4px;
            }
            
            .compact-date-filter .form-control-xs {
                width: 100px;
            }
        }
    </style>
    @endpush


    <!-- Start::Questionnaires Section -->
        <div class="main-content app-content">
            <div class="container-fluid">
                <!-- Start::page-header -->
                <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                    <div>
                        <h2 class="main-content-title fs-24 mb-1">Questionnaires</h2>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Questionnaires</li>
                        </ol>
                    </div>
                    <!-- You had no Add button for this section, so nothing here -->
                </div>
                <!-- End::page-header -->

                <!-- Start::row -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <!-- Table -->
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-start">ID</th>
                                                <th class="text-start">Name</th>
                                                <th class="text-start">Level</th>
                                                <th class="text-start">Questions</th>
                                                <th class="text-start">Status</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($templates) && count($templates) > 0)
                                                @foreach($templates as $template)
                                                <tr>
                                                    <td class="align-middle">{{ $template->id }}</td>
                                                    <td class="align-middle">{{ $template->name }}</td>
                                                    <td class="align-middle">
                                                        <span class="badge rounded-pill bg-{{ $template->level === 'first_sip' ? 'success' : ($template->level === 'savy_sipper' ? 'primary' : 'purple') }}">
                                                            {{ $template->level === 'first_sip' ? 'Basic' : ($template->level === 'savy_sipper' ? 'Intermediate' : 'Advanced') }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle">{{ count($template->questions) }}</td>
                                                    <td class="align-middle">
                                                        <span class="badge rounded-pill bg-{{ $template->is_active ? 'success' : 'danger' }}">
                                                            {{ $template->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <a href="{{ route('admin.questionnaires.show', $template) }}" class="text-primary">View</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="6" class="text-center">No questionnaires found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End::row -->

                <!-- Start::Analytics Section -->
                <div class="row mt-5">
                    <!-- First Sip -->
                    <div class="col-md-3">
                        <div class="card custom-card">
                            <div class="card-body">
                                <h5 class="card-title">First Sip (Basic)</h5>
                                <div class="d-flex align-items-center justify-content-between mt-3">
                                    <div>
                                        <p class="mb-1 text-muted">Total Responses</p>
                                        <h3 class="fw-bold">{{ $firstSipCount ?? 0 }}</h3>
                                    </div>
                                    <div class="text-success fs-1">
                                        <i class="fe fe-check-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Savy Sipper -->
                    <div class="col-md-3">
                        <div class="card custom-card">
                            <div class="card-body">
                                <h5 class="card-title">Savy Sipper (Intermediate)</h5>
                                <div class="d-flex align-items-center justify-content-between mt-3">
                                    <div>
                                        <p class="mb-1 text-muted">Total Responses</p>
                                        <h3 class="fw-bold">{{ $savySipperCount ?? 0 }}</h3>
                                    </div>
                                    <div class="text-primary fs-1">
                                        <i class="fe fe-navigation"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pro -->
                    <div class="col-md-3">
                        <div class="card custom-card">
                            <div class="card-body">
                                <h5 class="card-title">Pro (Advanced)</h5>
                                <div class="d-flex align-items-center justify-content-between mt-3">
                                    <div>
                                        <p class="mb-1 text-muted">Total Responses</p>
                                        <h3 class="fw-bold">{{ $proCount ?? 0 }}</h3>
                                    </div>
                                    <div class="text-purple fs-1">
                                        <i class="fe fe-sun"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Pour -->
                    <div class="col-md-3">
                        <div class="card custom-card">
                            <div class="card-body">
                                <h5 class="card-title">Quick Pour</h5>
                                <div class="d-flex align-items-center justify-content-between mt-3">
                                    <div>
                                        <p class="mb-1 text-muted">Total Responses</p>
                                        <h3 class="fw-bold">{{ $quickPourCount ?? 0 }}</h3>
                                    </div>
                                    <div class="text-primary fs-1">
                                        <i class="fe fe-navigation"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <!-- Recent Responses Chart -->
                <div class="row mt-5">
                    <div class="col-md-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0">Responses Chart</h5>
                                    
                                    <!-- Compact Date Filter on extreme right -->
                                    <div class="compact-date-filter">
                                        <form method="GET" action="{{ route('admin.questionnaires.index') }}" id="dateFilterForm" class="d-flex align-items-center gap-1">
                                            <div class="d-flex align-items-center">
                                                <label class="filter-label me-1">From:</label>
                                                <input type="date" class="form-control form-control-xs" id="start_date" name="start_date" 
                                                       value="{{ request('start_date', $defaultStartDate) }}">
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <label class="filter-label me-1 ms-2">To:</label>
                                                <input type="date" class="form-control form-control-xs" id="end_date" name="end_date" 
                                                       value="{{ request('end_date', $defaultEndDate) }}">
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-xs ms-2" title="Apply Filter">
                                                <i class="fe fe-filter" style="font-size: 10px;"></i>
                                            </button>
                                            <a href="{{ route('admin.questionnaires.index') }}" class="btn btn-secondary btn-xs ms-1" title="Reset">
                                                <i class="fe fe-refresh-cw" style="font-size: 10px;"></i>
                                            </a>
                                        </form>
                                    </div>
                                </div>
                                
                                <!-- Date range display -->
                                <div class="mb-3">
                                    <small class="text-muted">
                                        Showing data from {{ $displayStartDate ?? 'N/A' }} to {{ $displayEndDate ?? 'N/A' }}
                                    </small>
                                </div>
                                
                                <!-- Chart Canvas -->
                                <canvas id="responsesChart" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End::Analytics Section -->
            </div>
        </div>
        <!-- End::Questionnaires Section -->


@endsection


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('responsesChart').getContext('2d');

        // Define consistent colors for each dataset
        const colors = [
            '#28a745', // Green for First Sip
            '#007bff', // Blue for Savy Sipper  
            '#6f42c1', // Purple for Pro
            '#17a2b8', // Teal for Quick Pour
            '#fd7e14', // Orange
            '#dc3545'  // Red
        ];

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($dateLabels ?? $last7Days),
                datasets: [
                    @foreach ($chartData as $index => $dataset)
                        {
                            label: '{{ $dataset['label'] }}',
                            data: @json($dataset['data']),
                            borderWidth: 2,
                            fill: false,
                            borderColor: colors[{{ $index }}] || '#' + Math.floor(Math.random()*16777215).toString(16),
                            backgroundColor: colors[{{ $index }}] || '#' + Math.floor(Math.random()*16777215).toString(16),
                            tension: 0.3,
                        },
                    @endforeach
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: false,
                    },
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        ticks: {
                            maxTicksLimit: 10
                        }
                    }
                }
            }
        });
    });

    // Auto-submit form when dates change (optional)
    document.getElementById('start_date').addEventListener('change', function() {
        // Optionally auto-submit or validate dates
    });

    document.getElementById('end_date').addEventListener('change', function() {
        // Optionally auto-submit or validate dates
    });
</script>
@endpush