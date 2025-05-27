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
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Featured Products Dash Board</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Featured Products</li>
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
                                            <th class="text-start">Store Name</th>
                                            <th class="text-start">Featured Products</th>
                                            <th class="text-start">Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $store)
                                        <tr>
                                            <td>{{ $store['id'] }}</td>
                                            <td>{{ $store['store_name'] }}</td>
                                            <td>{{ $store['featured_count'] }}</td>
                                            <td>
                                                <a href="{{ route('admin.isFeatured.show', $store['id']) }}">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
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


