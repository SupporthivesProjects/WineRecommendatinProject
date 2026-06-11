@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
    <style>
        .action-btns .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            line-height: 1.5;
        }
    </style>
    @endpush

    <!-- Create Feature Section -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Edit Features</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Features</li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </div>
            </div>
            <!-- End::page-header -->

            <!-- Start::row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="card-header">
                                <h4 class="card-title">Edit Features</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.features.update', $feature->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" id="name" 
                                                    class="form-control @error('name') is-invalid @enderror" 
                                                    value="{{ old('name', $feature->name) }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea name="description" id="description" rows="4" 
                                                        class="form-control @error('description') is-invalid @enderror">{{ old('description', $feature->description) }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="key" class="form-label">Key <span class="text-danger">*</span></label>
                                                <input type="text" name="key" id="key" 
                                                    class="form-control @error('key') is-invalid @enderror" 
                                                    value="{{ old('key', $feature->key) }}" readonly>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-check form-switch mb-3">
                                            <input type="hidden" name="status" value="0">

                                            <input class="form-check-input"
                                                type="checkbox"
                                                name="status"
                                                id="status"
                                                value="1"
                                                {{ old('status', $feature->status) ? 'checked' : '' }}>

                                            <label class="form-check-label" for="status">
                                                Active
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary me-2">
                                                <i class="fe fe-save me-2"></i>Update Feature
                                            </button>
                                            <a href="{{ route('admin.features.index') }}" class="btn btn-light">
                                                <i class="fe fe-x me-2"></i>Cancel
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
