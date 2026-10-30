@extends('layouts.bootdashboard')
@section('admindashboardcontent')

@push('styles')
<style>
    .dataTables_filter input {
        width: 300px !important; /* increase search box length */
    }

    .dataTables_filter {
        margin-left: 20px;
    }

    .row-success {
        border: 4px solid #28a745 !important;
        transition: all 0.3s ease;
    }

    .row-error {
        border: 4px solid #dc3545 !important;
        transition: all 0.3s ease;
    }


    .save-status {
        font-size: 12px;
        font-weight: 600;
    }

    .save-status.updating {
        color: #0d6efd;
    }

    .save-status.success {
        color: #198754;
    }

    .save-status.error {
        color: #dc3545;
    }

</style>


@endpush

<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Start::Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
            <div>
                <h2 class="main-content-title fs-24 mb-1">{{ __('Select Wine Products for Store') }}</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Select Wine Products</li>
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
                                    <label class="main-content-label mb-2 pt-1">Wine Products Details</label>
                                    <p class="fs-12 mb-3 text-muted mb-0">
                                        The details displayed often include size, color, price, shipping information, reviews, and other relevant information customers may want to know before making a purchase
                                    </p>
                                </div>
                                <div class="card-options float-end">
                                    <!-- <a href="javascript:void(0);" class="me-0 text-default" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                                        <span class="fe fe-more-vertical fs-17 float-end"></span>
                                    </a> -->
                                    <ul class="dropdown-menu dropdown-menu-end" role="menu">
                                        <li><a href="#"><i class="fe fe-download-cloud me-2"></i>Download</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table id="productTable" class="table table-vcenter border mb-0 text-nowrap table-product">
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
                                        {{-- Rows are loaded page by page by StoreManager\ProductController@index --}}
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- End::Content -->

        <!-- Pagination Code Starts -->
        

        <!-- Pagination Code ends -->
    </div>
</div>

@endsection

@push('scripts')

    <script>
        $(document).ready(function() {
            $('#productTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: '{{ route('store-manager.products') }}',
                searchDelay: 400,
                columns: [
                    null,
                    { className: 'd-flex align-items-center' },
                    null,
                    null,
                    null,
                    null,
                    null
                ],
                "pageLength": 10,
                "lengthMenu": [10, 20, 50, 100],
                dom: '<"d-flex align-items-center gap-3"l f>rtip',
                "language": {
                search: "Search Products:",
                searchPlaceholder: "Type to filter..."
            }
            });
        });
    </script>



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

            // Rows are redrawn on every page change, so listen on the document instead of on each checkbox
            document.addEventListener('change', function (event) {
                if (event.target.matches('input[name="available[]"]')) {
                    onAvailableChange.call(event.target);
                } else if (event.target.matches('input[name="featured[]"]')) {
                    onFeaturedChange.call(event.target);
                }
            });

            // Handle 'available' checkbox change
            function onAvailableChange() {
                    const row = this.closest('tr');
                    const productId = this.value;
                    const status = this.checked ? 'active' : 'inactive';

                    const statusEl = row.querySelector('.save-status');
                    statusEl.style.display = 'inline';
                    statusEl.className = 'save-status updating';
                    statusEl.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1"></span> Updating...';


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
                        row.classList.add('row-success');
                        setTimeout(() => {
                            row.classList.remove('row-success');
                        }, 2000);
                        statusEl.className = 'save-status success';
                        statusEl.innerHTML = '✓ Updated';

                        setTimeout(() => {
                            statusEl.style.display = 'none';
                        }, 2000);

                    })
                    .catch(error => {
                        console.error('Error updating product status:', error);
                        toastr.error('Failed to update product status');
                        row.classList.add('row-error');
                            setTimeout(() => {
                                row.classList.remove('row-error');
                            }, 3000);
                            statusEl.className = 'save-status error';
                            statusEl.innerHTML = '✗ Update Failed';

                            setTimeout(() => {
                                statusEl.style.display = 'none';
                            }, 3000);

                    });
            }

            // Handle 'featured' checkbox change
            function onFeaturedChange() {
                    const productId = this.value;
                    const row = this.closest('tr');
                    const statusEl = row.querySelector('.save-status');
                    statusEl.style.display = 'inline';
                    statusEl.className = 'save-status updating';
                    statusEl.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1"></span> Updating...';

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
                    }).then(response => {
                        showToastr(response, 'featured flag');
                        row.classList.add('row-success');
                        setTimeout(() => {
                            row.classList.remove('row-success');
                        }, 2000);
                        statusEl.className = 'save-status success';
                        statusEl.innerHTML = '✓ Updated';
                        setTimeout(() => {
                            statusEl.style.display = 'none';
                        }, 2000);

                        })
                        .catch(() => {
                        toastr.error('Something went wrong.');
                        row.classList.add('row-error');
                        setTimeout(() => {
                            row.classList.remove('row-error');
                        }, 3000);
                        statusEl.className = 'save-status error';
                        statusEl.innerHTML = '✗ Update Failed';
                        setTimeout(() => {
                            statusEl.style.display = 'none';
                        }, 3000);

                        });
            }
        });
    </script>


@endpush