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
                    <a  href="{{ route('admin.products.create') }}" type="button" class="btn btn-wave btn-secondary my-2 btn-icon-text">
                        <i class="fe fe-plus me-2"></i> Add Product
                    </a>
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
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::row -->
        </div>
    </div>
    <!-- End::Products Section -->

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl"> <!-- Changed to xl for more space -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="container-fluid">
                            <div class="row g-3">
                                <!-- Existing Fields -->
                                <div class="col-md-6">
                                    <label for="wine_name" class="form-label">Wine Name</label>
                                    <input type="text" class="form-control" name="wine_name" id="wine_name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="type" class="form-label">Type</label>
                                    <select class="form-select" name="type" id="type">
                                        <option value="">Select Type</option>
                                        <option value="red">Red Wine</option>
                                        <option value="white">White Wine</option>
                                        <option value="rose">Rosé</option>
                                        <option value="sparkling">Sparkling</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="winery" class="form-label">Winery</label>
                                    <input type="text" class="form-control" name="winery" id="winery">
                                </div>
                                <div class="col-md-6">
                                    <label for="grape_variety" class="form-label">Grape Variety</label>
                                    <input type="text" class="form-control" name="grape_variety" id="grape_variety">
                                </div>

                                <div class="col-md-6">
                                    <label for="varietal_blend" class="form-label">Varietal Blend</label>
                                    <input type="text" class="form-control" name="varietal_blend" id="varietal_blend">
                                </div>
                                <div class="col-md-6">
                                    <label for="vintage_year" class="form-label">Vintage Year</label>
                                    <input type="text" class="form-control" name="vintage_year" id="vintage_year">
                                </div>
                                <div class="col-md-6">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" class="form-control" name="country" id="country">
                                </div>
                                <div class="col-md-6">
                                    <label for="region" class="form-label">Region</label>
                                    <input type="text" class="form-control" name="region" id="region">
                                </div>
                                <div class="col-md-6">
                                    <label for="wine_sub_region" class="form-label">Sub Region</label>
                                    <input type="text" class="form-control" name="wine_sub_region" id="wine_sub_region">
                                </div>
                                <div class="col-md-6">
                                    <label for="designation" class="form-label">Designation</label>
                                    <input type="text" class="form-control" name="designation" id="designation">
                                </div>
                                <div class="col-md-6">
                                    <label for="alcohol_vol" class="form-label">Alcohol Volume</label>
                                    <input type="text" class="form-control" name="alcohol_vol" id="alcohol_vol">
                                </div>
                                <div class="col-md-6">
                                    <label for="residual_sugar" class="form-label">Residual Sugar</label>
                                    <input type="text" class="form-control" name="residual_sugar" id="residual_sugar">
                                </div>
                                <div class="col-md-6">
                                    <label for="nature" class="form-label">Nature</label>
                                    <input type="text" class="form-control" name="nature" id="nature">
                                </div>
                                <div class="col-md-6">
                                    <label for="acidity" class="form-label">Acidity</label>
                                    <input type="text" class="form-control" name="acidity" id="acidity">
                                </div>
                                <div class="col-md-6">
                                    <label for="tannin_level" class="form-label">Tannin Level</label>
                                    <input type="text" class="form-control" name="tannin_level" id="tannin_level">
                                </div>
                                <div class="col-md-6">
                                    <label for="body" class="form-label">Body</label>
                                    <input type="text" class="form-control" name="body" id="body">
                                </div>
                                <div class="col-md-6">
                                    <label for="aging" class="form-label">Aging</label>
                                    <input type="text" class="form-control" name="aging" id="aging">
                                </div>
                                <div class="col-md-6">
                                    <label for="barrel_type" class="form-label">Barrel Type</label>
                                    <input type="text" class="form-control" name="barrel_type" id="barrel_type">
                                </div>
                                <div class="col-md-6">
                                    <label for="time_spent_aging" class="form-label">Time Spent Aging</label>
                                    <input type="text" class="form-control" name="time_spent_aging" id="time_spent_aging">
                                </div>
                                <div class="col-md-6">
                                    <label for="closure_type" class="form-label">Closure Type</label>
                                    <input type="text" class="form-control" name="closure_type" id="closure_type">
                                </div>
                                <div class="col-md-6">
                                    <label for="aroma" class="form-label">Aroma</label>
                                    <textarea class="form-control" name="aroma" id="aroma" rows="2"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="palate" class="form-label">Palate</label>
                                    <textarea class="form-control" name="palate" id="palate" rows="2"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="finish" class="form-label">Finish</label>
                                    <textarea class="form-control" name="finish" id="finish" rows="2"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="sweetness_level" class="form-label">Sweetness Level</label>
                                    <input type="text" class="form-control" name="sweetness_level" id="sweetness_level">
                                </div>
                                <div class="col-md-6">
                                    <label for="glass_ware" class="form-label">Glass Ware</label>
                                    <input type="text" class="form-control" name="glass_ware" id="glass_ware">
                                </div>
                                <div class="col-md-6">
                                    <label for="retail_price" class="form-label">Retail Price</label>
                                    <input type="number" class="form-control" name="retail_price" id="retail_price" step="0.01">
                                </div>
                                <div class="col-md-6">
                                    <label for="discounts" class="form-label">Discounts</label>
                                    <input type="text" class="form-control" name="discounts" id="discounts">
                                </div>
                                <div class="col-md-6">
                                    <label for="optimal_drinking" class="form-label">Optimal Drinking</label>
                                    <input type="text" class="form-control" name="optimal_drinking" id="optimal_drinking">
                                </div>
                                <div class="col-md-6">
                                    <label for="style" class="form-label">Style</label>
                                    <input type="text" class="form-control" name="style" id="style">
                                </div>
                                <div class="col-md-6">
                                    <label for="decanting_time" class="form-label">Decanting Time</label>
                                    <input type="text" class="form-control" name="decanting_time" id="decanting_time">
                                </div>
                                <div class="col-md-6">
                                    <label for="ageing_potential" class="form-label">Ageing Potential</label>
                                    <input type="text" class="form-control" name="ageing_potential" id="ageing_potential">
                                </div>
                                <div class="col-md-6">
                                    <label for="cheese_pairing" class="form-label">Cheese Pairing</label>
                                    <input type="text" class="form-control" name="cheese_pairing" id="cheese_pairing">
                                </div>
                                <div class="col-md-6">
                                    <label for="importer_info" class="form-label">Importer Info</label>
                                    <input type="text" class="form-control" name="importer_info" id="importer_info">
                                </div>
                                <div class="col-md-6">
                                    <label for="wine_story" class="form-label">Wine Story</label>
                                    <textarea class="form-control" name="wine_story" id="wine_story" rows="2"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="tasting_notes" class="form-label">Tasting Notes</label>
                                    <textarea class="form-control" name="tasting_notes" id="tasting_notes" rows="2"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="status">Status</label>
                                    <select class="form-select" name="status" id="status" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Image Upload Section (Max 5) -->
                            <div class="mt-4">
                                <label class="form-label">Product Images (Max 5)</label>
                                <input type="file" name="product_images[]" id="product_images" class="form-control" multiple accept="image/*" onchange="limitImageUpload(this)">
                                <small class="text-muted">Allowed formats: jpeg, jpg, png, gif | Max size: 2MB</small>
                                <div id="image-preview-container" class="row mt-2"></div>

                                <div class="mt-3 d-none" id="primary-image-selection">
                                    <label for="primary_image" class="form-label">Select Primary Image</label>
                                    <select name="primary_image" id="primary_image" class="form-select"></select>
                                </div>
                            </div>

                            <!-- Submit -->
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
    <script>
        function limitImageUpload(input) {
            const maxFiles = 5;
            const files = input.files;
            if (files.length > maxFiles) {
                alert("You can upload up to 5 images only.");
                input.value = ""; // Clear input
            }
        }
    </script>

@endpush


