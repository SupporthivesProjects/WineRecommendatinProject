@extends('layouts.bootdashboard')
@section('admindashboardcontent')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb mb-4">
            <div>
                <h2 class="main-content-title fs-24 mb-1">User Details</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $user->first_name }} {{ $user->last_name }}</li>
                </ol>
            </div>
            <div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-icon-text">
                    <i class="fe fe-arrow-left me-2"></i> Back to Users
                </a>
            </div>
        </div>

        <!-- User Details Card -->
        <div class="card shadow-sm border-0 p-5">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <h3 class="mb-0 text-primary">{{ $user->first_name }} {{ $user->last_name }}</h3>
                <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'danger' }} text-uppercase px-3 py-2">
                    {{ ucfirst($user->status) }}
                </span>
            </div>
            <div class="card-body">
                <!-- User Info Grid -->
                <h5 class="mt-5 mb-3 text-dark">User Information</h5>
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="first_name" class="form-label">First Name</label>
                            <p>{{ $user->first_name }}</p>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="form-label">Last Name</label>
                            <p>{{ $user->last_name }}</p>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <p>{{ $user->email }}</p>
                        </div>
                        <div class="form-group">
                            <label for="mobile" class="form-label">Mobile</label>
                            <p>{{ $user->mobile ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="role" class="form-label">Role</label>
                            <span class="badge bg-primary text-white">{{ ucfirst($user->role) }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="store" class="form-label">Store</label>
                            <p>
                                @if($user->store)
                                    <a href="{{ route('admin.stores.show', $user->store) }}" class="text-primary">
                                        {{ $user->store->store_name }}
                                    </a>
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Status</label>
                            <div class="d-flex align-items-center">
                                <span class="me-3">{{ ucfirst($user->status) }}</span>
                                <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-{{ $user->status === 'active' ? 'danger' : 'success' }}">
                                        {{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="created" class="form-label">Created</label>
                            <p>{{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card-footer bg-white text-end">
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger me-2">Delete</button>
                </form>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>
    </div>
</div>
@endsection
