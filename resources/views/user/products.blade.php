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


        @foreach ($products as $product)
            <div class="card shadow-sm border-0 p-3 mb-4">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 text-primary">{{ $product->wine_name }}</h3>
                    <span class="badge bg-{{ $product->status === 'active' ? 'success' : 'danger' }} text-uppercase px-3 py-2">
                        {{ ucfirst($product->status) }}
                    </span>
                </div>

                <div class="card-body">
                    <div class="row">
                        @php
                            $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
                        @endphp
                        <div class="col-md-4 mb-3">
                            @if ($primaryImage)
                                <img src="{{ asset('storage/products/' . $primaryImage->image_path) }}" class="img-fluid rounded w-100" alt="{{ $product->wine_name }}">
                            @else
                                <p class="text-muted">No image available</p>
                            @endif
                        </div>

                        <div class="col-md-8">
                            <p><strong>Type:</strong> {{ $product->type }}</p>
                            <p><strong>Variety:</strong> {{ $product->grape_variety }}</p>
                            <p><strong>Vintage Year:</strong> {{ $product->vintage_year }}</p>
                            <p><strong>Palate :</strong> {{ $product->palate }}</p>
                            <p><strong>Tasting Notes:</strong> {{ $product->tasting_notes }}</p>
                            <a href="{{ route('user.productdetails', $product->id) }}" class="btn btn-outline-primary mt-3">I want to check this !!</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
       
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
