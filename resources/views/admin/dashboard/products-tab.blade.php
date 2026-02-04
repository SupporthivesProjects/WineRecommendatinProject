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
                                            <th class="text-start">Featured</th>
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
                                                <td class="align-middle">₹&nbsp;{{ number_format($product->retail_price, 2) }}</td>
                                                <td class="align-middle text-center">
                                                    <div class="form-check form-switch d-inline-block">
                                                        <input type="checkbox" class="form-check-input featured-toggle" 
                                                               data-product-id="{{ $product->id }}"
                                                               id="featured-{{ $product->id }}"
                                                               {{ $product->admin_featured_product ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="featured-{{ $product->id }}"></label>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <span class="badge rounded-pill border border-{{ $product->status === 'active' ? 'success' : 'danger' }} text-{{ $product->status === 'active' ? 'success' : 'danger' }} py-1 px-3">
                                                        {{ ucfirst($product->status) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="btn-group">
                                                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-primary">
                                                            <i class="fe fe-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-info">
                                                            <i class="fe fe-edit"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No products found</td>
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
@endsection

@push('scripts')
    <script>
        // Toggle featured status
        // $(document).ready(function() {
        //     $('.featured-toggle').change(function() {
        //         alert("I am here");
        //         const productId = $(this).data('product-id');
        //         const isFeatured = $(this).is(':checked') ? 1 : 0;
        //         const url = '{{ route("admin.products.toggle-featured", [""]) }}/' + productId;
    
        //         $.ajax({
        //             url: url,
        //             type: 'POST',
        //             data: {
        //                 _token: '{{ csrf_token() }}',
        //                 is_featured: isFeatured
        //             },
        //             success: function(response) {
        //                 if (response.success) {
        //                     toastr.success('Featured status updated successfully');
        //                 } else {
        //                     toastr.error('Failed to update featured status');
        //                     // Revert the toggle if there was an error
        //                     $('.featured-toggle[data-product-id="' + productId + '"]').prop('checked', !isFeatured);
        //                 }
        //             },
        //             error: function(xhr) {
        //                 toastr.error('An error occurred: ' + (xhr.responseJSON?.message || 'Unknown error'));
        //                 // Revert the toggle on error
        //                 $('.featured-toggle[data-product-id="' + productId + '"]').prop('checked', !isFeatured);
        //             }
        //         });
        //     });
        // });

        $(document).ready(function () {
        // Initialize DataTable first
        $('#file-export').DataTable();

        // Then add delegated event listener
        $(document).on('change', '.featured-toggle', function () {
            const productId = $(this).data('product-id');
            const isFeatured = $(this).is(':checked') ? 1 : 0;
            const url = '{{ route("admin.products.toggle-featured", [""]) }}/' + productId;

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    is_featured: isFeatured
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Featured status updated successfully');
                    } else {
                        toastr.error('Failed to update featured status');
                    }
                },
                error: function(xhr) {
                    toastr.error('An error occurred');
                }
            });

        });

        });


    </script>
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
