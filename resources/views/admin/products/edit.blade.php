@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
        <style>
            .dataTables_filter input[type="search"] {
                width: 300px !important;
                margin-bottom: 20px;
            }
            
            .product-thumbnail {
                width: 150px;
                height: 150px;
                object-fit: cover;
                border-radius: 4px;
                border: 1px solid #e2e8f0;
            }
            
            #image-preview img {
                max-width: 100%;
                max-height: 200px;
                margin-bottom: 10px;
                border-radius: 4px;
            }
            
            .form-group {
                margin-bottom: 1.5rem;
            }
            
            .form-label {
                display: block;
                margin-bottom: 0.5rem;
                font-weight: 500;
                color: #1a202c;
            }
            
            .form-control {
                display: block;
                width: 100%;
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
                font-weight: 400;
                line-height: 1.5;
                color: #4a5568;
                background-color: #fff;
                background-clip: padding-box;
                border: 1px solid #e2e8f0;
                border-radius: 0.375rem;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }
            
            .form-control:focus {
                color: #4a5568;
                background-color: #fff;
                border-color: #a0aec0;
                outline: 0;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1);
            }
            
            .invalid-feedback {
                display: none;
                width: 100%;
                margin-top: 0.25rem;
                font-size: 0.875em;
                color: #e53e3e;
            }
            
            .is-invalid ~ .invalid-feedback,
            .is-invalid ~ .invalid-tooltip,
            .was-validated :invalid ~ .invalid-feedback,
            .was-validated :invalid ~ .invalid-tooltip {
                display: block;
            }
            
            .is-invalid, .was-validated .form-control:invalid {
                border-color: #e53e3e;
                padding-right: calc(1.5em + 0.75rem);
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23e53e3e' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23e53e3e' stroke='none'/%3e%3c/svg%3e");
                background-repeat: no-repeat;
                background-position: right calc(0.375em + 0.1875rem) center;
                background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
            }
            
            .alert {
                position: relative;
                padding: 0.75rem 1.25rem;
                margin-bottom: 1rem;
                border: 1px solid transparent;
                border-radius: 0.25rem;
            }
            
            .alert-danger {
                color: #721c24;
                background-color: #f8d7da;
                border-color: #f5c6cb;
            }
            
            .btn {
                display: inline-block;
                font-weight: 500;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;
                user-select: none;
                border: 1px solid transparent;
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
                line-height: 1.5;
                border-radius: 0.25rem;
                transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }
            
            .btn-primary {
                color: #fff;
                background-color: #4f46e5;
                border-color: #4f46e5;
            }
            
            .btn-primary:hover {
                background-color: #4338ca;
                border-color: #4338ca;
            }
            
            .btn-secondary {
                color: #4a5568;
                background-color: #e2e8f0;
                border-color: #e2e8f0;
            }
            
            .btn-secondary:hover {
                background-color: #cbd5e0;
                border-color: #cbd5e0;
            }
            
            .card {
                position: relative;
                display: flex;
                flex-direction: column;
                min-width: 0;
                word-wrap: break-word;
                background-color: #fff;
                background-clip: border-box;
                border: 1px solid #e2e8f0;
                border-radius: 0.25rem;
                margin-bottom: 1.5rem;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            }
            
            .card-header {
                padding: 1rem 1.25rem;
                margin-bottom: 0;
                background-color: #f8fafc;
                border-bottom: 1px solid #e2e8f0;
            }
            
            .card-header:first-child {
                border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
            }
            
            .card-body {
                flex: 1 1 auto;
                padding: 1.25rem;
            }
            
            .card-title {
                margin-bottom: 0;
                font-size: 1.25rem;
                font-weight: 500;
                line-height: 1.2;
                color: #1a202c;
            }
            
            .text-danger {
                color: #e53e3e !important;
            }
            
            .mb-3 {
                margin-bottom: 1rem !important;
            }
            
            .mb-4 {
                margin-bottom: 1.5rem !important;
            }
            
            .mt-4 {
                margin-top: 1.5rem !important;
            }
            
            .mt-8 {
                margin-top: 2rem !important;
            }
            
            .ml-2 {
                margin-left: 0.5rem !important;
            }
            
            .mr-2 {
                margin-right: 0.5rem !important;
            }
            
            .px-4 {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            .py-2 {
                padding-top: 0.5rem !important;
                padding-bottom: 0.5rem !important;
            }
            
            .rounded {
                border-radius: 0.25rem !important;
            }
            
            .border {
                border: 1px solid #e2e8f0 !important;
            }
            
            .border-t {
                border-top: 1px solid #e2e8f0 !important;
            }
            
            .bg-gray-50 {
                background-color: #f9fafb !important;
            }
            
            .flex {
                display: flex !important;
            }
            
            .items-center {
                align-items: center !important;
            }
            
            .justify-end {
                justify-content: flex-end !important;
            }
            
            .space-x-3 > :not([hidden]) ~ :not([hidden]) {
                margin-left: 0.75rem !important;
            }
            
            .transition {
                transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
                transition-duration: 150ms;
            }
            
            .hover\:bg-gray-50:hover {
                background-color: #f9fafb !important;
            }
            
            .focus\:outline-none:focus {
                outline: 2px solid transparent;
                outline-offset: 2px;
            }
            
            .focus\:shadow-outline:focus {
                box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
            }
            
            .grid {
                display: grid;
            }
            
            .grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            
            @media (min-width: 768px) {
                .md\:grid-cols-4 {
                    grid-template-columns: repeat(4, minmax(0, 1fr));
                }
            }
            
            .gap-4 {
                gap: 1rem;
            }
            
            .relative {
                position: relative;
            }
            
            .absolute {
                position: absolute;
            }
            
            .top-0 {
                top: 0;
            }
            
            .right-0 {
                right: 0;
            }
            
            .bg-red-600 {
                background-color: #e53e3e;
            }
            
            .text-white {
                color: #fff;
            }
            
            .rounded-bl {
                border-bottom-left-radius: 0.25rem;
            }
            
            .p-1 {
                padding: 0.25rem;
            }
            
            .h-4 {
                height: 1rem;
            }
            
            .w-4 {
                width: 1rem;
            }
            
            .object-cover {
                object-fit: cover;
            }
            
            .hidden {
                display: none;
            }
            
            .group:hover .group-hover\:opacity-100 {
                opacity: 1;
            }
            
            .opacity-0 {
                opacity: 0;
            }
            
            .opacity-50 {
                opacity: 0.5;
            }
            
            .opacity-100 {
                opacity: 1;
            }
            
            .transition-opacity {
                transition-property: opacity;
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
                transition-duration: 150ms;
            }
            
            .duration-75 {
                transition-duration: 75ms;
            }
            
            .ease-in-out {
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .cursor-pointer {
                cursor: pointer;
            }
            
            .cursor-not-allowed {
                cursor: not-allowed;
            }
            
            .bg-indigo-600 {
                background-color: #4f46e5;
            }
            
            .hover\:bg-indigo-700:hover {
                background-color: #4338ca;
            }
            
            .border-indigo-500 {
                border-color: #6366f1;
            }
            
            .border-2 {
                border-width: 2px;
            }
            
            .border-gray-200 {
                border-color: #e2e8f0;
            }
            
            .bg-black {
                background-color: #000;
            }
            
            .bg-opacity-40 {
                --tw-bg-opacity: 0.4;
            }
            
            .flex {
                display: flex;
            }
            
            .items-center {
                align-items: center;
            }
            
            .justify-center {
                justify-content: center;
            }
            
            .space-x-2 > :not([hidden]) ~ :not([hidden]) {
                --tw-space-x-reverse: 0;
                margin-right: calc(0.5rem * var(--tw-space-x-reverse));
                margin-left: calc(0.5rem * calc(1 - var(--tw-space-x-reverse)));
            }
            
            .h-8 {
                height: 2rem;
            }
            
            .w-8 {
                width: 2rem;
            }
            
            .rounded-full {
                border-radius: 9999px;
            }
            
            .text-xs {
                font-size: 0.75rem;
                line-height: 1rem;
            }
            
            .text-sm {
                font-size: 0.875rem;
                line-height: 1.25rem;
            }
            
            .font-medium {
                font-weight: 500;
            }
            
            .text-gray-500 {
                --tw-text-opacity: 1;
                color: rgb(107 114 128 / var(--tw-text-opacity));
            }
            
            .text-gray-700 {
                --tw-text-opacity: 1;
                color: rgb(55 65 81 / var(--tw-text-opacity));
            }
            
            .text-indigo-600 {
                --tw-text-opacity: 1;
                color: rgb(79 70 229 / var(--tw-text-opacity));
            }
            
            .hover\:text-indigo-500:hover {
                --tw-text-opacity: 1;
                color: rgb(99 102 241 / var(--tw-text-opacity));
            }
            
            .focus-within\:outline-none:focus-within {
                outline: 2px solid transparent;
                outline-offset: 2px;
            }
            
            .sr-only {
                position: absolute;
                width: 1px;
                height: 1px;
                padding: 0;
                margin: -1px;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
                white-space: nowrap;
                border-width: 0;
            }
            
            .pl-1 {
                padding-left: 0.25rem;
            }
            
            .text-center {
                text-align: center;
            }
            
            .text-gray-600 {
                --tw-text-opacity: 1;
                color: rgb(75 85 99 / var(--tw-text-opacity));
            }
            
            .text-gray-900 {
                --tw-text-opacity: 1;
                color: rgb(17 24 39 / var(--tw-text-opacity));
            }
            
            .text-lg {
                font-size: 1.125rem;
                line-height: 1.75rem;
            }
            
            .font-medium {
                font-weight: 500;
            }
            
            .mt-1 {
                margin-top: 0.25rem;
            }
            
            .mt-2 {
                margin-top: 0.5rem;
            }
            
            .mb-2 {
                margin-bottom: 0.5rem;
            }
            
            .mb-4 {
                margin-bottom: 1rem;
            }
            
            .block {
                display: block;
            }
            
            .w-full {
                width: 100%;
            }
            
            .appearance-none {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
            }
            
            .rounded-md {
                border-radius: 0.375rem;
            }
            
            .border-gray-300 {
                --tw-border-opacity: 1;
                border-color: rgb(209 213 219 / var(--tw-border-opacity));
            }
            
            .border-dashed {
                border-style: dashed;
            }\n        </style>
    @endpush

    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Edit Product</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </div>
                <div class="d-flex">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-wave btn-secondary my-2">
                        <i class="fe fe-arrow-left me-2"></i> Back to List
                    </a>
                </div>
            </div>
            <!-- End::page-header -->

            <!-- Start::row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Product</h4>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('admin.products.update', $product->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label for="wine_name" class="form-label">Wine Name <span class="text-danger">*</span></label>
                                            <input type="text" name="wine_name" id="wine_name"
                                                class="form-control @error('wine_name') is-invalid @enderror"
                                                value="{{ old('wine_name', $product->wine_name) }}" required>
                                            @error('wine_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                                <option value="">Select Type</option>
                                                <option value="red" {{ old('type', $product->type) == 'red' ? 'selected' : '' }}>Red Wine</option>
                                                <option value="white" {{ old('type', $product->type) == 'white' ? 'selected' : '' }}>White Wine</option>
                                                <option value="rose" {{ old('type', $product->type) == 'rose' ? 'selected' : '' }}>Rosé</option>
                                                <option value="sparkling" {{ old('type', $product->type) == 'sparkling' ? 'selected' : '' }}>Sparkling</option>
                                            </select>
                                            @error('type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="winery" class="form-label">Winery <span class="text-danger">*</span></label>
                                            <input type="text" name="winery" id="winery"
                                                class="form-control @error('winery') is-invalid @enderror"
                                                value="{{ old('winery', $product->winery) }}" required>
                                            @error('winery')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="grape_variety" class="form-label">Grape Variety</label>
                                            <input type="text" name="grape_variety" id="grape_variety"
                                                class="form-control @error('grape_variety') is-invalid @enderror"
                                                value="{{ old('grape_variety', $product->grape_variety) }}">
                                            @error('grape_variety')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label for="country" class="form-label">Country</label>
                                            <input type="text" name="country" id="country"
                                                class="form-control @error('country') is-invalid @enderror"
                                                value="{{ old('country', $product->country) }}">
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="wine_sub_region" class="form-label">Region</label>
                                            <input type="text" name="wine_sub_region" id="wine_sub_region"
                                                class="form-control @error('wine_sub_region') is-invalid @enderror"
                                                value="{{ old('wine_sub_region', $product->wine_sub_region) }}">
                                            @error('wine_sub_region')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="retail_price" class="form-label">Retail Price ($) <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" name="retail_price" id="retail_price"
                                                    class="form-control @error('retail_price') is-invalid @enderror"
                                                    value="{{ old('retail_price', $product->retail_price) }}" step="0.01" min="0" required>
                                            </div>
                                            @error('retail_price')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                                <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Images Section -->
                                <div class="mt-8">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Product Images</h3>

                                    <!-- Current Images -->
                                    @if ($product->images && $product->images->count() > 0)
                                        <div class="mb-6">
                                            <label class="block text-gray-700 text-sm font-bold mb-2">Current
                                                Images</label>
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                                @foreach ($product->images as $image)
                                                    <div class="relative group">
                                                        <img src="{{ asset('storage/products/' . $image->image_path) }}"
                                                            alt="Product image"
                                                            class="w-full h-32 object-cover rounded border {{ $image->is_primary ? 'border-indigo-500 border-2' : 'border-gray-200' }}">

                                                        <div
                                                            class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded">
                                                            <div class="flex space-x-2">
                                                                <!-- Set as primary button -->
                                                                <button type="button"
                                                                    onclick="setPrimaryImage({{ $image->id }})"
                                                                    class="bg-indigo-600 text-white p-1 rounded hover:bg-indigo-700 {{ $image->is_primary ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                                    {{ $image->is_primary ? 'disabled' : '' }}>
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-5 w-5" viewBox="0 0 20 20"
                                                                        fill="currentColor">
                                                                        <path fill-rule="evenodd"
                                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                </button>

                                                                <!-- Delete button -->
                                                                <button type="button"
                                                                    onclick="toggleImageDelete({{ $image->id }})"
                                                                    class="bg-red-600 text-white p-1 rounded hover:bg-red-700">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-5 w-5" viewBox="0 0 20 20"
                                                                        fill="currentColor">
                                                                        <path fill-rule="evenodd"
                                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <!-- Primary badge -->
                                                        @if ($image->is_primary)
                                                            <div
                                                                class="absolute top-0 left-0 bg-indigo-600 text-white text-xs px-2 py-1 rounded-br">
                                                                Primary
                                                            </div>
                                                        @endif

                                                        <!-- Delete indicator -->
                                                        <div id="delete-badge-{{ $image->id }}"
                                                            class="absolute top-0 right-0 bg-red-600 text-white text-xs px-2 py-1 rounded-bl hidden">
                                                            Delete
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-gray-500 italic mb-4">No images have been uploaded for this
                                            product.</p>
                                    @endif

                                    <!-- Hidden inputs for image operations -->
                                    <input type="hidden" name="primary_image" id="primary_image"
                                        value="{{ $product->images?->where('is_primary', true)->first()?->id ?? '' }}">
                                    <div id="images-to-delete-container"></div>

                                    <!-- Upload New Images -->
                                    <div class="mb-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2"
                                            for="product_images">Upload New Images</label>
                                        <div
                                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                    fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path
                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="product_images"
                                                        class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                                        <span>Upload files</span>
                                                        <input id="product_images" name="product_images[]" type="file"
                                                            class="sr-only" multiple accept="image/*"
                                                            onchange="previewNewImages(this)">
                                                    </label>
                                                    <p class="pl-1">or drag and drop</p>
                                                </div>
                                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- New Images Preview -->
                                    <div id="new-images-preview" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                    </div>
                                </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex items-center justify-end space-x-3 border-t border-gray-200">
                            <a href="{{ route('admin.products.show', $product) }}"
                                class="bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-gray-50 transition">
                                Cancel
                            </a>
                            <button
                                class="bg-indigo-600 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-indigo-700 transition"
                                type="submit">
                                Update Product
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // JavaScript for Image Management
            function previewImages(input) {
                const preview = document.getElementById('image-preview');
                
                // Clear any existing previews from new file selection
                const existingPreviews = preview.querySelectorAll('.new-image-preview');
                existingPreviews.forEach(el => el.remove());
                
                if (input.files) {
                    Array.from(input.files).forEach((file, index) => {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.className = 'position-relative d-inline-block me-2 mb-2 new-image-preview';
                            div.innerHTML = `
                                <img src="${e.target.result}" 
                                     alt="Preview" 
                                     class="img-thumbnail product-thumbnail">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" 
                                           name="primary_image_new" 
                                           value="${index}">
                                    <label class="form-check-label">Set as primary</label>
                                </div>
                            `;
                            preview.appendChild(div);
                        }
                        
                        reader.readAsDataURL(file);
                    });
                }
            }
            
            // Initialize any necessary scripts when the document is ready
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize any additional scripts here if needed
            });
            // Array to track images to delete
            let imagesToDelete = [];

            // Set an image as primary
            function setPrimaryImage(imageId) {
                document.getElementById('primary_image').value = imageId;

                // Update UI to reflect the change
                document.querySelectorAll('.border-indigo-500').forEach(el => {
                    el.classList.remove('border-indigo-500', 'border-2');
                    el.classList.add('border-gray-200');
                });

                document.querySelectorAll('.absolute.top-0.left-0.bg-indigo-600').forEach(el => {
                    el.classList.add('hidden');
                });

                const newPrimaryImg = document.querySelector(`img[src*="${imageId}"]`);
                if (newPrimaryImg) {
                    newPrimaryImg.classList.remove('border-gray-200');
                    newPrimaryImg.classList.add('border-indigo-500', 'border-2');

                    const badge = newPrimaryImg.parentElement.querySelector('.absolute.top-0.left-0.bg-indigo-600');
                    if (badge) {
                        badge.classList.remove('hidden');
                    }
                }
            }

            // Toggle image for deletion
            function toggleImageDelete(imageId) {
                const index = imagesToDelete.indexOf(imageId);
                const badge = document.getElementById(`delete-badge-${imageId}`);

                if (index === -1) {
                    // Add to delete list
                    imagesToDelete.push(imageId);
                    badge.classList.remove('hidden');
                } else {
                    // Remove from delete list
                    imagesToDelete.splice(index, 1);
                    badge.classList.add('hidden');
                }

                // Update hidden inputs
                updateImagesToDeleteInputs();
            }

            // Update hidden inputs for images to delete
            function updateImagesToDeleteInputs() {
                const container = document.getElementById('images-to-delete-container');
                container.innerHTML = '';

                imagesToDelete.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'images_to_delete[]';
                    input.value = id;
                    container.appendChild(input);
                });
            }

            // Preview new images before upload
            function previewNewImages(input) {
                const previewContainer = document.getElementById('new-images-preview');
                previewContainer.innerHTML = '';

                if (input.files && input.files.length > 0) {
                    for (let i = 0; i < input.files.length; i++) {
                        const file = input.files[i];
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            const previewWrapper = document.createElement('div');
                            previewWrapper.className = 'relative';

                            const previewImage = document.createElement('img');
                            previewImage.src = e.target.result;
                            previewImage.className = 'w-full h-32 object-cover rounded border border-gray-200';
                            previewImage.alt = 'New image preview';

                            const removeButton = document.createElement('button');
                            removeButton.type = 'button';
                            removeButton.className = 'absolute top-0 right-0 bg-red-600 text-white rounded-bl p-1';
                            removeButton.innerHTML =
                                '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>';
                            removeButton.onclick = function() {
                                previewWrapper.remove();
                            };

                            previewWrapper.appendChild(previewImage);
                            previewWrapper.appendChild(removeButton);
                            previewContainer.appendChild(previewWrapper);
                        };

                        reader.readAsDataURL(file);
                    }
                }
            }
        </script>
    @endpush
@endsection
