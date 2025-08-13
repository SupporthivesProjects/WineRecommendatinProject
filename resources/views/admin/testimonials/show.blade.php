@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Testimonial Details</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.testimonials.index') }}">Testimonials</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $testimonial->name }}</li>
                    </ol>
                </div>
                <div class="d-flex">
                    <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="btn btn-primary me-2">
                        <i class="fe fe-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light">
                        <i class="fe fe-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>
            <!-- End::page-header -->

            <!-- Start::row -->
            <div class="row">
                <div class="col-xl-8">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h6 class="card-title">Testimonial Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    @if($testimonial->image_url)
                                        <img src="{{ asset('storage/' . $testimonial->image_url) }}" 
                                             class="img-fluid rounded" 
                                             alt="{{ $testimonial->name }}">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center bg-light" 
                                             style="height: 200px; width: 200px; border-radius: 50%;">
                                            <span class="display-4 text-muted">{{ $testimonial->initials }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <h4 class="mb-3">{{ $testimonial->name }}</h4>
                                    
                                    @if($testimonial->position || $testimonial->company)
                                        <p class="text-muted mb-3">
                                            @if($testimonial->position)
                                                <span class="d-block"><i class="fe fe-briefcase me-2"></i> {{ $testimonial->position }}</span>
                                            @endif
                                            @if($testimonial->company)
                                                <span class="d-block"><i class="fe fe-home me-2"></i> {{ $testimonial->company }}</span>
                                            @endif
                                        </p>
                                    @endif
                                    
                                    <div class="mb-3">
                                        <span class="badge bg-primary">
                                            <i class="fe fe-star me-1"></i> {{ $testimonial->rating }} {{ Str::plural('Star', $testimonial->rating) }}
                                        </span>
                                        <span class="badge bg-{{ $testimonial->is_active ? 'success' : 'danger' }} ms-2">
                                            {{ $testimonial->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        <span class="badge bg-light text-dark ms-2">
                                            <i class="fe fe-grid me-1"></i> Sort: {{ $testimonial->sort_order }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <h5 class="mb-3">Testimonial</h5>
                                <div class="bg-light p-4 rounded">
                                    <p class="mb-0">{{ $testimonial->testimonial }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-4">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h6 class="card-title">Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
                                    <span><i class="fe fe-user me-2"></i> Initials</span>
                                    <span class="badge bg-light text-dark">{{ $testimonial->initials }}</span>
                                </div>
                                <div class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
                                    <span><i class="fe fe-calendar me-2"></i> Created</span>
                                    <span>{{ $testimonial->created_at->format('M d, Y h:i A') }}</span>
                                </div>
                                <div class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
                                    <span><i class="fe fe-refresh-cw me-2"></i> Last Updated</span>
                                    <span>{{ $testimonial->updated_at->format('M d, Y h:i A') }}</span>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fe fe-trash-2 me-1"></i> Delete Testimonial
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::row -->
        </div>
    </div>
@endsection

@push('styles')
<style>
    .card {
        border: 1px solid #e2e8f0;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 1.5rem;
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e2e8f0;
        padding: 1rem 1.25rem;
    }
    .card-header h6 {
        margin-bottom: 0;
        font-weight: 600;
        color: #4b566b;
    }
    .card-body {
        padding: 1.5rem;
    }
    .list-group-item {
        border-left: 0;
        border-right: 0;
    }
    .list-group-item:first-child {
        border-top: 0;
        padding-top: 0;
    }
    .list-group-item:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }
</style>
@endpush
