@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
    <style>
        .dataTables_filter input[type="search"] {
            width: 300px !important; 
            margin-bottom: 20px;
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
                                <h5 class="card-title">Recent Responses (Last 7 Days)</h5>
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

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($last7Days),
                datasets: [
                    @foreach ($chartData as $dataset)
                        {
                            label: '{{ $dataset['label'] }}',
                            data: @json($dataset['data']),
                            borderWidth: 2,
                            fill: false,
                            borderColor: '#' + Math.floor(Math.random()*16777215).toString(16), // random color
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
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endpush