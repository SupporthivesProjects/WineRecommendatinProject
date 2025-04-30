@extends('layouts.bootdashboard')
@section('admindashboardcontent')

@push('styles')
@endpush

<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Start::page-header -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
            <div>
                <h2 class="main-content-title fs-24 mb-1">{{ __('Edit User') }}</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users / Edit</li>
                </ol>
            </div>
            <div class="d-flex">
                <a href="{{ route('admin.users.index') }}" class="btn btn-wave btn-secondary my-2 btn-icon-text ms-2">
                    <i class="fe fe-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>
        <!-- End::page-header -->

        <div class="py-5">
            <div class="container-lg">
                <div class="bg-white overflow-hidden shadow-sm rounded p-4">
                    <div class="p-4">
                        <form method="POST" action="{{ route('admin.users.update', $user) }}">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <!-- First Name -->
                                <div class="col-12 col-md-6">
                                    <label for="first_name" class="form-label">{{ __('First Name') }}</label>
                                    <input id="first_name" class="form-control" type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required autofocus />
                                    @error('first_name')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Last Name -->
                                <div class="col-12 col-md-6">
                                    <label for="last_name" class="form-label">{{ __('Last Name') }}</label>
                                    <input id="last_name" class="form-control" type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required />
                                    @error('last_name')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="col-12 col-md-6">
                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" required />
                                    @error('email')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="col-12 col-md-6">
                                    <label for="password" class="form-label">{{ __('Password') }} <small class="text-muted">(Leave blank to keep current)</small></label>
                                    <input id="password" class="form-control" type="password" name="password" />
                                    @error('password')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Mobile -->
                                <div class="col-12 col-md-6">
                                    <label for="mobile" class="form-label">{{ __('Mobile') }}</label>
                                    <input id="mobile" class="form-control" type="text" name="mobile" value="{{ old('mobile', $user->mobile) }}" />
                                    @error('mobile')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Role -->
                                <div class="col-12 col-md-6">
                                    <label for="role" class="form-label">{{ __('Role') }}</label>
                                    <select id="role" name="role" class="form-select" required>
                                        <option value="">Select Role</option>
                                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff</option>
                                        <option value="manager" {{ old('role', $user->role) === 'manager' ? 'selected' : '' }}>Manager</option>
                                    </select>
                                    @error('role')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="col-12 col-md-6">
                                    <label for="status" class="form-label">{{ __('Status') }}</label>
                                    <select id="status" name="status" class="form-select" required>
                                        <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Store ID -->
                                <div class="col-12 col-md-6">
                                    <label for="store_id" class="form-label">{{ __('Store') }}</label>
                                    <select id="store_id" name="store_id" class="form-select" required>
                                        <option value="">Select Store</option>
                                        @foreach($stores as $store)
                                            <option value="{{ $store->id }}" {{ old('store_id', $user->store_id) == $store->id ? 'selected' : '' }}>{{ $store->store_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('store_id')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-3">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update User') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
@endpush
