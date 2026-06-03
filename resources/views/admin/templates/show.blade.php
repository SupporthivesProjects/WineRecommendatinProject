@extends('layouts.bootdashboard')
@section('admindashboardcontent')

@push('styles')

<style>

    .store-nav-box {
        background: #ffffff;
        border-radius: 10px;
        padding: 18px;
        margin-bottom: 20px;
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
    }

    .store-nav-tabs {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }

    .store-nav-tabs .nav-link {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 10px 18px;
        color: #374151;
        font-weight: 600;
        background: #fff;
        transition: all .2s ease;
    }

    .store-nav-tabs .nav-link:hover {
        border-color: #6C5CE7;
        color: #6C5CE7;
    }

    .store-nav-tabs .nav-link.active {
        background: #6C5CE7;
        border-color: #6C5CE7;
        color: #fff;
    }

    .store-tab-badge {
        margin-left: 8px;
        border: 2px solid #ec4899;
        color: #000;
        border-radius: 10px;
        padding: 2px 8px;
        font-size: 11px;
        font-weight: 700;
    }

    .store-nav-tabs .nav-link.active .store-tab-badge {
        /* background: rgba(255,255,255,.25); */
        background: white;
    }

</style>


@endpush
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
            <div>
                <h2 class="main-content-title fs-24 mb-1">{{ __('Template Details') }}</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Stores</li>
                </ol>
            </div>
            <div class="d-flex">
                <a href="{{ route('admin.templates.edit', $template) }}" class="btn btn-wave btn-primary my-2 btn-icon-text">
                    <i class="fe fe-edit me-2"></i>Edit Template
                </a>
                <a href="{{ route('admin.templates.index') }}" class="btn btn-wave btn-secondary my-2 btn-icon-text ms-2">
                    <i class="fe fe-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>

        <!-- Tabs Navigation -->
         <div class="container">
            <div class="store-nav-box">
                <div class="nav store-nav-tabs" id="storeTab" role="tablist">
                    <button
                        class="nav-link active"
                        id="details-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#details"
                        type="button"
                        role="tab">
                        Overview
                    </button>

                    <button
                        class="nav-link"
                        id="wine-products"
                        data-bs-toggle="tab"
                        data-bs-target="#wine"
                        type="button"
                        role="tab">
                        Wine Products
                        <span class="store-tab-badge">
                            {{ $template->products->count() }}
                        </span>
                    </button>

                    <button
                        class="nav-link"
                        id="cheese-products"
                        data-bs-toggle="tab"
                        data-bs-target="#cheese"
                        type="button"
                        role="tab">
                        Cheese products
                        <span class="store-tab-badge">
                            {{ $template->cheeseProducts->count() }}
                        </span>
                    </button>

                </div>
            </div>
        </div>

        <!-- Tabs Content -->
        <div class="tab-content" id="storeTabContent">
            <!-- Template Overview -->
            <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                <div class="bg-white overflow-hidden shadow-sm rounded p-4 mb-4">
                    <h3 class="h5 text-dark mb-4">{{ $template->template_name }}</h3>
                    <dl>
                        @php
                            $rows = [
                                'Store Name' => $template->name,
                                'Description' => $template->description ?? 'N/A',
                                'Status' => $template->status,
                                'Created At' => $template->created_at->format('F j, Y, g:i a'),
                                'Last Updated' => $template->updated_at->format('F j, Y, g:i a')
                            ];
                        @endphp

                        @foreach($rows as $label => $value)
                            <div class="row border-bottom py-2">
                                <dt class="col-sm-3 text-muted">{{ $label }}</dt>
                                <dd class="col-sm-9 fw-bold">
                                    @if ($label === 'Status')
                                        @if ($value == 1)
                                            <span class="badge {{ $value === 1 ? 'bg-success' : 'bg-danger' }}">
                                                Active
                                            </span>
                                        @else
                                            <span class="badge {{ $value === 1 ? 'bg-success' : 'bg-danger' }}">
                                                Inactive
                                            </span>
                                        @endif
                                        
                                    @else
                                        {{ $value }}
                                    @endif
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            </div>

            <!-- Template Wine Products -->
            <div class="tab-pane fade" id="wine" role="tabpanel" aria-labelledby="wine-tab">
                <div class="bg-white overflow-hidden shadow-sm rounded p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="h5 text-dark">Wine Products</h3>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                            Add Product
                        </button>
                    </div>
                    <div class="table-responsive">
                            <table class="table table table-bordered table-striped" id="template-products-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Wine Name</th>
                                        <th>Type</th>
                                        <th>Vintage</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($templateProducts as $product)
                                        <tr>
                                            <td>{{ $product->wine_name }}</td>
                                            <td>{{ ucfirst($product->type) }}</td>
                                            <td>{{ $product->vintage_year }}</td>
                                            <td>{{ $product->retail_price }}</td>
                                            <td>
                                                <form method="POST" action="{{ route(
                                                        'admin.templates.product.remove',
                                                        [$template->id, $product->id]
                                                ) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        Remove
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No products found.</td>
                                        </tr>
                                    @endforelse
                                    
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>

            <!-- Template Cheese Products -->
            <div class="tab-pane fade" id="cheese" role="tabpanel" aria-labelledby="cheese-tab">
                <div class="bg-white overflow-hidden shadow-sm rounded p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="h5 text-dark mb-0">Cheese Products</h3>
                    <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCheeseModal">
                        <i class="fe fe-plus me-1"></i>
                        Add Cheese
                    </button>
                </div>
                </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">

                            <thead>
                                <tr>
                                    <th>Cheese Name</th>
                                    <th width="100">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($templateCheeseProducts as $cheese)
                                    <tr>
                                        <td>
                                            {{ $cheese->name }}
                                        </td>
                                        <td>
                                            <form method="POST"
                                                action="{{ route(
                                                    'admin.templates.cheese.remove',
                                                    [
                                                        'template' => $template->id,
                                                        'cheese' => $cheese->id
                                                    ]
                                                ) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                        Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            No cheese products assigned.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


             <!-- Add Product Modal -->
            <div class="modal fade" id="addProductModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('admin.templates.product.add',$template->id) }}">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Add Products</h5>
                                <buttontype="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <input type="text" id="productSearch" class="form-control mb-3"placeholder="Search wine...">
                            <div class="modal-body">
                                <div style="max-height: 400px; overflow-y: auto;">
                                    @foreach($availableProducts as $product)
                                        <div class="form-check mb-2 product-item">
                                            <input class="form-check-input" type="checkbox" name="product_ids[]" value="{{ $product->id }}"
                                            id="product{{ $product->id }}">

                                            <label class="form-check-label" for="product{{ $product->id }}">
                                                {{ $product->wine_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    Add Products
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Add Cheese Modal -->
            <div class="modal fade" id="addCheeseModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST"
                            action="{{ route(
                                'admin.templates.cheese.add',
                                $template->id
                            ) }}">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    Add Cheese Products
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                </button>
                            </div>
                            <input type="text" id="cheeseSearch" class="form-control mb-3" placeholder="Search cheese...">
                            <div class="modal-body">
                                <div style="max-height: 400px; overflow-y: auto;">
                                    @foreach($availableCheeses as $cheese)
                                        <div class="form-check mb-2 cheese-item">
                                            <input class="form-check-input" type="checkbox" name="cheese_ids[]" value="{{ $cheese->id }}"
                                                id="cheese{{ $cheese->id }}">
                                            <label class="form-check-label"for="cheese{{ $cheese->id }}">
                                                {{ $cheese->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Add Cheese
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if ($errors->has('duplicate'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Duplicate User',
            text: '{{ $errors->first('duplicate') }}'
        });
    </script>
@endif

@if ($errors->any() && !$errors->has('duplicate'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: `{!! implode('<br>', $errors->all()) !!}`,
        });
    </script>
@endif

@endsection

@push('scripts')

    <script>
        $(document).ready(function () {
            $('#template-products-table').DataTable({
                pageLength: 25
            });
        });
    </script>
     <script>
        $('#productSearch').on('keyup', function () {
            let value = $(this).val().toLowerCase();

            $('.product-item').filter(function () {
                $(this).toggle(
                    $(this).text().toLowerCase().indexOf(value) > -1
                );
            });
        });
    </script>
     <script>
        $('#cheeseSearch').on('keyup', function () {
            let value = $(this).val().toLowerCase();

            $('.product-item').filter(function () {
                $(this).toggle(
                    $(this).text().toLowerCase().indexOf(value) > -1
                );
            });
        });
    </script>

@endpush


