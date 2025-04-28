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

    <!-- Products Section -->
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
                <div class="d-flex">
                    <button type="button" class="btn btn-wave btn-secondary my-2 btn-icon-text" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="fe fe-plus me-2"></i> Add Product
                    </button>
                </div>
            </div>
            <!-- End::page-header -->

            <!-- Start::row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-body">
                            <!-- Search Bar -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between">
                                    <input type="text" id="product-search-input" class="form-control" placeholder="Search products..." value="{{ request('product_search') }}">
                                    <select id="type-filter-select" class="form-select">
                                        <option value="">All Types</option>
                                        <option value="red" {{ request('product_filter') == 'red' ? 'selected' : '' }}>Red Wine</option>
                                        <option value="white" {{ request('product_filter') == 'white' ? 'selected' : '' }}>White Wine</option>
                                        <option value="rose" {{ request('product_filter') == 'rose' ? 'selected' : '' }}>Rosé</option>
                                        <option value="sparkling" {{ request('product_filter') == 'sparkling' ? 'selected' : '' }}>Sparkling</option>
                                    </select>
                                    <button id="clear-product-filters" class="btn btn-link text-sm text-gray-600">
                                        Clear filters
                                    </button>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table id="file-export" class="table table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-start">SR No.</th>
                                            <th class="text-start">Wine Name</th>
                                            <th class="text-start">Type</th>
                                            <th class="text-start">Winery</th>
                                            <th class="text-start">Country</th>
                                            <th class="text-start">Price</th>
                                            <th class="text-start">Status</th>
                                            <th class="text-start">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($products as $index => $product)
                                            <tr>
                                                <td class="align-middle">{{ $index + 1 }}</td>
                                                <td class="align-middle">{{ $product->wine_name }}</td>
                                                <td class="align-middle">{{ ucfirst($product->type) }}</td>
                                                <td class="align-middle">{{ $product->winery }}</td>
                                                <td class="align-middle">{{ $product->country }}</td>
                                                <td class="align-middle">${{ number_format($product->retail_price, 2) }}</td>
                                                <td class="align-middle">
                                                    <span class="badge rounded-pill border border-{{ $product->status === 'active' ? 'success' : 'danger' }} text-{{ $product->status === 'active' ? 'success' : 'danger' }} py-1 px-3">
                                                        {{ ucfirst($product->status) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <a href="{{ route('admin.products.show', $product) }}" class="text-primary">View</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No products found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination Links -->
                            <div class="mt-4">
                                @if (isset($products) && $products->hasPages())
                                    {{ $products->appends(request()->except('page'))->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::row -->
        </div>
    </div>
    <!-- End::Products Section -->

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" data-bs-effect="effect-fall" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.products.store') }}" method="POST">
                        @csrf
                        <!-- Your form fields for adding a product go here -->
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // You can include your JavaScript for modal control here
    </script>
@endpush


