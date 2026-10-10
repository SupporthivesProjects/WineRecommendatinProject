@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
        
    @endpush
    
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Welcome to Support Dashboard</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Suppot</li>
                    </ol>
                </div>
                <div class="d-flex">
                    <a href="{{ route('store-manager.dashboard') }}" class="btn btn-wave btn-secondary my-2">
                        <i class="fe fe-arrow-left me-2"></i> Back to Dashboard
                    </a>
                </div>
            </div>
            <!-- End::page-header -->

            <!-- Start::row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="container mt-4">
                                    <div class="card shadow-sm">
                                        <div class="card-header">
                                            <h4 class="mb-0">Store Support</h4>
                                        </div>

                                        <div class="card-body">
                                            <form action="{{ route('store-manager.support.submit') }}" method="POST">
                                                @csrf

                                                <div class="mb-3">
                                                    <label for="store_name" class="form-label">Store Name</label>
                                                    <input
                                                        type="text"
                                                        id="store_name"
                                                        class="form-control"
                                                        value="{{ $storeName ?? '' }}"
                                                        readonly
                                                    >
                                                </div>

                                                <div class="mb-3">
                                                    <label for="current_date" class="form-label">Current Date</label>
                                                    <input
                                                        type="text"
                                                        id="current_date"
                                                        class="form-control"
                                                        value="{{ now()->format('d M Y') }}"
                                                        readonly
                                                    >
                                                </div>

                                                <div class="mb-3">
                                                    <label for="message" class="form-label">Message</label>
                                                    <textarea
                                                        name="message"
                                                        id="message"
                                                        class="form-control"
                                                        rows="5"
                                                        placeholder="Describe how we can help..."
                                                        required
                                                    ></textarea>
                                                </div>

                                                <button type="submit" class="btn btn-primary">
                                                    Submit
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::row -->
        </div>
    </div>

    @push('scripts')
    
    @endpush
@endsection
