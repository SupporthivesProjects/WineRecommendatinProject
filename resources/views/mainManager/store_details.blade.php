@extends('layouts.bootdashboard')

@section('admindashboardcontent')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb mb-4">
            <div>
                <h2 class="main-content-title fs-24 mb-1">Store Details</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.stores.index') }}">Stores</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $store->store_name }}</li>
                </ol>
            </div>
            <div>
                <a href="{{ route('main-manager.allStores') }}" class="btn btn-secondary btn-icon-text">
                    <i class="fe fe-arrow-left me-2"></i> Back to List
                </a>
            </div>
        </div>

        <!-- Card -->
        <div class="card shadow-sm border-0 p-3">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <h3 class="mb-0 text-primary">{{ $store->store_name }}</h3>
            </div>

            <div class="card-body">

                <!-- Tabs -->
                <ul class="nav nav-tabs mb-4" id="storeTabs" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#products">Products</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#featured">Featured Products</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#sales">Sales</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#managers">Store Managers</a></li>
                </ul>

                <div class="tab-content" id="storeTabContent">
                    <!-- Products Tab -->
                    <div class="tab-pane fade show active" id="products">
                        <h5 class="text-dark mb-3">Products</h5>
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
                                                    <a href="#" class="text-primary">View</a>
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

                    <!-- Featured Products Tab -->
                    <div class="tab-pane fade" id="featured">
                        <h5 class="text-dark mb-3">Featured Products</h5>
                        <div class="table-responsive">
                            <table id="featured-products-table" class="table table-bordered" style="width:100%">
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
                                    @forelse ($featuredProducts as $index => $product)
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
                                                <a href="#" class="text-primary">View</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No featured products found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Sales Tab -->
                    <div class="tab-pane fade" id="sales">
                        <h5 class="text-dark mb-3">Sales Data</h5>
                        @if(!empty($salesData))
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Product</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($salesData as $sale)
                                            <tr>
                                                <td>{{ $sale['date'] }}</td>
                                                <td>{{ $sale['product_name'] }}</td>
                                                <td>{{ $sale['price'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No sales data available.</p>
                        @endif
                    </div>

                    <!-- Store Managers Tab -->
                    <div class="tab-pane fade" id="managers">
                        <h5 class="text-dark mb-3">Store Managers</h5>
                        @if($storeManagers->isNotEmpty())
                            <ul class="list-group">
                                @foreach($storeManagers as $manager)
                                    <li class="list-group-item">
                                        <strong>{{ $manager->first_name }}</strong> <br>
                                        <strong>{{ $manager->mobile }}</strong> <br>
                                        <small>{{ $manager->email }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No store managers assigned.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
