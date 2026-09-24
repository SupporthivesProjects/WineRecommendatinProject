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
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Manager Stores</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manager Stores</li>
                    </ol>
                </div>
                <div class="d-flex">
                    <a href="{{ route('main-manager.dashboard') }}" class="btn btn-wave btn-secondary my-2 btn-icon-text">
                        <i class="fe fe-arrow-left me-2"></i> Back to dashboard
                    </a>
                </div>
            </div>
            <!-- End::page-header -->
            <!-- Start::row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-body">

                        @if (Auth::id()==13 && Auth::user()->first_name=="sherlock" && Auth::user()->last_name=="holmes") 
                            <div class="main-content app-content">
                                <div class="container-fluid">

                                    <div class="alert alert-warning">
                                        Analytics is enabled for your store.
                                    </div>

                                </div>
                            </div>
                        @else
                            <div class="main-content">
                                <div class="container-fluid">
                                    <div class="alert alert-warning">
                                        Analytics is disabled.
                                    </div>
                                </div>
                            </div>
                        @endif


                        <!-- @if($analyticsEnabled)
                            <div class="main-content app-content">
                                <div class="container-fluid">

                                    <div class="alert alert-warning">
                                        Analytics is enabled for your store.
                                    </div>

                                </div>
                            </div>

                        @else

                            <div class="main-content app-content">
                                <div class="container-fluid">

                                    <div class="alert alert-warning">
                                        Analytics is not enabled for your store.
                                    </div>

                                </div>
                            </div>

                        @endif     -->
                        


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
