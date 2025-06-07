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
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Manager Stores</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manager Stores</li>
                    </ol>
                </div>
                <div class="d-flex">
                <a href="{{ route('main-manager.dashboard') }}" class="btn btn-wave btn-secondary my-2 btn-icon-text">
                        <i class="fe fe-arrow-left me-2"></i> Back to List
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
                                            <th class="text-start">Business Type</th>
                                            <th class="text-start">Contact</th>
                                            <th class="text-start">Email</th>
                                            <th class="text-start">Address</th>
                                            <th class="text-start">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($stores as $index => $store)
                                            <tr>
                                                <td class="align-middle">{{ $index + 1 }}</td>
                                                <td class="align-middle">{{ $store->store_name }}</td>
                                                <td class="align-middle">{{ ucfirst($store->business_type) }}</td>
                                                <td class="align-middle">{{ $store->contact_number }}</td>
                                                <td class="align-middle">{{ $store->email }}</td>
                                                <td class="align-middle">${{ $store->address }}</td>
                                                <td class="align-middle">
                                                    <!-- <a href="#" class="text-primary">View</a> -->
                                                    <a href="{{ route('manager.store.details', ['storeId' => $store->id]) }}" class="text-primary">View</a>

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No products found</td>
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


