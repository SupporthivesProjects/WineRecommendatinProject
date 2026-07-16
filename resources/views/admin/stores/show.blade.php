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


    .analytics-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        display: block;
        gap: 18px;
        transition: all .25s ease;
        box-shadow: 0 4px 20px rgba(0,0,0,.05);
        height: 100%;
    }

    .analytics-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(0,0,0,.12);
    }

    .analytics-icon {
        width: 60px;
        height: 60px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #fff;
    }

    .revenue-card .analytics-icon {
        background: linear-gradient(135deg,#10b981,#059669);
    }

    .orders-card .analytics-icon {
        background: linear-gradient(135deg,#3b82f6,#2563eb);
    }

    .bottles-card .analytics-icon {
        background: linear-gradient(135deg,#8b5cf6,#7c3aed);
    }

    .avg-card .analytics-icon {
        background: linear-gradient(135deg,#f59e0b,#d97706);
    }

    .analytics-label {
        display: block;
        color: #6b7280;
        font-size: 14px; 
        margin-bottom: 6px;
    }

   
    .analytics-value {
        margin: 0;
        font-size: clamp(18px, 2vw, 32px);
        font-weight: 700;
    }

  

</style>


@endpush
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
            <div>
                <h2 class="main-content-title fs-24 mb-1">{{ __('Store Details') }}</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Stores</li>
                </ol>
            </div>
            <div class="d-flex">
                <a href="{{ route('admin.stores.edit', $store) }}" class="btn btn-wave btn-primary my-2 btn-icon-text">
                    <i class="fe fe-edit me-2"></i>Edit Store
                </a>
                <a href="{{ route('admin.stores.index') }}" class="btn btn-wave btn-secondary my-2 btn-icon-text ms-2">
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
                        id="users-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#users"
                        type="button"
                        role="tab">
                        Users
                        <span class="store-tab-badge">
                            {{ $store->users->count() }}
                        </span>
                    </button>

                    <button
                        class="nav-link"
                        id="products-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#products"
                        type="button"
                        role="tab">
                        Products
                        <span class="store-tab-badge">
                            {{ $store->products->count() }}
                        </span>
                    </button>

                    <button
                        class="nav-link"
                        id="orders-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#cheese"
                        type="button"
                        role="tab">
                        Cheese
                        <span class="store-tab-badge">
                            {{ $cheeseProducts->count() ?? 0 }}
                        </span>
                    </button>
    
                    <button
                        class="nav-link"
                        id="features-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#features"
                        type="button"
                        role="tab">
                        Features
                        <span class="store-tab-badge">
                            {{ $features->count() }}
                        </span>
                    </button>
     
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#analytics" type="button" role="tab">
                        Analytics
                    </button>

                    <button
                        id="apiData-tab"
                        class="nav-link"
                        data-bs-toggle="tab"
                        data-bs-target="#APIData"
                        type="button"
                        role="tab">
                        API Data
                    </button>

                    <button
                        id="invoicesData-tab"
                        class="nav-link"
                        data-bs-toggle="tab"
                        data-bs-target="#InvoicesData"
                        type="button"
                        role="tab">
                        Invoice Data
                    </button>

                    <button
                        id="apikey-tab"
                        class="nav-link"
                        data-bs-toggle="tab"
                        data-bs-target="#APIKey"
                        type="button"
                        role="tab">
                        API Key
                    </button>


                </div>
            </div>
        </div>

        <!-- Tabs Content -->
        <div class="tab-content" id="storeTabContent">
            <!-- Store Details Tab -->
            <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                <div class="bg-white overflow-hidden shadow-sm rounded p-4 mb-4">
                    <h3 class="h5 text-dark mb-4">{{ $store->store_name }}</h3>
                    <dl>
                        @php
                            if ($store->template_id == 1)
                            {
                                $template = "ALL";
                            }
                            else if($store->template_id == 2)
                            {
                                $template = "Nature's Basket";
                            }
                            else
                            {
                                $template = "No template selected for this store";
                            }

                            $rows = [
                                'Template' => $template,
                                'Store Name' => $store->store_name,
                                'Business Type' => $store->business_type ?? 'N/A',
                                'Address1' => $store->address1 ?? 'N/A',
                                'Address2' => $store->address2 ?? 'N/A',
                                'Contact Number' => $store->contact_number ?? 'N/A',
                                'Email' => $store->email ?? 'N/A',
                                'Location' => $store->location ?? 'N/A',
                                'City' => $store->city ?? 'N/A',
                                'State' => $store->state ?? 'N/A',
                                'License Type' => $store->licence_type ?? 'N/A',
                                'License Number' => $store->license_number ?? 'N/A',
                                'Group' => $store->group ?? 'N/A',
                                'GST/VAT' => $store->gst_vat ?? 'N/A',
                                'Status' => $store->status,
                                'Created At' => $store->created_at->format('F j, Y, g:i a'),
                                'Last Updated' => $store->updated_at->format('F j, Y, g:i a')
                            ];
                        @endphp

                        @foreach($rows as $label => $value)
                            <div class="row border-bottom py-2">
                                <dt class="col-sm-3 text-muted">{{ $label }}</dt>
                                <dd class="col-sm-9 fw-bold">
                                    @if ($label === 'Status')
                                        <span class="badge {{ $value === 'active' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($value) }}
                                        </span>
                                    @else
                                        {{ $value }}
                                    @endif
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            </div>

            <!-- Store Users Tab -->
            <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
                <div class="bg-white overflow-hidden shadow-sm rounded p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="h5 text-dark">Store Users</h3>
                        <button onclick="openAssignUserModal()" class="btn btn-danger">
                            <i class="bi bi-person-plus"></i> Add User
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($store->users as $user)
                                    <tr>
                                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ucfirst($user->role) }}</td>
                                        <td>
                                            <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group flex gap-2">
                                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-info btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No users found for this store.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Main manager details -->
                <div class="bg-white overflow-hidden shadow-sm rounded p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="h5 text-dark">Store Parent</h3>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if ($store->manager)
                                <tr>
                                    <td>{{ $store->manager->first_name }} {{ $store->manager->last_name }}</td>
                                    <td>{{ $store->manager->email }}</td>
                                    <td>{{ ucfirst($store->manager->role) }}</td>
                                    <td>
                                        <span class="badge {{ $store->manager->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($store->manager->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group flex gap-2">
                                            <a href="{{ route('admin.users.edit', $store->manager) }}" class="btn btn-info btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                        </div>
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No manager assigned to this store.
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Store Products Tab -->
            <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
                <div class="bg-white overflow-hidden shadow-sm rounded p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="h5 text-dark mb-0">Store Products</h3>

                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#addProductModal">
                        Add Product
                    </button>
                </div>
                    <div class="table-responsive">
                        <table class="table table table-bordered table-striped" id="store-products-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Wine Name</th>
                                    <th>Type</th>
                                    <th>Vintage</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($storeProducts as $product)
                                    <tr>
                                        <td>{{ $product->wine_name }}</td>
                                        <td>{{ ucfirst($product->type) }}</td>
                                        <td>{{ $product->vintage_year }}</td>
                                        <td>{{ $product->retail_price }}</td>
                                        <td>
                                            @if($product->pivot->status == 'active')

                                                <form method="POST"
                                                    action="{{ route('admin.stores.product.toggle', [$store->id, $product->id]) }}">
                                                    @csrf

                                                    <input type="hidden"
                                                        name="status"
                                                        value="inactive">

                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-success">
                                                        Active
                                                    </button>
                                                </form>

                                            @else

                                                <form method="POST"
                                                    action="{{ route('admin.stores.product.toggle', [$store->id, $product->id]) }}">
                                                    @csrf

                                                    <input type="hidden"
                                                        name="status"
                                                        value="active">

                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-danger">
                                                        Inactive
                                                    </button>
                                                </form>

                                            @endif
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

            <!-- Cheese Tab -->
            <div class="tab-pane fade" id="cheese" role="tabpanel" aria-labelledby="orders-tab">
                <div class="bg-white overflow-hidden shadow-sm rounded p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="h5 text-dark mb-0">Store Cheese</h3>

                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#addCheeseModal">
                        Add Cheese
                    </button>
                </div>
                    <p class="text-muted">
                        <table class="table table table-bordered table-striped" id="store-cheese-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Cheese Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cheeseProducts as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ ucfirst($product->description) }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>
                                            @if($product->pivot->is_available)
                                                <form method="POST"
                                                    action="{{ route('admin.stores.cheese.toggle', [$store->id, $product->id]) }}">
                                                    @csrf

                                                    <input type="hidden" name="status" value="0">

                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        Active
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST"
                                                    action="{{ route('admin.stores.cheese.toggle', [$store->id, $product->id]) }}">
                                                    @csrf

                                                    <input type="hidden" name="status" value="1">

                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        Inactive
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No products found.</td>
                                    </tr>
                                @endforelse
                                
                            </tbody>
                        </table>
                    </p>
                </div>
            </div>

            <!-- Features Tab -->
            <div class="tab-pane fade" id="features" role="tabpanel" aria-labelledby="features-tab">
                <div class="bg-white overflow-hidden shadow-sm rounded p-4 mb-4">
                    <h3 class="h5 text-dark mb-3">Store Features</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Feature</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($features as $feature)
                                    <tr>
                                        <td>{{ $feature->name }}</td>
                                        <td>
                                            @if($feature->pivot->enabled)
                                                <button
                                                    class="btn btn-sm btn-success feature-toggle-btn"
                                                    data-store="{{ $store->id }}"
                                                    data-feature="{{ $feature->id }}"
                                                    data-status="0"
                                                    data-url="{{ route('admin.stores.feature.toggle', [$store->id, $feature->id]) }}"
                                                    >
                                                    Active
                                                </button>
                                            @else
                                                <button
                                                    class="btn btn-sm btn-danger feature-toggle-btn"
                                                    data-store="{{ $store->id }}"
                                                    data-feature="{{ $feature->id }}"
                                                    data-status="1"
                                                    data-url="{{ route('admin.stores.feature.toggle', [$store->id, $feature->id]) }}"
                                                    >
                                                    Inactive
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <!-- Analytics tab -->
            <div class="tab-pane fade" id="analytics" role="tabpanel" aria-labelledby="analytics-tab">
                <div class="row">
                    @php
                        $currentRange = request('range', 'all');
                    @endphp
                    <div class="analytics-filters mb-4 d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ request()->url() }}?range=all"
                                class="btn btn-sm {{ $currentRange == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                                All Time
                            </a>

                            <a href="{{ request()->url() }}?range=today"
                                class="btn btn-sm {{ $currentRange == 'today' ? 'btn-primary' : 'btn-outline-primary' }}">
                                Today
                            </a>

                            <a href="{{ request()->url() }}?range=7days"
                                class="btn btn-sm {{ $currentRange == '7days' ? 'btn-primary' : 'btn-outline-primary' }}">
                                7 Days
                            </a>

                            <a href="{{ request()->url() }}?range=30days"
                                class="btn btn-sm {{ $currentRange == '30days' ? 'btn-primary' : 'btn-outline-primary' }}">
                                30 Days
                            </a>

                            <a href="{{ request()->url() }}?range=month"
                                class="btn btn-sm {{ $currentRange == 'month' ? 'btn-primary' : 'btn-outline-primary' }}">
                                Month
                            </a>

                            <a href="{{ request()->url() }}?range=year"
                                class="btn btn-sm {{ $currentRange == 'year' ? 'btn-primary' : 'btn-outline-primary' }}">
                                Year
                            </a>

                            <button
                                class="btn btn-sm {{ $currentRange == 'custom' ? 'btn-primary' : 'btn-outline-secondary' }}"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#customRangeFilter">
                                Custom Range
                            </button>
                        </div>

                        <a href="{{ route('admin.stores.analytics.export', $store->id) }}" class="btn btn-success">
                            Download Excel
                        </a>

                    </div>
                    <div class="collapse my-3" id="customRangeFilter">
                        <form method="GET" action="{{ request()->url() }}">
                            <input type="hidden" name="range" value="custom">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">
                                        From Date
                                    </label>
                                    <input
                                        type="date"
                                        name="from"
                                        class="form-control"
                                        value="{{ request('from') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">
                                        To Date
                                    </label>
                                    <input
                                        type="date"
                                        name="to"
                                        class="form-control"
                                        value="{{ request('to') }}">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button
                                        type="submit"
                                        class="btn btn-primary">
                                        Apply Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-3">
                        <div class="analytics-card revenue-card">
                            <div class="analytics-icon">
                                <i class="bi bi-currency-rupee"></i>
                            </div>

                            <div class="analytics-content">
                                <span class="analytics-label">
                                    Total Revenue
                                </span>

                                <h2 class="analytics-value">
                                    ₹{{ number_format($analyticsSummary['total_revenue'] ?? 0, 2) }}
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="analytics-card orders-card">
                            <div class="analytics-icon">
                                <i class="bi bi-cart-check"></i>
                            </div>

                            <div class="analytics-content">
                                <span class="analytics-label">
                                    Total Orders
                                </span>

                                <h2 class="analytics-value">
                                    {{ $analyticsSummary['total_orders'] ?? 0 }}
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="analytics-card bottles-card">
                            <div class="analytics-icon">
                                <i class="bi bi-cup-straw"></i>
                            </div>

                            <div class="analytics-content">
                                <span class="analytics-label">
                                    Total Bottles
                                </span>

                                <h2 class="analytics-value">
                                    {{ $analyticsSummary['total_bottles'] ?? 0 }}
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="analytics-card avg-card">
                            <div class="analytics-icon">
                                <i class="bi bi-receipt"></i>
                            </div>

                            <div class="analytics-content">
                                <span class="analytics-label">
                                    Avg Order Value
                                </span>

                                <h2 class="analytics-value">
                                    ₹{{ number_format($analyticsSummary['avg_order_value'] ?? 0, 2) }}
                                </h2>
                            </div>
                        </div>
                    </div>

                    <!-- top selling wines -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">
                                    🍷 Top Selling Wines
                                </h4>

                                <span class="badge bg-primary">
                                    {{ $topSellingWines->count() }} Wines
                                </span>
                                </div>
                                    @foreach($topSellingWines as $index => $wine)
                                        <div class="mb-4">
                                            <div class="d-flex justify-content-between mb-1">
                                                <div>
                                                @php
                                                    $badge = match($index) {
                                                        0 => '🥇',
                                                        1 => '🥈',
                                                        2 => '🥉',
                                                        default => '#'.($index + 1)
                                                    };
                                                @endphp

                                                <span class="wine-rank">
                                                    {{ $badge }}
                                                </span>
                                                    {{ $wine->product_name }}
                                                </div>
                                                <div>
                                                    {{ $wine->total_sold }} bottles
                                                </div>
                                            </div>
                                            @php
                                                $barColor = match($index) {
                                                    0 => '#f59e0b',
                                                    1 => '#9ca3af',
                                                    2 => '#b45309',
                                                    default => '#6366f1'
                                                };
                                            @endphp
                                            <div class="progress" style="height:10px;">
                                            <div class="progress-bar"
                                                    style="
                                                        background: {{ $barColor }};
                                                        width: {{ ($wine->total_sold / $topSellingWines->max('total_sold')) * 100 }}%;
                                                    ">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                        </div>
                    </div>

                    <!-- Revenue Chart  -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">
                                    📈 Revenue Trend
                                </h4>
                            </div>
                            <div style="height:350px;">
                                <canvas id="revenueTrendChart"></canvas>
                            </div>
                        </div>
                    </div>


                    <!-- Wine and country distribution -->
                    @php
                    $wineTypeLabels = $wineTypeDistribution
                        ->pluck('type');

                    $wineTypeValues = $wineTypeDistribution
                        ->pluck('total_sold');

                    @endphp
                    <div class="row mt-4">
                        {{-- Wine Type --}}
                        <div class="col-md-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0">
                                        🍷 Wine Type Distribution
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <canvas
                                        id="wineTypeChart"
                                        height="250">
                                    </canvas>
                                </div>
                            </div>
                        </div>

                        {{-- Country --}}
                        <div class="col-md-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0">
                                        🌍 Country Distribution
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <canvas
                                        id="countryChart"
                                        height="250">
                                    </canvas>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Intelligence Report -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="analytics-card">
                                <h4 class="mb-0">
                                    Inventory Intelligence
                                </h4>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-3">
                        {{-- Slow Moving Wines --}}
                        <div class="col-md-6">
                            <div class="analytics-card p-4">
                                <h4 class="mb-4 fw-bold text-primary">
                                    🍷 Slow Moving Wines
                                </h4>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>Wine</th>
                                                <th class="text-end">Sold</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($slowMovingWines as $wine)
                                                <tr>
                                                    <td>{{ $wine->product_name }}</td>
                                                    <td class="text-end">
                                                        {{ $wine->total_sold }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="text-center text-muted">
                                                        No data found
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Low Stock Alert --}}
                        <div class="col-md-6">
                            <div class="analytics-card p-4">
                                <h4 class="mb-4 fw-bold text-danger">
                                    ⚠️ Low Stock Alert
                                </h4>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>Wine</th>
                                                <th class="text-end">Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($lowStockWines as $wine)
                                                <tr>
                                                    <td>{{ $wine->product_name }}</td>

                                                    <td class="text-end fw-bold text-danger">
                                                        {{ $wine->stock }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="text-center text-muted">
                                                        No low stock wines
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="analytics-card p-4">
                                <h4 class="mb-4 fw-bold text-warning">
                                    📦 High Stock + Low Movement
                                </h4>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>Wine</th>
                                                <th class="text-end">Stock</th>
                                                <th class="text-end">Sold</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($highStockLowMovement as $wine)
                                                <tr>
                                                    <td>
                                                        {{ $wine->product_name }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ $wine->stock }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ $wine->sold }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted">
                                                        No overstocked wines found
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="analytics-card p-4">
                                <h4 class="mb-4 fw-bold text-success">
                                    💰 Price Band Performance
                                </h4>
                                <div style="height:500px; position:relative;">
                                    <canvas id="priceBandChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Domestic and Imported -->
                    <div class="row mt-4">
                        {{-- Domestic vs Imported --}}
                        <div class="col-md-6">
                            <div class="analytics-card p-4">
                                <h4 class="mb-4 fw-bold text-info">
                                    🌍 Domestic vs Imported
                                </h4>
                                <div style="height:350px; position:relative;">
                                    <canvas id="domesticImportedChart"></canvas>
                                </div>
                            </div>
                        </div>

                        {{-- Average Bottle Value Trend --}}
                        <div class="col-md-6">
                            <div class="analytics-card p-4">
                                <h4 class="mb-4 fw-bold text-success">
                                    📈 Average Bottle Value Trend
                                </h4>
                                <div style="height:350px; position:relative;">
                                    <canvas id="avgBottleValueChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        {{-- Reorder Attention --}}
                        <div class="col-md-6">
                            <div class="analytics-card p-4">
                                <h4 class="mb-4 fw-bold text-danger">
                                    🚨 Suggested Reorder Attention
                                </h4>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>Wine</th>
                                                <th class="text-end">
                                                    Stock
                                                </th>
                                                <th class="text-end">
                                                    Sold
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($reorderAttentionList as $wine)
                                                <tr>
                                                    <td>
                                                        {{ $wine->product_name }}
                                                    </td>
                                                    <td class="text-end text-danger fw-bold">
                                                        {{ $wine->stock }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ $wine->sold }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3"
                                                        class="text-center text-muted">
                                                        No wines require reordering
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- Promotion List --}}
                        <div class="col-md-6">
                            <div class="analytics-card p-4">
                                <h4 class="mb-4 fw-bold text-warning">
                                    🎯 Suggested Display / Promotion
                                </h4>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>Wine</th>
                                                <th class="text-end">
                                                    Stock
                                                </th>
                                                <th class="text-end">
                                                    Sold
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($promotionList as $wine)
                                                <tr>
                                                    <td>
                                                        {{ $wine->product_name }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ $wine->stock }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ $wine->sold }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3"
                                                        class="text-center text-muted">
                                                        No promotion opportunities found
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>


                    <!-- customers -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="analytics-card p-4">
                                <h2 class="fw-bold text-primary mb-0">
                                    👥 Customer Preference Analytics
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="analytics-card p-4 text-center">
                                <h6 class="text-muted">
                                    Questionnaires Completed
                                </h6>
                                <h2 class="fw-bold text-primary">
                                    {{ number_format($questionnaireStats['completed']) }}
                                </h2>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="analytics-card p-4 text-center">
                                <h6 class="text-muted">
                                    Most Popular Template
                                </h6>
                                <h2 class="fw-bold text-success">
                                    {{ $questionnaireStats['popular_template'] }}
                                </h2>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="analytics-card p-4 text-center">
                                <h6 class="text-muted">
                                    Average Preferred Budget
                                </h6>
                                <h2 class="fw-bold text-info">
                                    ₹{{ number_format($budgetStats['average_budget']) }}
                                </h2>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="analytics-card p-4 text-center">
                                <h6 class="text-muted">
                                    Premium Customers
                                    <i class="fas fa-info-circle text-secondary ms-1"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Customers whose preferred budget is ₹25,000 or higher">
                                    </i>
                                </h6>
                                <h2 class="fw-bold text-warning">
                                    {{ $budgetStats['premium_percent'] }}%
                                </h2>
                            </div>
                        </div>
                    </div>

                
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="analytics-card p-4">
                                <h4 class="fw-bold text-primary mb-4">
                                    📋 Questionnaire Usage
                                </h4>
                                <div style="height:400px">
                                    <canvas id="questionnaireUsageChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="analytics-card p-4">
                                <h4 class="fw-bold text-danger mb-4">
                                    🍷 Wine Type Preferences
                                </h4>
                                <div style="height:400px">
                                    <canvas id="wineTypePreferencesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="analytics-card p-4">
                                <h4 class="fw-bold text-success mb-4">
                                    🌍 Country Preferences
                                </h4>
                                <div style="height:400px">
                                    <canvas id="countryChartCustomer"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="analytics-card p-4">
                                <h4 class="fw-bold text-info mb-4">
                                    💰 Budget Distribution
                                </h4>
                                <div style="height:400px">
                                    <canvas id="budgetChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="analytics-card p-4">
                                <h4 class="fw-bold text-warning mb-4">
                                    🎉 Occasion Preferences
                                </h4>
                                <div style="height:400px">
                                    <canvas id="occasionChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="analytics-card p-4">
                                <h4 class="fw-bold text-secondary mb-4">
                                    😋 Taste Preferences
                                </h4>
                                <div style="height:400px">
                                    <canvas id="tasteChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="row mt-3">
                        <div class="col-6">
                            <div class="analytics-card p-4">
                                <h4 class="fw-bold text-dark mb-4">
                                    🍇 Top Requested Varieties
                                    <i class="fas fa-info-circle text-secondary ms-1"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Most frequently requested wine grape varieties based on customer questionnaire responses">
                                    </i>
                                </h4>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Variety</th>
                                                <th class="text-end">
                                                    Requests
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($topVarieties as $variety)
                                                <tr>
                                                    <td>
                                                        {{ $variety->answer }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ $variety->total }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2"
                                                        class="text-center">
                                                        No data found
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="analytics-card p-4">
                            <h4 class="fw-bold text-dark mb-4">
                                🎁 Occasion vs Budget Preferences
                            </h4>

                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Occasion</th>
                                        <th>Preferred Budget</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($occasionBudgetPreferences as $row)
                                        <tr>
                                            <td>{{ $row->occasion }}</td>
                                            <td>{{ $row->budget_band }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>   
            </div>

            <!-- API Data tab -->
            <div class="tab-pane fade" id="APIData" role="tabpanel" aria-labelledby="apiData-tab">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">API Uploaded Data</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="apiData">
                                <thead>
                                    <tr>
                                        <th>Invoice</th>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Stock</th>
                                        <th>Price</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($apiUploads as $row)
                                        <tr>
                                            <td>{{ $row->invoice_no }}</td>
                                            <td>{{ $row->customer_name }}</td>
                                            <td>{{ $row->product_name }}</td>
                                            <td>{{ $row->qty }}</td>
                                            <td>{{ $row->stock }}</td>
                                            <td>{{ $row->product_price }}</td>
                                            <td>{{ $row->date }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                No API data found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Invoices Data tab -->
             <div class="tab-pane fade" id="InvoicesData" role="tabpanel" aria-labelledby="invoicesData-tab">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">API Uploaded Data</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="invoiceData">
                                <thead>
                                    <tr>
                                        <th>Invoice</th>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Stock</th>
                                        <th>type</th>
                                        <th>Price</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($invoiceData as $row)
                                        <tr>
                                            <td>{{ $row->invoice_no }}</td>
                                            <td>{{ $row->customer_name }}</td>
                                            <td>{{ $row->product_name }}</td>
                                            <td>{{ $row->qty }}</td>
                                            <td>{{ $row->stock }}</td>
                                            <td>{{ $row->type }}</td>
                                            <td>{{ $row->product_price }}</td>
                                            <td>{{ $row->date }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                No API data found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
       
            <!-- Generate API Key Tab -->
            <div class="tab-pane fade" id="APIKey" role="tabpanel" aria-labelledby="apikey-tab">
            <h5 class="mb-3 text-dark">
                API Key
            </h5>

            <div class="input-group">
                <input
                    type="text"
                    class="form-control"
                    readonly
                    value="{{ $store->api_key ?? 'Not Generated' }}">

                <form
                    action="{{ route('admin.stores.generateApiKey', $store) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        {{ $store->api_key ? 'Regenerate API Key' : 'Generate API Key' }}
                    </button>
                </form>
            </div>

            <small class="text-muted mt-2 d-block">
                This API key is used by all Store Managers belonging to this store.
                Regenerating it will immediately invalidate the previous key.
            </small>
            </div>



       
       
        </div>
    </div>


        <!-- Add Product Modal -->
        <div class="modal fade" id="addProductModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form method="POST"
                        action="{{ route('admin.stores.product.add', $store->id) }}">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title">Add Products</h5>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal">
                            </button>
                        </div>

                        <input
                            type="text"
                            id="productSearch"
                            class="form-control mb-3"
                            placeholder="Search wine..."
                        >
                        <div class="modal-body">
                            <div style="max-height: 400px; overflow-y: auto;">
                                @foreach($availableProducts as $product)
                                    <div class="form-check mb-2 product-item">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="product_ids[]"
                                            value="{{ $product->id }}"
                                            id="product{{ $product->id }}"
                                        >
                                        <label
                                            class="form-check-label"
                                            for="product{{ $product->id }}"
                                        >
                                            {{ $product->wine_name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="btn btn-primary">
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
                        action="{{ route('admin.stores.cheese.add', $store->id) }}">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title">Add Cheese</h5>
                            <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal">
                            </button>
                        </div>
                        <input
                            type="text"
                            id="cheeseSearch"
                            class="form-control mb-3"
                            placeholder="Search cheese..."
                        >
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">
                                    Select Cheese
                                </label>
                                <div style="max-height: 400px; overflow-y: auto;">
                                    @foreach($availableCheeses as $cheese)
                                        <div class="form-check mb-2 cheese-item">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="cheese_ids[]"
                                                value="{{ $cheese->id }}"
                                                id="cheese{{ $cheese->id }}"
                                            >

                                            <label
                                                class="form-check-label"
                                                for="cheese{{ $cheese->id }}"
                                            >
                                                {{ $cheese->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">
                                Cancel
                            </button>

                            <button
                                type="submit"
                                class="btn btn-primary">
                                Add Cheese
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>


         <!-- Add User Modal -->
         <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.users.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="mobile" class="form-label">Mobile</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="store_manager" id="store_manager_option" 
                                            @if($store->users->where('role', 'store_manager')->count() > 0) disabled @endif>
                                            Store Manager
                                        </option>
                                        <option value="user" 
                                            @if($store->users->where('role', 'store_manager')->count() > 0) selected @endif>
                                            User
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye" id="eyeIcon"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="store_id" class="form-label">Store Id</label>
                                    <input type="text" class="form-control" id="store_id" name="store_id" value="{{ $store->id }}" readonly>
                                </div>
                            </div>

                            <!-- Checkbox for adding more store managers -->
                            @if($store->users->where('role', 'store_manager')->count() > 0)
                            <div class="row">
                                <div class="mb-3 col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="addMoreStoreManager" name="add_more_store_manager">
                                        <label class="form-check-label" for="addMoreStoreManager">
                                            Do you want to add more store manager?
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save User</button>
                            </div>
                        </form>
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
                $('#store-products-table').DataTable({
                    pageLength: 25
                });
            });
        </script>
        <script>
              $(document).ready(function () {
                $('#store-cheese-table').DataTable({
                    pageLength: 25
                });
            });
           
        </script>
         <script>
              $(document).ready(function () {
                $('#apiData').DataTable({
                    pageLength: 25
                });
            });
           
        </script>
         <script>
              $(document).ready(function () {
                $('#invoiceData').DataTable({
                    pageLength: 25
                });
            });
           
        </script>

        <script>
            // Store ID for use in JavaScript
            const storeId = {{ $store->id }};
            
            // Check if store manager exists
            const hasStoreManager = {{ $store->users->where('role', 'store_manager')->count() > 0 ? 'true' : 'false' }};
            
            // Function to open the assign user modal
            function openAssignUserModal() {
                const modal = new bootstrap.Modal(document.getElementById('addUserModal'));
                modal.show();
                
                // Reset form when modal opens
                resetModalForm();
            }
            
            // Function to reset modal form
            function resetModalForm() {
                const roleSelect = document.getElementById('role');
                const storeManagerOption = document.getElementById('store_manager_option');
                const addMoreCheckbox = document.getElementById('addMoreStoreManager');
                
                if (hasStoreManager) {
                    // If store manager exists, disable store_manager option and select user
                    storeManagerOption.disabled = true;
                    roleSelect.value = 'user';
                    
                    // Show checkbox and handle its change event
                    if (addMoreCheckbox) {
                        addMoreCheckbox.checked = false;
                        addMoreCheckbox.addEventListener('change', function() {
                            if (this.checked) {
                                storeManagerOption.disabled = false;
                                roleSelect.value = 'store_manager';
                            } else {
                                storeManagerOption.disabled = true;
                                roleSelect.value = 'user';
                            }
                        });
                    }
                } else {
                    // If no store manager exists, enable store_manager option and select it by default
                    storeManagerOption.disabled = false;
                    roleSelect.value = 'store_manager';
                }
            }
            
            // Function to close the assign user modal
            function closeAssignUserModal() {
                const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
                modal.hide();
            }
            
            // Function to load available store managers
            function loadAvailableUsers() {
                fetch(`/admin/stores/${storeId}/available-managers`)
                    .then(response => response.json())
                    .then(data => {
                        const tableBody = document.getElementById('users_table_body');
                        
                        if (data.length === 0) {
                            tableBody.innerHTML = `
                                <tr>
                                    <td colspan="3" class="text-center">No available store managers found</td>
                                </tr>
                            `;
                            return;
                        }
                        
                        let html = '';
                        data.forEach(user => {
                            html += `
                                <tr>
                                    <td>${user.first_name} ${user.last_name}</td>
                                    <td>${user.email}</td>
                                    <td class="text-center">
                                        <button onclick="assignUserToStore(${user.id})" 
                                                class="btn btn-indigo btn-sm">
                                            Assign
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                        
                        tableBody.innerHTML = html;
                        
                        // Add search functionality
                        document.getElementById('user_search').addEventListener('input', filterUsers);
                    })
                    .catch(error => {
                        console.error('Error loading users:', error);
                        document.getElementById('users_table_body').innerHTML = `
                            <tr>
                                <td colspan="3" class="text-center text-danger">Error loading users</td>
                            </tr>
                        `;
                    });
            }
            
            // Function to filter users based on search input
            function filterUsers() {
                const searchTerm = document.getElementById('user_search').value.toLowerCase();
                const rows = document.querySelectorAll('#users_table_body tr');
                
                rows.forEach(row => {
                    const name = row.cells[0].textContent.toLowerCase();
                    const email = row.cells[1].textContent.toLowerCase();
                    
                    if (name.includes(searchTerm) || email.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
            
            // Function to assign a user to the store
            function assignUserToStore(userId) {
                // Send a POST request to assign the user
                fetch(`/admin/stores/${storeId}/assign-user`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ user_id: userId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close the modal
                        closeAssignUserModal();
                        
                        // Refresh the page to show the updated user list
                        window.location.reload();
                    } else {
                        alert(data.message || 'Failed to assign user to store');
                    }
                })
                .catch(error => {
                    console.error('Error assigning user:', error);
                    alert('An error occurred while assigning the user');
                });
            }
        </script>

        <script>
            document.getElementById('togglePassword').addEventListener('click', function () {
                const passwordField = document.getElementById('password');
                const eyeIcon = document.getElementById('eyeIcon');
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                eyeIcon.classList.toggle('bi-eye');
                eyeIcon.classList.toggle('bi-eye-slash');
            });
        </script>
        <script>
            $('#cheeseSearch').on('keyup', function () {
                let value = $(this).val().toLowerCase();

                $('.cheese-item').filter(function () {
                    $(this).toggle(
                        $(this).text().toLowerCase().indexOf(value) > -1
                    );
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
            document.addEventListener('DOMContentLoaded', function () {

                document.querySelectorAll('.feature-toggle-btn').forEach(button => {

                    button.addEventListener('click', function () {

                        const url = this.dataset.url;
                        const enabled = this.dataset.status;
                        const btn = this;

                        fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document
                                    .querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                enabled: enabled
                            })
                        })
                        .then(response => response.json())
                        .then(data => {

                            if (!data.success) {
                                showToast('Unable to update feature status.', 'danger');
                                return;
                            }

                            if (data.enabled) {

                                btn.classList.remove('btn-danger');
                                btn.classList.add('btn-success');

                                btn.textContent = 'Active';
                                btn.dataset.status = 0;

                                showToast(
                                    'Feature activated successfully.',
                                    'success'
                                );

                            } else {

                                btn.classList.remove('btn-success');
                                btn.classList.add('btn-danger');

                                btn.textContent = 'Inactive';
                                btn.dataset.status = 1;

                                showToast(
                                    'Feature deactivated successfully.',
                                    'warning'
                                );
                            }

                        })
                        .catch(error => {

                            console.error(error);

                            showToast(
                                'Unable to update feature status.',
                                'danger'
                            );
                        });

                    });

                });

            });


            function showToast(message, type = 'success')
            {
                const toastId = 'dynamicToast';

                let toastElement = document.getElementById(toastId);

                if (!toastElement) {

                    document.body.insertAdjacentHTML(
                        'beforeend',
                        `
                        <div class="toast-container position-fixed top-0 end-0 p-3">
                            <div id="${toastId}" class="toast align-items-center border-0" role="alert">
                                <div class="d-flex">
                                    <div class="toast-body"></div>
                                    <button type="button"
                                            class="btn-close me-2 m-auto"
                                            data-bs-dismiss="toast">
                                    </button>
                                </div>
                            </div>
                        </div>
                        `
                    );

                    toastElement = document.getElementById(toastId);
                }

                toastElement.classList.remove(
                    'text-bg-success',
                    'text-bg-danger',
                    'text-bg-warning'
                );

                toastElement.classList.add(`text-bg-${type}`);

                toastElement.querySelector('.toast-body').textContent = message;

                const toast = new bootstrap.Toast(toastElement, {
                    delay: 3000
                });

                toast.show();
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const revenueLabels = @json(
                    $revenueTrend->pluck('sale_date')->values()
                );

                const revenueValues = @json(
                    $revenueTrend->pluck('revenue')
                        ->map(fn($value) => (float)$value)
                        ->values()
                );

                const ctx = document.getElementById(
                    'revenueTrendChart'
                );

                if (ctx) {

                    new Chart(ctx, {
                        type: 'line',

                        data: {
                            labels: revenueLabels,

                            datasets: [{
                                label: 'Revenue',

                                data: revenueValues,

                                tension: 0.4,

                                fill: true,

                                borderWidth: 3,

                                pointRadius: 5
                            }]
                        },

                        options: {

                            responsive: true,

                            maintainAspectRatio: false,

                            plugins: {
                                legend: {
                                    display: false
                                }
                            },

                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }

            });
        </script>
        
        <script>
            const wineTypeCtx =
                document.getElementById(
                    'wineTypeChart'
                );

            new Chart(
                wineTypeCtx,
                {
                    type: 'doughnut',
                    data: {

                        labels:
                            @json($wineTypeLabels),

                        datasets: [{
                            data:
                                @json($wineTypeValues),

                            backgroundColor: [
                                '#dc3545',
                                '#ffc107',
                                '#fd7e14'
                            ]
                        }]
                    },

                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                }
            );

        </script>
        <script>
            const countryCtx =
                document.getElementById(
                    'countryChart'
                );

            new Chart(
                countryCtx,
                {
                    type: 'doughnut',

                    data: {

                        labels:
                            @json(
                                $countryDistribution
                                    ->pluck('country')
                            ),

                        datasets: [{

                            data:
                                @json(
                                    $countryDistribution
                                        ->pluck('total_sold')
                                ),

                            backgroundColor: [
                                '#4e73df',
                                '#1cc88a',
                                '#36b9cc',
                                '#f6c23e',
                                '#e74a3b',
                                '#6f42c1',
                                '#fd7e14',
                                '#20c997'
                            ]
                        }]
                    },

                    options: {

                        responsive: true,

                        plugins: {

                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                }
            );

        </script>

    <script>

            const priceBandLabels =
            @json(
                $priceBandAnalytics
                    ->pluck('band')
            );

            const priceBandValues =
            @json(
                $priceBandAnalytics
                    ->pluck('qty'));

            new Chart(
                document.getElementById(
                    'priceBandChart'
                ),
                {
                    type: 'bar',
                    data: {
                        labels: priceBandLabels,
                        datasets: [{
                            label:
                                'Bottles Sold',
                            data:
                                priceBandValues,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                }
            );
    </script>
    <script>
        const domesticLabels =
        @json(
            $domesticImportedSplit->pluck('label')
        );

        const domesticValues =
        @json(
            $domesticImportedSplit->pluck('qty')
        );

        new Chart(
            document.getElementById(
                'domesticImportedChart'
            ),
            {

                type: 'doughnut',

                data: {

                    labels: domesticLabels,

                    datasets: [{

                        data: domesticValues

                    }]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    plugins: {

                        legend: {

                            position: 'bottom'

                        }

                    }

                }

            }
        );



        const avgBottleLabels =
        @json(
            $averageBottleValueTrend
                ->pluck('sale_date')
        );

        const avgBottleValues =
        @json(
            $averageBottleValueTrend
                ->pluck('avg_price')
        );

        new Chart(
            document.getElementById(
                'avgBottleValueChart'
            ),
            {

                type: 'line',

                data: {

                    labels: avgBottleLabels,

                    datasets: [{

                        label: 'Average Bottle Value',

                        data: avgBottleValues,

                        tension: 0.3,

                        fill: false

                    }]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    plugins: {

                        legend: {

                            display: false

                        }

                    },

                    scales: {

                        y: {

                            beginAtZero: true

                        }

                    }

                }

            }
        );

    </script>
    <script>

    new Chart(
        document.getElementById('questionnaireUsageChart'),
        {
            type: 'bar',

            data: {

                labels:
                @json(
                    $questionnaireUsage->pluck('name')
                ),

                datasets: [{

                    label: 'Completions',

                    data:
                    @json(
                        $questionnaireUsage->pluck('total')
                    ),

                    borderWidth: 1

                }]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    }

                },

                scales: {

                    y: {
                        beginAtZero: true
                    }

                }

            }

        }
    );

    </script>
    <script>
    new Chart(
        document.getElementById('wineTypePreferencesChart'),
        {
            type: 'doughnut',
            data: {
                labels:
                @json(
                    $wineTypePreferences->pluck('answer')
                ),
                datasets: [{
                    data:
                    @json(
                        $wineTypePreferences->pluck('total')
                    )

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false

            }

        }
    );

    </script>
    <script>

        new Chart(
            document.getElementById('countryChartCustomer'),
            {
                type: 'bar',

                data: {

                    labels:
                    @json(
                        $countryPreferences->pluck('answer')
                    ),

                    datasets: [{

                        label: 'Requests',

                        data:
                        @json(
                            $countryPreferences->pluck('total')
                        )

                    }]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    plugins: {

                        legend: {
                            display: false
                        }

                    },

                    scales: {

                        y: {
                            beginAtZero: true
                        }

                    }

                }

            }
        );
    </script>
    <script>

        new Chart(
            document.getElementById('budgetChart'),
            {
                type: 'bar',

                data: {

                    labels:
                    @json(
                        $budgetDistribution->pluck('answer')
                    ),

                    datasets: [{

                        label: 'Customers',

                        data:
                        @json(
                            $budgetDistribution->pluck('total')
                        )

                    }]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    plugins: {

                        legend: {
                            display: false
                        }

                    },

                    scales: {

                        y: {
                            beginAtZero: true
                        }

                    }

                }

            }
        );

    </script>
    <script>

        new Chart(
            document.getElementById('occasionChart'),
            {
                type: 'bar',

                data: {

                    labels:
                    @json(
                        $occasionPreferences->pluck('answer')
                    ),

                    datasets: [{

                        label: 'Selections',

                        data:
                        @json(
                            $occasionPreferences->pluck('total')
                        )

                    }]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    plugins: {

                        legend: {
                            display: false
                        }

                    },

                    scales: {

                        y: {
                            beginAtZero: true
                        }

                    }

                }

            }
        );

    </script>
    <script>

        new Chart(
            document.getElementById('tasteChart'),
            {
                type: 'bar',

                data: {

                    labels:
                    @json(
                        $tastePreferences->pluck('answer')
                    ),

                    datasets: [{

                        label: 'Selections',

                        data:
                        @json(
                            $tastePreferences->pluck('total')
                        )

                    }]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    plugins: {

                        legend: {
                            display: false
                        }

                    },

                    scales: {

                        y: {
                            beginAtZero: true
                        }

                    }

                }

            }
        );

    </script>
    
    @endpush


