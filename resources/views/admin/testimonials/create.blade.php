@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Add New Testimonial</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.testimonials.index') }}">Testimonials</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add New</li>
                    </ol>
                </div>
            </div>
            <!-- End::page-header -->

            <!-- Start::row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h6 class="card-title">Testimonial Information</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                                @include('admin.testimonials._form')
                            </form>
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
    .form-group {
        margin-bottom: 1.25rem;
    }
    .form-group label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .card {
        border: 1px solid #e2e8f0;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e2e8f0;
        padding: 1rem 1.25rem;
    }
    .card-header h6 {
        margin-bottom: 0;
        font-weight: 600;
    }
    .card-body {
        padding: 1.5rem;
    }
</style>
@endpush
