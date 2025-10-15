@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Enhanced Header -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="px-3 py-2 rounded shadow-sm d-flex align-items-center"
                    style="background: linear-gradient(90deg, #007bff 0%, #4a90e2 100%); color: #fff; border-left: 5px solid #0056b3;">
                    <i class="fe fe-home me-2 fs-20"></i>
                    <h4 class="mb-0 fw-semibold">Wine Store Profile</h4>
                </div>
            </div>

            <div class="card custom-card shadow-sm">
                <div class="card-body p-0">

                    <!-- Top Banner with Wine Image -->
                    <div
                        style="
                    background-image: url('https://thumbs.dreamstime.com/b/wine-header-horizontal-copy-space-93944292.jpg');
                    background-size: cover;
                    background-position: center;
                    height: 300px;
                    border-top-left-radius: 6px;
                    border-top-right-radius: 6px;">
                    </div>

                    <!-- Profile Section -->
                    <div class="p-4 bg-white" style="margin-top: -60px; border-radius: 6px;">
                        <div class="row align-items-start">

                            <!-- Left Section: Store Details -->
                            <div class="col-md-8">
                                <div class="d-flex align-items-center mb-4">
                                    <!-- Store Logo / Initial Circle -->
                                    <div class="me-3 position-relative" style="width:100px; height:100px;">
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
                                        <span class="badge bg-success text-white">{{ $store->status }}</span>
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
                                            <label class="form-label"><strong>Business Type</strong></label>
                                            <p class="form-control">{{ $store->business_type }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"><strong>Address</strong></label>
                                            <p class="form-control">{{ $store->address }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"><strong>Contact Number</strong></label>
                                            <p class="form-control">{{ $store->contact_number }}</p>

                                            {{-- If a new number is pending or approved, show its status --}}
                                            @if ($store->new_contact_number)
                                                <div class="mt-2 p-3 border rounded bg-light">
                                                    <strong>New Number:</strong> {{ $store->new_contact_number }} <br>
                                                    <strong>Status:</strong>
                                                    @if ($store->contact_status === 'pending')
                                                        <span class="badge bg-warning text-dark">Pending Approval</span>
                                                    @elseif($store->contact_status === 'approved')
                                                        <span class="badge bg-success">Approved</span>
                                                    @endif
                                                </div>
                                            @endif

                                            {{-- Form to submit new contact number --}}
                                            <form action="{{ route('store.update.contact') }}" method="POST"
                                                class="mt-3">
                                                @csrf
                                                <div class="input-group">
                                                    <input type="text" name="new_contact_number" class="form-control"
                                                        placeholder="Add New Number" required>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>

                                            {{-- Flash Messages --}}
                                            @if (session('success'))
                                                <div class="alert alert-success mt-2">{{ session('success') }}</div>
                                            @endif

                                            @if (session('error'))
                                                <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                                            @endif
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
                                            <label class="form-label"><strong>License Number</strong></label>
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
                                        <p class="mb-2"><strong>Manager ID:</strong> {{ $store->manager_id }}</p>
                                        <p class="mb-2"><strong>Created At:</strong>
                                            {{ $store->created_at->format('F d, Y') }}</p>
                                        <p class="mb-2"><strong>Last Updated:</strong>
                                            {{ $store->updated_at->format('F d, Y h:i A') }}</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Back Button (Bottom Center) -->
                        <div class="text-center mt-4">
                            <a href="{{ route('dashboard') }}" class="btn text-white px-4 py-2"
                                style="background: linear-gradient(90deg, #ff4da6 0%, #ff6fcf 100%); border:none;">
                                <i class="fe fe-arrow-left me-1"></i> Back to Dashboard
                            </a>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
