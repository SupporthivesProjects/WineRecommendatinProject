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

    <!-- Products Section -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Questionnaire Responses Page</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Responses</li>
                    </ol>
                </div>
                <div class="d-flex">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-wave btn-secondary my-2 btn-icon-text ms-2">
                    <i class="fe fe-arrow-left me-2"></i>Back
                </a>
                </div>
            </div>
            <!-- End::page-header -->

            <!-- Start::row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-body">
                            <!-- Table -->
                            <div class="table-responsive">
                            <table id="file-export" class="table table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-start">SR No.</th>
                                            <th class="text-start">Customer Name</th>
                                            <th class="text-start">Email</th>
                                            <th class="text-start">Phone</th>
                                            <th class="text-start">Created On</th>
                                            <th class="text-start">Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($submissions as $submission)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $submission->cust_name }}</td>
                                                <td>{{ $submission->cust_email }}</td>
                                                <td>{{ $submission->cust_phone }}</td>
                                                <td>{{ \Carbon\Carbon::parse($submission->created_at)->format('d M Y, h:i A') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.questionnaire.responses.show', $submission->submission_id) }}" class="btn btn-sm btn-primary">View</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No submissions found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::row -->
        </div>
    </div>
    <!-- End::Products Section -->
@endsection

@push('scripts')
   

@endpush


