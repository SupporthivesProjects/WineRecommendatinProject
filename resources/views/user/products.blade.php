@extends('layouts.bootdashboard')
@section('admindashboardcontent')

<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Products Board</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Products</li>
                    </ol>
                </div>
            </div>
        <!-- End::page-header -->

            <!-- Start::row-6 -->
                <div class="row row-sm">
                    @foreach ($products as $product)
                        <div class="col-xl-4">
                            <div class="card custom-card">
                                <!-- Image at the top -->
                                @php
                                    $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
                                @endphp
                                <img src="{{ $primaryImage ? asset('storage/products/' . $primaryImage->image_path) : asset('images/default.jpg') }}" class="card-img-top" alt="{{ $product->wine_name }}">

                                <!-- Card body with product information -->
                                <div class="card-body">
                                    <h5 class="card-title fw-semibold"> {{ $product->wine_name }}</h6>
                                    <p><strong>Type:</strong> {{ ucfirst($product->type) }} </p> 
                                    <p><strong>Vintage Year:</strong> {{ $product->vintage_year }}</p>
                                    <p><strong>Tasting Notes:</strong> {{ Str::words($product->tasting_notes, 20, '...') }}</p>

                                    <!-- Button to check the product details -->
                                    <a href="{{ route('user.productdetails', $product->id) }}" class="btn btn-primary mt-2">
                                        I want to try Now !!
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            <!-- End::row-6 -->

        <!-- End::row-6 -->

       
        <!-- Pagination Code -->
        @if ($products->hasPages())
            <div class="d-flex justify-content-center my-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination mb-0">
                        {{-- Previous Page Link --}}
                        @if ($products->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link"><i class="bi bi-caret-left"></i></span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">
                                    <i class="bi bi-caret-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                            <li class="page-item {{ $products->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($products->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">
                                    <i class="bi bi-caret-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link"><i class="bi bi-caret-right"></i></span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        @endif


      
    </div>
</div>

@endsection
