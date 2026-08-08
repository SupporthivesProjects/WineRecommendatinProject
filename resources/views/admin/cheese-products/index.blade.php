@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
    <style>
        .dataTables_filter input[type="search"] {
            width: 300px !important; 
            margin-bottom: 20px;
        }
        .product-thumbnail {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
        .action-btns .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            line-height: 1.5;
        }
    </style>
    @endpush

    <!-- Cheese Products Section -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Cheese Products Board</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cheese Products</li>
                    </ol>
                </div>

                <div class="d-flex gap-2">
                    <a  href="{{ route('admin.products.cheese-bulk-upload') }}" type="button" class="btn btn-wave btn-primary my-2 btn-icon-text">
                        <i class="fe fe-plus me-2"></i> Bulk Upload
                    </a>
                    <a href="{{ route('admin.cheese-products.create') }}" type="button" class="btn btn-wave btn-secondary my-2 btn-icon-text">
                        <i class="fe fe-plus me-2"></i> Add Cheese Product
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
                                            <th class="text-start">Image</th>
                                            <th class="text-start">Name</th>
                                            <!-- <th class="text-start">Price</th> -->
                                            <th class="text-start">Status</th>
                                            <th class="text-start">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($products as $index => $product)
                                            <tr>
                                                <td class="align-middle">{{ $index + 1 }}</td>
                                                <td class="align-middle">
                                                    @if($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                                             alt="{{ $product->name }}" 
                                                             class="product-thumbnail">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                                             style="width: 50px; height: 50px; border-radius: 4px;">
                                                            <i class="fe fe-image" style="font-size: 1.25rem; color: #6c757d;"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="align-middle">{{ $product->name }}</td>
                                                <!-- <td class="align-middle">₹&nbsp;{{ number_format($product->price, 2) }}</td> -->
                                                <td class="align-middle">
                                                    <span class="badge rounded-pill border border-{{ $product->is_active ? 'success' : 'danger' }} text-{{ $product->is_active ? 'success' : 'danger' }} py-1 px-3">
                                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td class="align-middle action-btns">
                                                    <div class="d-flex">
                                                        <a href="{{ route('admin.cheese-products.show', $product->id) }}" 
                                                           class="btn btn-sm btn-info me-1" 
                                                           data-bs-toggle="tooltip" 
                                                           title="View">
                                                            <i class="fe fe-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.cheese-products.edit', $product->id) }}" 
                                                           class="btn btn-sm btn-primary me-1"
                                                           data-bs-toggle="tooltip" 
                                                           title="Edit">
                                                            <i class="fe fe-edit"></i>
                                                        </a>
                                                        @if(auth()->user()->role === 'admin')
                                                            <form action="{{ route('admin.cheese-products.destroy', $product->id) }}" 
                                                                method="POST" 
                                                                class="d-inline"
                                                                onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                        class="btn btn-sm btn-danger"
                                                                        data-bs-toggle="tooltip" 
                                                                        title="Delete">
                                                                    <i class="fe fe-trash-2"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No cheese products found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table -->
                            
                            {{-- @if($products->hasPages())
                            <div class="mt-3">
                                {{ $products->links() }}
                            </div>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::row -->
        </div>
    </div>
    <!-- End::Cheese Products Section -->
@endsection

@push('scripts')
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
