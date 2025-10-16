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
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#products">Products</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#featured">Featured Products</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#sales">Sales</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#managers">Store Managers</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#store-profiles">Store
                                Profiles</a></li>

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
                                                <td class="align-middle">${{ number_format($product->retail_price, 2) }}
                                                </td>
                                                <td class="align-middle">
                                                    <span
                                                        class="badge rounded-pill border border-{{ $product->status === 'active' ? 'success' : 'danger' }} text-{{ $product->status === 'active' ? 'success' : 'danger' }} py-1 px-3">
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
                                                <td class="align-middle">${{ number_format($product->retail_price, 2) }}
                                                </td>
                                                <td class="align-middle">
                                                    <span
                                                        class="badge rounded-pill border border-{{ $product->status === 'active' ? 'success' : 'danger' }} text-{{ $product->status === 'active' ? 'success' : 'danger' }} py-1 px-3">
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
                            @if (!empty($salesData))
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
                                            @foreach ($salesData as $sale)
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
                            @if ($storeManagers->isNotEmpty())
                                <ul class="list-group">
                                    @foreach ($storeManagers as $manager)
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

                        <!-- Store Profiles Tab -->
                        <div class="tab-pane fade" id="store-profiles">
                            <h5 class="text-dark mb-3">Store Profiles</h5>

                            @if (isset($error))
                                <div class="alert alert-warning text-center mt-4 shadow-sm" role="alert">
                                    <i class="fe fe-alert-circle me-2"></i> {{ $error }}
                                </div>
                            @elseif(isset($store))
                                <div class="card shadow-sm border-0 p-3">
                                    <div class="card-body">

                                        <!-- Header -->
                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                            <div class="px-3 py-2 rounded shadow-sm d-flex align-items-center"
                                                style="background: linear-gradient(90deg, #007bff 0%, #4a90e2 100%); color: #fff; border-left: 5px solid #0056b3;">
                                                <i class="fe fe-home me-2 fs-20"></i>
                                                <h4 class="mb-0 fw-semibold">Wine Store Profile</h4>
                                            </div>
                                        </div>

                                        <div class="row align-items-start">

                                            <!-- Left Section: Store Details -->
                                            <div class="col-md-8">
                                                <div class="d-flex align-items-center mb-4">
                                                    <!-- Store Logo / Initial Circle -->
                                                    <div class="me-3 position-relative"
                                                        style="width:100px; height:100px;">
                                                        @if ($store->profile_picture)
                                                            <img src="{{ asset($store->profile_picture) }}"
                                                                class="rounded-circle border border-3 border-white shadow w-100 h-100 object-fit-cover"
                                                                alt="Store Logo">
                                                        @else
                                                            <div class="d-flex justify-content-center align-items-center rounded-circle border border-3 border-white shadow"
                                                                style="width:100px; height:100px; background-color:#8b0000; color:#fff; font-size:36px; font-weight:bold;">
                                                                {{ strtoupper(substr($store->store_name, 0, 1)) }}
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div>
                                                        <!-- Store Name on top -->
                                                        <h3 class="mb-1">{{ $store->store_name }}</h3>
                                                        <span
                                                            class="badge bg-success text-white">{{ $store->status }}</span>
                                                        <p class="text-muted mb-0">{{ $store->email }}</p>
                                                    </div>
                                                </div>

                                                <!-- Store Info Card -->
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body">
                                                        <h5 class="mb-3">Store Details</h5>

                                                        <div class="mb-3">
                                                            <label class="form-label"><strong>Store Name</strong></label>
                                                            <p class="form-control">{{ $store->store_name }}</p>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label"><strong>Business
                                                                    Type</strong></label>
                                                            <p class="form-control">{{ $store->business_type }}</p>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label"><strong>Address</strong></label>
                                                            <p class="form-control">{{ $store->address }}</p>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label"><strong>Contact
                                                                    Number</strong></label>
                                                            <p class="form-control">{{ $store->contact_number }}</p>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label"><strong>State</strong></label>
                                                            <p class="form-control">{{ $store->state }}</p>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label"><strong>License Type</strong></label>
                                                            <p class="form-control">{{ $store->licence_type }}</p>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label"><strong>License
                                                                    Number</strong></label>
                                                            <p class="form-control">{{ $store->license_number }}</p>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label"><strong>GST/VAT</strong></label>
                                                            <p class="form-control">{{ $store->gst_vat }}</p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Right Section: Account Info -->
                                            <div class="col-md-4 mt-4 mt-md-0">
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body">
                                                        <h5 class="mb-3">Account Information</h5>
                                                        <p class="mb-2"><strong>Manager ID:</strong>
                                                            {{ $store->manager_id }}</p>
                                                        <p class="mb-2"><strong>Created At:</strong>
                                                            {{ $store->created_at->format('F d, Y') }}</p>
                                                        <p class="mb-2"><strong>Last Updated:</strong>
                                                            {{ $store->updated_at->format('F d, Y h:i A') }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info text-center mt-4 shadow-sm">
                                    <i class="fe fe-info me-2"></i> No store data available.
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
