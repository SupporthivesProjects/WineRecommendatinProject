@extends('layouts.bootdashboard')
@section('admindashboardcontent')

    @push('styles')
    @endpush

    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">{{ __('Edit Store') }}</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Stores / Edit</li>
                    </ol>
                </div>
                <div class="d-flex">
                    <a href="{{ route('admin.stores.index') }}" class="btn btn-wave btn-secondary my-2 btn-icon-text ms-2"> <!-- Add ms-2 here -->
                        <i class="fe fe-arrow-left me-2"></i>Back
                    </a>
                </div>
            </div>

            <!-- End : page-heaer -->
            <!-- Start row -->
            <div class="py-5">
                <div class="container-lg">
                    <div class="bg-white overflow-hidden shadow-sm rounded p-4">
                        <div class="p-4">
                            <form method="POST" action="{{ route('admin.stores.update', $store) }}">
                                @csrf
                                @method('PUT')

                                <div class="row g-4">
                                    <!-- Store Name -->
                                    <div class="col-12 col-md-6">
                                        <label for="store_name" class="form-label">{{ __('Store Name') }}</label>
                                        <input id="store_name" class="form-control" type="text" name="store_name" value="{{ old('store_name', $store->store_name) }}" required autofocus />
                                        @error('store_name')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Business Type -->
                                    <div class="col-12 col-md-6">
                                        <label for="business_type" class="form-label">{{ __('Business Type') }}</label>
                                        <input id="business_type" class="form-control" type="text" name="business_type" value="{{ old('business_type', $store->business_type) }}" />
                                        @error('business_type')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Address -->
                                    <div class="col-12">
                                        <label for="address" class="form-label">{{ __('Address') }}</label>
                                        <textarea id="address" name="address" rows="3" class="form-control">{{ old('address', $store->address) }}</textarea>
                                        @error('address')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Contact Number -->
                                    <div class="col-12 col-md-6">
                                        <label for="contact_number" class="form-label">{{ __('Contact Number') }}</label>
                                        <input id="contact_number" class="form-control" type="text" name="contact_number" value="{{ old('contact_number', $store->contact_number) }}" />
                                        @error('contact_number')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="col-12 col-md-6">
                                        <label for="email" class="form-label">{{ __('Email') }}</label>
                                        <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $store->email) }}" />
                                        @error('email')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- State -->
                                    <div class="col-12 col-md-6">
                                        <label for="state" class="form-label">{{ __('State') }}</label>
                                        <input id="state" class="form-control" type="text" name="state" value="{{ old('state', $store->state) }}" />
                                        @error('state')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- License Type -->
                                    <div class="col-12 col-md-6">
                                        <label for="licence_type" class="form-label">{{ __('License Type') }}</label>
                                        <input id="licence_type" class="form-control" type="text" name="licence_type" value="{{ old('licence_type', $store->licence_type) }}" />
                                        @error('licence_type')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- License Number -->
                                    <div class="col-12 col-md-6">
                                        <label for="license_number" class="form-label">{{ __('License Number') }}</label>
                                        <input id="license_number" class="form-control" type="text" name="license_number" value="{{ old('license_number', $store->license_number) }}" />
                                        @error('license_number')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Group -->
                                    <div class="col-12 col-md-6">
                                        <label for="group" class="form-label">{{ __('Group') }}</label>
                                        <input id="group" class="form-control" type="text" name="group" value="{{ old('group', $store->group) }}" />
                                        @error('group')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- GST/VAT -->
                                    <div class="col-12 col-md-6">
                                        <label for="gst_vat" class="form-label">{{ __('GST/VAT') }}</label>
                                        <input id="gst_vat" class="form-control" type="text" name="gst_vat" value="{{ old('gst_vat', $store->gst_vat) }}" />
                                        @error('gst_vat')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="col-12 col-md-6">
                                        <label for="status" class="form-label">{{ __('Status') }}</label>
                                        <select id="status" name="status" class="form-select">
                                            <option value="active" {{ old('status', $store->status) === 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $store->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ route('admin.stores.index') }}" class="btn btn-secondary me-3">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update Store') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- End Row -->
        </div>
    </div>

@endsection
@push('scripts')

@endpush
