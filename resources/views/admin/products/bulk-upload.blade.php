@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
   
    @endpush

    <!-- Products Section -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Bulk Upload Dashboard</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Upload Bulk Products</li>
                    </ol>
                </div>
                <div class="d-flex">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-wave btn-secondary my-2 btn-icon-text">
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

                            <!-- Download CSV -->
                            <a href="{{ route('admin.products.download') }}" class="btn btn-primary">
                                Download Products CSV
                            </a>

                            <hr>

                            <!-- Upload CSV -->
                            <form action="{{ route('admin.products.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="csv_file" accept=".csv" required>
                                <button type="submit" class="btn btn-success">
                                    Upload CSV & Replace Products
                                </button>
                            </form>

                        </div>
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

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
