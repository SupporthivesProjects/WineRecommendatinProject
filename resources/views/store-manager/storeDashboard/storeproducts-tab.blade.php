@extends('layouts.bootdashboard')
@section('admindashboardcontent')

@push('styles')
@endpush

<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Start::Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
            <div>
                <h2 class="main-content-title fs-24 mb-1">{{ __('Select Products for Store') }}</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Select Products</li>
                </ol>
            </div>
            <div class="d-flex">
                <a href="{{ route('store-manager.dashboard') }}" class="btn btn-wave btn-secondary my-2 btn-icon-text">
                    <i class="fe fe-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
        <!-- End::Page Header -->

        <!-- Start::Content -->
        <div class="py-5">
            <div class="container-lg">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-4">{{ __('Select Products') }}</h4>
                        <form action="" method="POST">
                            @csrf
                            <div class="row g-3">
                                @foreach($allProducts as $product)
                                    @if($product->status === 'active')
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="product_{{ $product->id }}" name="products[]" value="{{ $product->id }}">
                                                <label class="form-check-label" for="product_{{ $product->id }}">
                                                    {{ $product->wine_name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- End::Content -->

    </div>
</div>

@endsection
