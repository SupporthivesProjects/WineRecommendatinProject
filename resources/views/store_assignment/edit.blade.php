
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


    <!-- Stores Section -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Manager Stores Board</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manager</li>
                    </ol>
                </div>
                <div class="d-flex">
                <a href="{{ route('admin.main_manager') }}" class="btn btn-wave btn-secondary my-2 btn-icon-text">
                    <i class="fe fe-arrow-left me-2"></i>Back 
                </a>
                </div>
            </div>

            <!-- End::page-header -->

            <!-- Start::row -->
            <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                   
                                </div>
                            </div>
                            <div class="card-body">
                            <form method="POST" action="{{ route('admin.assign.stores.update', $manager->id) }}">
                                @csrf

                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th>Store Name</th>
                                            <th>Address</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($stores as $store)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="store_ids[]" value="{{ $store->id }}"
                                                        {{ in_array($store->id, $assignedStoreIds) ? 'checked' : '' }}>
                                                </td>
                                                <td>{{ $store->store_name }}</td>
                                                <td>{{ $store->address }}</td>
                                                <td>{{ $store->email }}</td>
                                                <td>{{ $store->contact_number }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">No stores available.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <button type="submit" class="btn btn-primary my-3">Update Stores</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- End::row -->   


       

        


@endsection

@push('scripts')
   
@endpush

