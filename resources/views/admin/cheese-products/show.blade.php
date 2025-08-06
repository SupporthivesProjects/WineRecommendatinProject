@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
    <style>
        .dataTables_filter input[type="search"] {
            width: 300px !important; 
            padding: 6px 12px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
        }
    </style>
    @endpush
    
    <div class="main-content app-content">
        <div class="container-fluid">
            <div id="product-details">
                <div class="loading-spinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productId = window.location.pathname.split('/').pop();
            const apiUrl = `/admin/api/cheese-products/${productId}`;
            const productDetailsContainer = document.getElementById('product-details');

            fetch(apiUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch product details');
                    }
                    return response.json();
                })
                .then(product => {
                    // Format price
                    const formattedPrice = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD'
                    }).format(product.price);

                    // Format stores table rows
                    let storesHtml = '';
                    if (product.stores && product.stores.length > 0) {
                        storesHtml = product.stores.map(store => `
                            <tr>
                                <td class="text-start">${store.store_name}</td>
                                <td class="text-start">${store.quantity}</td>
                                <td class="text-start">
                                    <span class="badge rounded-pill border border-${store.is_active ? 'success' : 'danger'} text-${store.is_active ? 'success' : 'danger'} py-1 px-3">
                                        ${store.is_active ? 'Active' : 'Inactive'}
                                    </span>
                                </td>
                                <td class="text-start">${store.last_updated || 'N/A'}</td>
                            </tr>
                        `).join('');
                    } else {
                        storesHtml = `
                            <tr>
                                <td colspan="4" class="text-center">No store availability data found.</td>
                            </tr>
                        `;
                    }

                    // Create the HTML for the product details
                    const productHtml = `
                        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                            <div>
                                <h2 class="main-content-title fs-24 mb-1">Cheese Product Details</h2>
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="${window.location.origin}/admin/dashboard">Home</a></li>
                                    <li class="breadcrumb-item"><a href="${window.location.origin}/admin/cheese-products">Cheese Products</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">${product.name}</li>
                                </ol>
                            </div>
                            <div class="d-flex">
                                <a href="${window.location.origin}/admin/cheese-products/${product.id}/edit" class="btn btn-wave btn-primary my-2 btn-icon-text">
                                    <i class="fe fe-edit me-2"></i> Edit Product
                                </a>
                                <form action="${window.location.origin}/admin/cheese-products/${product.id}" method="POST" class="d-inline ms-2">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-wave btn-danger my-2 btn-icon-text" 
                                            onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="fe fe-trash-2 me-2"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card custom-card detail-card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                ${product.image ? 
                                                    `<img src="${product.image}" alt="${product.name}" class="product-image img-fluid rounded">` : 
                                                    `<div class="bg-light d-flex align-items-center justify-content-center" style="width: 100%; height: 300px;">
                                                        <i class="fe fe-image" style="font-size: 4rem; color: #ccc;"></i>
                                                    </div>`
                                                }
                                            </div>
                                            <div class="col-md-8">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <tbody>
                                                            <tr>
                                                                <th class="text-nowrap" style="width: 200px;">Name</th>
                                                                <td>${product.name || 'N/A'}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-nowrap">Price</th>
                                                                <td>${formattedPrice}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-nowrap">Status</th>
                                                                <td>
                                                                    <span class="badge rounded-pill border border-${product.is_active ? 'success' : 'danger'} text-${product.is_active ? 'success' : 'danger'} py-1 px-3">
                                                                        ${product.is_active ? 'Active' : 'Inactive'}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-nowrap">Description</th>
                                                                <td>${product.description ? product.description.replace(/\n/g, '<br>') : '<span class="text-muted">No description provided</span>'}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-nowrap">Created At</th>
                                                                <td>${product.created_at || 'N/A'}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-nowrap">Updated At</th>
                                                                <td>${product.updated_at || 'N/A'}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Store Availability Section -->
                                <div class="card custom-card">
                                    <div class="card-header">
                                        <h4 class="card-title">Store Availability</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-start">Store Name</th>
                                                        <th class="text-start">Quantity</th>
                                                        <th class="text-start">Status</th>
                                                        <th class="text-start">Last Updated</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ${storesHtml}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Store Availability Section -->
                            </div>
                        </div>
                    `;

                    // Update the DOM with the product details
                    productDetailsContainer.innerHTML = productHtml;
                })
                .catch(error => {
                    console.error('Error:', error);
                    productDetailsContainer.innerHTML = `
                        <div class="alert alert-danger" role="alert">
                            Failed to load product details. Please try again later.
                        </div>
                    `;
                });
        });
    </script>
    @endpush
@endsection
