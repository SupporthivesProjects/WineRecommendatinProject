@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
    <style>
        .dataTables_filter input[type="search"] {
            width: 300px !important; 
            margin-bottom: 20px;
        }
            #image-preview-container img {
            max-height: 150px;
            object-fit: cover;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--multiple {
            min-height: 38px;
            padding: 5px 5px 0 5px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 2px 8px;
            margin-right: 5px;
            margin-bottom: 5px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #6c757d;
            margin-right: 5px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #495057;
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
                        <li class="breadcrumb-item active" aria-current="page">Add Products</li>
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
                        <form method="POST" enctype="multipart/form-data" id="product-form" action="{{ route('admin.products.store') }}">
                            @csrf
                            <div class="container-fluid">
                                <div class="row g-3">
                                   
                                    <div class="col-md-6">
                                        <label for="wine_name" class="form-label">Wine Name</label>
                                        <input type="text" class="form-control" name="wine_name" id="wine_name" required placeholder="Enter Name(text)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="type" class="form-label">Type</label>
                                        <select class="form-select" name="type" id="type" >
                                            <option value="">Select Type</option>
                                            <option value="red">Red Wine</option>
                                            <option value="white">White Wine</option>
                                            <option value="rose">Rosé</option>
                                            <option value="sparkling">Sparkling</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="type" class="form-label">Speical Mentions</label>
                                        <select class="form-select" name="sp_mentions" id="sp_mentions">
                                            <option value="">Select</option>
                                            <option value="fortified">Fortified</option>
                                            <option value="port">Port</option>
                                            <option value="marsala">Marsala</option>
                                            <option value="sherry">Sherry</option>
                                            <option value="orange">Orange</option>
                                            <option value="fruit">Fruit</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="type" class="form-label">Method</label>
                                        <select class="form-select" name="method" id="method">
                                            <option value="">Select Method</option>
                                            <option value="still">Still</option>
                                            <option value="sparkling">Sparkling</option>
                                            <option value="semi sparkling">Semi Sparkling</option>
                                            <option value="fortified">Fortified</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="winery" class="form-label">Winery</label>
                                        <input type="text" class="form-control" name="winery" id="winery" placeholder="Enter winery(text)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="grape_variety" class="form-label">Grape Variety</label>
                                        <input type="text" class="form-control" name="grape_variety" id="grape_variety" placeholder="Enter Grape variety(text)">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="varietal_blend" class="form-label">Varietal Blend</label>
                                        <input type="text" class="form-control" name="varietal_blend" id="varietal_blend" placeholder="Enter Varietal Blend(text)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="vintage_year" class="form-label">Vintage Year</label>
                                        <input type="text" class="form-control" name="vintage_year" id="vintage_year" placeholder="Enter Vintage year(number)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" class="form-control" name="country" id="country" placeholder="Enter country name (text)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="region" class="form-label">Region</label>
                                        <input type="text" class="form-control" name="region" id="region" placeholder="Enter Region (text)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="wine_sub_region" class="form-label">Sub Region</label>
                                        <input type="text" class="form-control" name="wine_sub_region" id="wine_sub_region" placeholder="Enter Sub Region (text)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="designation" class="form-label">Designation</label>
                                        <input type="text" class="form-control" name="designation" id="designation" placeholder="Enter Description (text)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="alcohol_vol" class="form-label">Alcohol Volume</label>
                                        <input type="text" class="form-control" name="alcohol_vol" id="alcohol_vol" placeholder="Enter Alcohol Volume(number)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="residual_sugar" class="form-label">Residual Sugar</label>
                                        <input type="text" class="form-control" name="residual_sugar" id="residual_sugar" placeholder="Enter Residual Sugar(number)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nature" class="form-label">Nature</label>
                                        <input type="text" class="form-control" name="nature" id="nature" placeholder="Enter nature(text)"> 
                                    </div>
                                    <div class="col-md-6">
                                        <label for="acidity" class="form-label">Acidity</label>
                                        <input type="text" class="form-control" name="acidity" id="acidity" placeholder="Enter Actidity(text)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tannin_level" class="form-label">Tannin Level</label>
                                        <input type="text" class="form-control" name="tannin_level" id="tannin_level" placeholder="Enter tanin level(text)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="body" class="form-label">Body</label>
                                        <input type="text" class="form-control" name="body" id="body" placeholder="Enter body(text)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="aging" class="form-label">Aging</label>
                                        <input type="text" class="form-control" name="aging" id="aging" placeholder="Enter Aging(text)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="barrel_type" class="form-label">Barrel Type</label>
                                        <input type="text" class="form-control" name="barrel_type" id="barrel_type" placeholder="Enter Barrel type(text)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="time_spent_aging" class="form-label">Time Spent Aging</label>
                                        <input type="text" class="form-control" name="time_spent_aging" id="time_spent_aging" placeholder="Enter Aging time(Eg:<3 months">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="closure_type" class="form-label">Closure Type</label>
                                        <input type="text" class="form-control" name="closure_type" id="closure_type" placeholder="Enter Closure type (text)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="aroma" class="form-label">Aroma</label>
                                        <textarea class="form-control" name="aroma" id="aroma" rows="2" placeholder="Enter Aroma(Comma separated names)"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="palate" class="form-label">Palate</label>
                                        <textarea class="form-control" name="palate" id="palate" rows="2" placeholder="Enter palate(Comma separated names"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="finish" class="form-label">Finish</label>
                                        <textarea class="form-control" name="finish" id="finish" rows="2" placeholder="Enter Finish(text)"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="sweetness_level" class="form-label">Sweetness Level</label>
                                        <input type="text" class="form-control" name="sweetness_level" id="sweetness_level" placeholder="Enter Sweetness(number)"> 
                                    </div>
                                    <div class="col-md-6">
                                        <label for="glass_ware" class="form-label">Glass Ware</label>
                                        <input type="text" class="form-control" name="glass_ware" id="glass_ware" placeholder="Enter Glassware(text)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="retail_price" class="form-label">Retail Price</label>
                                        <input type="number" class="form-control" name="retail_price" id="retail_price" step="0.01" placeholder="Enter Retail Price(number)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="discounts" class="form-label">Discounts</label>
                                        <input type="text" class="form-control" name="discounts" id="discounts" placeholder="Enter Discount(number)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="optimal_drinking" class="form-label">Optimal Drinking</label>
                                        <input type="text" class="form-control" name="optimal_drinking" id="optimal_drinking" placeholder="Enter Value(Eg: 1-2 years)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="style" class="form-label">Style</label>
                                        <input type="text" class="form-control" name="style" id="style" placeholder="Enter Style(text)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="decanting_time" class="form-label">Decanting Time</label>
                                        <input type="text" class="form-control" name="decanting_time" id="decanting_time" placeholder="Enter Time(3-5 years)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="ageing_potential" class="form-label">Ageing Potential</label>
                                        <input type="text" class="form-control" name="ageing_potential" id="ageing_potential" placeholder="Enter Ageing(3-5 years)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cheese_pairing" class="form-label">Cheese Pairing</label>
                                        <select class="form-select select2" name="cheese_pairing[]" id="cheese_pairing" multiple placeholder="Enter pairing(comma separated values)>
                                            @foreach(\App\Models\CheeseProduct::all() as $cheese)
                                                <option value="{{ $cheese->name }}">{{ $cheese->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="importer_info" class="form-label">Importer Info</label>
                                        <input type="text" class="form-control" name="importer_info" id="importer_info" placeholder="Enter name(text)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="wine_story" class="form-label">Wine Story</label>
                                        <textarea class="form-control" name="wine_story" id="wine_story" rows="2" placeholder="Enter Story(text)"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tasting_notes" class="form-label">Tasting Notes</label>
                                        <textarea class="form-control" name="tasting_notes" id="tasting_notes" rows="2" placeholder="Enter Notes(text)"></textarea>
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
                                    <label class="form-label">Upload Product Image</label>
                                    <input type="file" name="product_image" id="product_image" class="form-control" multiple accept="image/*" onchange="previewImages(this)">
                                    <small class="text-muted">Allowed formats: jpeg, jpg, png, gif | Max size: 2MB</small>
                                    <div id="image-preview-container" class="row mt-2"></div>

                                    <div class="mt-3 d-none" id="primary-image-selection">
                                        <label for="primary_image" class="form-label">Select Primary Image</label>
                                        <select name="primary_image" id="primary_image" class="form-select"></select>
                                    </div>
                                </div>
                                <div class="row g-3 mt-3">
                                    <div class="col-md-6">
                                        <label for="category" class="form-label">Category</label>
                                        <select class="form-select" name="categories" id="categories" required>
                                            <option value="">Select Category</option>
                                            <option value="Gifting">Gifting</option>
                                            <option value="Wine and Cheese">Wine and Cheese</option>
                                            <option value="Everyday sipping">Everyday sipping</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="d-flex justify-content-end mt-4">
                                    <button type="submit" class="btn btn-primary">Add Product</button>
                                </div>
                            </div>
                        </form>
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
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select cheese pairings',
                allowClear: true,
                tags: true,
                tokenSeparators: [',', ' '],
                createTag: function(params) {
                    return {
                        id: params.term,
                        text: params.term,
                        newOption: true
                    }
                },
                templateResult: function(data) {
                    var $result = $("<span></span>");
                    $result.text(data.text);
                    if (data.newOption) {
                        $result.append(" <em>(new)</em>");
                    }
                    return $result;
                }
            });

            // Format the cheese pairings when editing (if needed)
            @if(isset($product) && $product->cheese_pairing)
                var cheesePairings = {!! json_encode(explode(',', $product->cheese_pairing)) !!};
                $('#cheese_pairing').val(cheesePairings).trigger('change');
            @endif
        });
    </script>
    <!-- JS Function to preview images -->
    <!-- <script>
        let selectedFiles = [];

        function previewImages(input) {
            const maxFiles = 5;
            const maxSize = 2 * 1024 * 1024; // 2MB
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            const newFiles = Array.from(input.files);

            for (const file of newFiles) {
                if (selectedFiles.length >= maxFiles) {
                    alert("You can only upload up to 5 images.");
                    break;
                }

                if (!allowedTypes.includes(file.type)) {
                    alert(`File "${file.name}" is not a supported format.`);
                    continue;
                }

                if (file.size > maxSize) {
                    alert(`File "${file.name}" exceeds 2MB size limit.`);
                    continue;
                }

                selectedFiles.push(file);
            }

            renderPreviews();
            input.value = ""; // Reset so same file can be selected again
        }

        function removeImage(index) {
            selectedFiles.splice(index, 1);
            renderPreviews();
        }

        function renderPreviews() {
            const previewContainer = document.getElementById('image-preview-container');
            const primarySelect = document.getElementById('primary_image');
            const primarySection = document.getElementById('primary-image-selection');

            previewContainer.innerHTML = "";
            primarySelect.innerHTML = "<option value=''>Select Primary Image</option>";

            if (selectedFiles.length > 0) {
                primarySection.classList.remove('d-none');
            } else {
                primarySection.classList.add('d-none');
            }

            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const col = document.createElement('div');
                    col.className = "col-6 mb-2 position-relative";

                    col.innerHTML = `
                        <img src="${e.target.result}" class="img-fluid rounded border" alt="Product Image">
                        <button type="button" onclick="removeImage(${index})"
                            class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1"
                            title="Remove Image">&times;</button>
                    `;

                    previewContainer.appendChild(col);

                    const option = document.createElement('option');
                    option.value = index;
                    option.text = file.name;
                    primarySelect.appendChild(option);
                };
                reader.readAsDataURL(file);
            });
        }

        // Handle form submission
        function submitForm(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData();
            selectedFiles.forEach(file => {
                formData.append('product_images[]', file);
            });

            // Add other form fields if necessary, e.g. the primary image selection
            const primaryImage = document.getElementById('primary_image').value;
            formData.append('primary_image', primaryImage);

            // Send the form data via AJAX
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch('{{ route("admin.products.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,  // Use dynamic CSRF token
                }
            })
            .then(response => {
                // Check if the response status is OK (2xx)
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Something went wrong with the response');
                    });
                }
                return response.json();  // If response is OK, parse it
            })
            .then(data => {
                // Handle the response
                console.log(data);
            })
            .catch(error => {
                // Log detailed error information
                if (error instanceof Error) {
                    console.error('Error:', error.message);
                } else if (error.response) {
                    console.error('Response Error:', error.response);
                } else {
                    console.error('Unknown Error:', error);
                }
            });



        }

        // Attach the submitForm function to the form
        document.getElementById('product-form').addEventListener('submit', submitForm);
    </script> -->
@endpush
