
@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
    <style>
        .dataTables_filter input[type="search"] {
            width: 300px !important; 
            margin-bottom: 20px;
        }
        .product-thumbnail {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
        .action-btns .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            line-height: 1.5;
        }
    </style>
    @endpush

    <!-- Templates Section -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Features Board</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Features</li>
                    </ol>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.features.create') }}" type="button" class="btn btn-wave btn-secondary my-2 btn-icon-text">
                        <i class="fe fe-plus me-2"></i> Add Features
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
                                <table id="templates" class="table table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-start">SR No.</th>
                                            <th class="text-start">Template Name</th>
                                            <th class="text-start">Key</th>
                                            <th class="text-start">Description</th>
                                            <th class="text-start">Status</th>
                                            <th class="text-start">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($features as $index => $feature)
                                            <tr>
                                                <td class="align-middle">{{ $index + 1 }}</td>
                                                <td class="align-middle">{{ $feature->name }}</td>
                                                <td class="align-middle">{{ $feature->description }}</td>
                                                <td class="align-middle">{{ $feature->key }}</td>
                                                <td class="align-middle">
                                                    @if($feature->status == 1)
                                                        <span class="badge rounded-pill border border-success text-success py-1 px-3">
                                                            Active
                                                        </span>
                                                    @else
                                                        <span class="badge rounded-pill border border-danger text-danger py-1 px-3">
                                                            Inactive
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="align-middle action-btns">
                                                    <div class="d-flex">
                                                        <a href="{{ route('admin.features.show', $feature->id)}}" 
                                                           class="btn btn-sm btn-info me-1" 
                                                           data-bs-toggle="tooltip" 
                                                           title="View">
                                                            <i class="fe fe-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.features.edit', $feature) }}"
                                                           class="btn btn-sm btn-primary me-1"
                                                           data-bs-toggle="tooltip" 
                                                           title="Edit">
                                                            <i class="fe fe-edit"></i>
                                                        </a>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No cheese products found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table -->
                            
                            {{-- @if($features->hasPages())
                            <div class="mt-3">
                                {{ $features->links() }}
                            </div>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::row -->
        </div>
    </div>
    <!-- End::Cheese Products Section -->
@endsection

@push('scripts')
    
@endpush
