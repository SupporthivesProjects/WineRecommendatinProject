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
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="container-fluid">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="wine_name">Wine Name</label>
                                    <input type="text" class="form-control" id="wine_name" name="wine_name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="type">Type</label>
                                    <select class="form-select" id="type" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="red">Red Wine</option>
                                        <option value="white">White Wine</option>
                                        <option value="rose">Rosé</option>
                                        <option value="sparkling">Sparkling</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="winery">Winery</label>
                                    <input type="text" class="form-control" id="winery" name="winery" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="grape_variety">Grape Variety</label>
                                    <input type="text" class="form-control" id="grape_variety" name="grape_variety">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="country">Country</label>
                                    <input type="text" class="form-control" id="country" name="country">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="region">Region</label>
                                    <input type="text" class="form-control" id="region" name="region">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="retail_price">Retail Price</label>
                                    <input type="number" class="form-control" id="retail_price" name="retail_price" step="0.01" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="status">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Image Upload Section -->
                            <div class="mt-4">
                                <label class="form-label">Product Images</label>
                                <div class="border border-dashed p-3 rounded text-center">
                                    <svg class="mx-auto mb-2" width="48" height="48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"></path>
                                    </svg>
                                    <div class="d-flex flex-column">
                                        <label class="btn btn-outline-primary">
                                            Upload images
                                            <input type="file" id="product_images" name="product_images[]" multiple accept="image/*" hidden onchange="previewImages(this)">
                                        </label>
                                        <small class="text-muted mt-2">PNG, JPG, GIF up to 2MB</small>
                                    </div>
                                </div>

                                <!-- Image Preview -->
                                <div id="image-preview-container" class="row mt-3"></div>

                                <!-- Primary Image Selection -->
                                <div id="primary-image-selection" class="mt-3 d-none">
                                    <label class="form-label">Select Primary Image</label>
                                    <select name="primary_image" id="primary_image" class="form-select">
                                        <option value="">Select Primary Image</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Add Product</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <!-- JS Function to preview images -->
    <script>
        function previewImages(input) {
            var previewContainer = document.getElementById('image-preview-container');
            var primarySelect = document.getElementById('primary_image');
            var primarySection = document.getElementById('primary-image-selection');

            previewContainer.innerHTML = "";
            primarySelect.innerHTML = "<option value=''>Select Primary Image</option>";

            if (input.files) {
                primarySection.classList.remove('d-none');
                Array.from(input.files).forEach(function (file, index) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var col = document.createElement('div');
                        col.className = "col-6 mb-2";
                        col.innerHTML = '<img src="' + e.target.result + '" class="img-fluid rounded" alt="Product Image">';
                        previewContainer.appendChild(col);

                        var option = document.createElement('option');
                        option.value = index;
                        option.text = file.name;
                        primarySelect.appendChild(option);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }
    </script>
@endpush


