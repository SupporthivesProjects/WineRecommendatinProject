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

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Feature Details</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Features</li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
                <div class="d-flex">
                    <a href="{{ route('admin.features.edit', $feature) }}" class="btn btn-wave btn-primary my-2 btn-icon-text">
                        <i class="fe fe-edit me-2"></i>Edit Feature
                    </a>
                    <a href="{{ route('admin.features.index') }}" class="btn btn-wave btn-secondary my-2 btn-icon-text ms-2">
                        <i class="fe fe-arrow-left me-2"></i>Back
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h4 class="card-title">Feature Information</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" value="{{ $feature->name }}" readonly>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Key</label>
                                        <input
                                            type="text" class="form-control" value="{{ $feature->key }}" readonly>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea
                                            rows="4" class="form-control" readonly>{{ $feature->description }}
                                        </textarea>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Status</label>
                                        <input
                                            type="text" class="form-control" value="{{ $feature->status ? 'Active' : 'Inactive' }}" 
                                            readonly>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Created At</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            value="{{ $feature->created_at->format('d M Y h:i A') }}"
                                            readonly
                                        >
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Last Updated</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            value="{{ $feature->updated_at->format('d M Y h:i A') }}"
                                            readonly
                                        >
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush