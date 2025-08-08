@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
        <style>
            .dataTables_filter input[type="search"] {
                width: 300px !important;
                margin-bottom: 20px;
            }
            .product-thumbnail {
                width: 80px;
                height: 80px;
                object-fit: cover;
                border-radius: 4px;
            }
        </style>
    @endpush
    
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Select Cheese Products for Store</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Select Cheese Products</li>
                    </ol>
                </div>
                <div class="d-flex">
                    <a href="{{ route('store-manager.dashboard') }}" class="btn btn-wave btn-secondary my-2">
                        <i class="fe fe-arrow-left me-2"></i> Back to Dashboard
                    </a>
                </div>
            </div>
            <!-- End::page-header -->

            <!-- Start::row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h4 class="card-title">Cheese Products List</h4>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-vcenter border mb-0 text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Quantity in Store</th>
                                            <th>Status</th>
                                            <th>Available</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cheeseProducts as $product)
                                            <tr>
                                                <td class="d-flex align-items-center">
                                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default-cheese.jpg') }}" 
                                                         alt="{{ $product->name }}" class="product-thumbnail me-3">
                                                    <span>{{ $product->name }}</span>
                                                </td>
                                                <td>{{ Str::limit($product->description, 50) }}</td>
                                                <td>${{ number_format($product->price, 2) }}</td>
                                                <td>
                                                    @if(isset($product->store_quantity))
                                                        {{ $product->store_quantity }}
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($product->is_available_in_store)
                                                        <span class="badge rounded-pill bg-success">In Stock</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-secondary">Out of Stock</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input available-checkbox" 
                                                               type="checkbox" 
                                                               data-product-id="{{ $product->id }}"
                                                               {{ $product->is_available_in_store ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                                <td>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if ($cheeseProducts->hasPages())
                                <div class="d-flex justify-content-center my-4">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination mb-0">
                                            {{-- Previous Page Link --}}
                                            @if ($cheeseProducts->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link"><i class="bi bi-caret-left"></i></span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $cheeseProducts->previousPageUrl() }}" rel="prev">
                                                        <i class="bi bi-caret-left"></i>
                                                    </a>
                                                </li>
                                            @endif

                                            {{-- Page Number Links --}}
                                            @foreach ($cheeseProducts->getUrlRange(1, $cheeseProducts->lastPage()) as $page => $url)
                                                <li class="page-item {{ $cheeseProducts->currentPage() == $page ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endforeach

                                            {{-- Next Page Link --}}
                                            @if ($cheeseProducts->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $cheeseProducts->nextPageUrl() }}" rel="next">
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
                </div>
            </div>
            <!-- End::row -->
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle 'available' checkbox change
            document.querySelectorAll('.available-checkbox').forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    const productId = this.dataset.productId;
                    const status = this.checked ? 'active' : 'inactive';
                    const row = this.closest('tr');
                    const loadingSpinner = document.createElement('span');
                    loadingSpinner.className = 'spinner-border spinner-border-sm ms-2';
                    this.disabled = true;
                    this.parentNode.appendChild(loadingSpinner);

                    // If unchecking 'available' and 'featured' is checked, show warning and revert
                    const featuredCheckbox = document.querySelector(`.featured-checkbox[data-product-id="${productId}"]`);
                    if (!this.checked && featuredCheckbox && featuredCheckbox.checked) {
                        toastr.warning('You cannot make the product unavailable while it is featured.');
                        this.checked = true;
                        this.disabled = false;
                        loadingSpinner.remove();
                        return;
                    }

                    // Update status
                    fetch('{{ route("store-manager.cheese-products.update-status") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            status: status
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            toastr.success(data.message);
                            // Enable/disable featured checkbox based on availability
                            if (featuredCheckbox) {
                                featuredCheckbox.disabled = !this.checked;
                                if (!this.checked) {
                                    featuredCheckbox.checked = false;
                                }
                            }
                            // Update UI to reflect changes
                            if (row) {
                                if (this.checked) {
                                    row.classList.remove('table-secondary');
                                } else {
                                    row.classList.add('table-secondary');
                                }
                            }
                        } else {
                            throw new Error(data.message || 'Failed to update product status');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error(error.message || 'An error occurred while updating the product status');
                        this.checked = !this.checked; // Revert on error
                    })
                    .finally(() => {
                        this.disabled = false;
                        loadingSpinner.remove();
                    });
                });
            });

            // Handle 'featured' checkbox change
            document.querySelectorAll('.featured-checkbox').forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    const productId = this.dataset.productId;
                    const isFeatured = this.checked;
                    const row = this.closest('tr');
                    const loadingSpinner = document.createElement('span');
                    loadingSpinner.className = 'spinner-border spinner-border-sm ms-2';
                    this.disabled = true;
                    this.parentNode.appendChild(loadingSpinner);

                    // Update featured status
                    fetch('{{ route("store-manager.cheese-products.update-featured") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            featured: isFeatured
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            toastr.success(data.message);
                            // Update UI to reflect changes
                            if (row) {
                                if (this.checked) {
                                    row.classList.add('table-primary');
                                } else {
                                    row.classList.remove('table-primary');
                                }
                            }
                        } else {
                            throw new Error(data.message || 'Failed to update featured status');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error(error.message || 'An error occurred while updating the featured status');
                        this.checked = !this.checked; // Revert on error
                    })
                    .finally(() => {
                        this.disabled = false;
                        loadingSpinner.remove();
                    });
                });
            });

            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
    @endpush
@endsection
