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
            <div class="">
                <div class="container-lg">
                    {{-- Product Details Card --}}
                    <div class="col-md-12 col-xl-12 mt-5">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-header border-bottom-0 d-flex pb-0 justify-content-between">
                                <div>
                                    <label class="main-content-label mb-2 pt-1">Products Details</label>
                                    <p class="fs-12 mb-3 text-muted mb-0">
                                        The details displayed often include size, color, price, shipping information, reviews, and other relevant information customers may want to know before making a purchase
                                    </p>
                                </div>
                                <div class="card-options float-end">
                                    <a href="javascript:void(0);" class="me-0 text-default" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                                        <span class="fe fe-more-vertical fs-17 float-end"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" role="menu">
                                        <li><a href="#"><i class="fe fe-download-cloud me-2"></i>Download</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table table-vcenter border mb-0 text-nowrap table-product">
                                        <thead>
                                            <tr>
                                                <th>Product ID</th>
                                                <th>Product</th>
                                                <th>Type</th>
                                                <th>Vintage</th>
                                                <th>Status</th>
                                                <th>Available</th>
                                                <th>Featured</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($allProducts as $product)
                                            @php
                                                $isAvailable = isset($storeProducts[$product->id]);
                                                $isFeatured = $isAvailable && $storeProducts[$product->id]->is_featured;
                                            @endphp
                                                <tr>
                                                    <td>#{{ $product->id }}</td>
                                                    <td class="d-flex align-items-center">
                                                        @php
                                                            $image = $product->images->first();
                                                        @endphp
                                                        <img src="{{ $image ? asset('storage/products/' . $image->image_path) : asset('images/default.jpg') }}" alt="" class="ht-50 wd-50 me-3">
                                                        <span class="my-auto text-truncate">{{ $product->wine_name }}</span>
                                                        <a href="{{ route('store-manager.singleproduct', $product->id) }}" class="ms-2" title="View Product">
                                                            <i class="bi bi-box-arrow-up-right"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                    @php
                                                        $icons = [
                                                            'red' => '<i class="fas fa-wine-glass text-danger" title="Red Wine"></i>',
                                                            'white' => '<i class="fas fa-wine-glass text-warning" title="White Wine"></i>',
                                                            'sparkling' => '<i class="fas fa-champagne-glasses text-info" title="Sparkling Wine"></i>',
                                                            'still' => '<i class="fas fa-tint text-primary" title="Still Wine"></i>',
                                                        ];
                                                    @endphp
                                                    {!! $icons[$product->type] ?? '<i class="fas fa-question-circle"></i>' !!}
                                                    {{ ucfirst($product->type) }}
                                                    </td>
                                                    <td>{{ $product->vintage_year }}</td>
                                                    <td>
                                                    <span class="badge rounded-pill {{ $product->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $product->status === 'active' ? 'Available' : 'Not in Stock' }}
                                                    </span>
                                                    </td>
                                                    <!-- Available Checkbox -->
                                                    <td>
                                                        <input type="checkbox" name="available[]" value="{{ $product->id }}" {{ $isAvailable ? 'checked' : '' }}>
                                                    </td>
                                                    <!-- Featured Checkbox -->
                                                    <td>
                                                        <input type="checkbox" name="featured[]" value="{{ $product->id }}" {{ $isFeatured ? 'checked' : '' }}>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- End::Content -->

        <!-- Pagination Code Starts -->
            @if ($allProducts->hasPages())
                <div class="d-flex justify-content-center my-4">
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0">
                            {{-- Previous Page Link --}}
                            @if ($allProducts->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link"><i class="bi bi-caret-left"></i></span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $allProducts->previousPageUrl() }}" rel="prev">
                                        <i class="bi bi-caret-left"></i>
                                    </a>
                                </li>
                            @endif

                            {{-- Page Number Links --}}
                            @foreach ($allProducts->getUrlRange(1, $allProducts->lastPage()) as $page => $url)
                                <li class="page-item {{ $allProducts->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($allProducts->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $allProducts->nextPageUrl() }}" rel="next">
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
        <!-- Pagination Code ends -->
    </div>
</div>

@endsection

@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Function to show toastr messages based on the response
            function showToastr(response, action) {
                response.json().then(data => {
                    console.log(`Response for ${action}:`, data); // Debug output

                    if (response.ok && data.success) {
                        toastr.success(`Product ${action} updated successfully.`);
                    } else {
                        toastr.error(`Failed to update product ${action}.`);
                    }
                }).catch(err => {
                    console.error(`JSON parsing failed for ${action}:`, err); // JSON error debug
                    toastr.error(`Unexpected error for product ${action}.`);
                });
            }

            // Handle 'available' checkbox change
            document.querySelectorAll('input[name="available[]"]').forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    const productId = this.value;
                    const status = this.checked ? 'active' : 'inactive';

                    // If unchecking 'available' and 'featured' is still checked, show warning and revert change
                    const featuredCheckbox = document.querySelector(`input[name="featured[]"][value="${productId}"]`);
                    if (!this.checked && featuredCheckbox && featuredCheckbox.checked) {
                        toastr.warning('You cannot make the product unavailable while it is featured.');
                        this.checked = true; // Revert 'available' checkbox to checked
                        return; // Exit function
                    }

                    // Update status for availability
                    fetch(`/store-manager/products/update-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ product_id: productId, status: status })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json(); // Parse the JSON body
                    })
                    .then(data => {
                        toastr.success(data.message || 'Product status updated successfully');
                    })
                    .catch(error => {
                        console.error('Error updating product status:', error);
                        toastr.error('Failed to update product status');
                    });
                });
            });

            // Handle 'featured' checkbox change
            document.querySelectorAll('input[name="featured[]"]').forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    const productId = this.value;

                    // If 'available' is unchecked, show warning and prevent checking 'featured'
                    const availableCheckbox = document.querySelector(`input[name="available[]"][value="${productId}"]`);
                    if (this.checked && !availableCheckbox.checked) {
                        toastr.warning('Product must be available before featuring.');
                        this.checked = false; // Revert 'featured' checkbox to unchecked
                        return; // Exit function
                    }

                    const is_featured = this.checked ? 1 : 0;

                    // Update featured status for the product
                    fetch(`/store-manager/products/update-featured`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ product_id: productId, is_featured: is_featured })
                    }).then(response => showToastr(response, 'featured flag'))
                    .catch(() => toastr.error('Something went wrong.'));
                });
            });
        });
    </script>


@endpush