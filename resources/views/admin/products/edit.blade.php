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
                        <form method="POST" enctype="multipart/form-data" id="product-form"
                            action="{{ route('admin.products.update', $product->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="container-fluid">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="wine_name" class="form-label">Wine Name</label>
                                        <input type="text" class="form-control" name="wine_name" id="wine_name"
                                            value="{{ old('wine_name', $product->wine_name) }}" required>
                                    </div>
                                    @php 
                                        $selectedType = strtolower(old('type', $product->type)); 
                                    @endphp

                                    <div class="col-md-6">
                                        <label for="type" class="form-label">Type</label>
                                        <select class="form-select" name="type" id="type">
                                            <option value="">Select Type</option>
                                            <option value="red" {{ $selectedType == 'red' ? 'selected' : '' }}>Red Wine</option>
                                            <option value="white" {{ $selectedType == 'white' ? 'selected' : '' }}>White Wine</option>
                                            <option value="rosé" {{ $selectedType == 'rose' ? 'selected' : '' }}>Rosé</option>
                                            <option value="sparkling" {{ $selectedType == 'sparkling' ? 'selected' : '' }}>Sparkling</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="sp_mentions" class="form-label">Special Mentions</label>
                                        @php
                                            $selectedMention = strtolower(old('sp_mentions', $product->sp_mentions ?? ''));
                    
                                        @endphp

                                        <select class="form-select" name="sp_mentions" id="sp_mentions">
                                            <option value="">Select</option>
                                            <option value="fortified" {{ $selectedMention == 'fortified' ? 'selected' : '' }}>Fortified</option>
                                            <option value="port" {{ $selectedMention == 'port' ? 'selected' : '' }}>Port</option>
                                            <option value="marsala" {{ $selectedMention == 'marsala' ? 'selected' : '' }}>Marsala</option>
                                            <option value="sherry" {{ $selectedMention == 'sherry' ? 'selected' : '' }}>Sherry</option>
                                            <option value="orange" {{ $selectedMention == 'orange' ? 'selected' : '' }}>Orange</option>
                                            <option value="fruit" {{ $selectedMention == 'fruit' ? 'selected' : '' }}>Fruit</option>
                                            <option value="NA" {{ $selectedMention == 'na' ? 'selected' : '' }}>NA</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="method" class="form-label">Method</label>
                                        @php
                                            $selectedMethod = strtolower(old('method', $product->Method ?? ''));
                                        @endphp

                                        <select class="form-select" name="method" id="method">
                                            <option value="">Select Method</option>
                                            <option value="still" {{ $selectedMethod == 'still' ? 'selected' : '' }}>Still</option>
                                            <option value="sparkling" {{ $selectedMethod == 'sparkling' ? 'selected' : '' }}>Sparkling</option>
                                            <option value="semi sparkling" {{ $selectedMethod == 'semi sparkling' ? 'selected' : '' }}>Semi Sparkling</option>
                                            <option value="fortified" {{ $selectedMethod == 'fortified' ? 'selected' : '' }}>Fortified</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="winery" class="form-label">Winery</label>
                                        <input type="text" class="form-control" name="winery" id="winery"
                                            value="{{ old('winery', $product->winery) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="grape_variety" class="form-label">Grape Variety</label>
                                        <input type="text" class="form-control" name="grape_variety" id="grape_variety"
                                            value="{{ old('grape_variety', $product->grape_variety) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="varietal_blend" class="form-label">Varietal Blend</label>
                                        <input type="text" class="form-control" name="varietal_blend" id="varietal_blend"
                                            value="{{ old('varietal_blend', $product->varietal_blend) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="vintage_year" class="form-label">Vintage Year</label>
                                        <input type="text" class="form-control" name="vintage_year" id="vintage_year"
                                            value="{{ old('vintage_year', $product->vintage_year) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" class="form-control" name="country" id="country"
                                            value="{{ old('country', $product->country) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="region" class="form-label">Region</label>
                                        <input type="text" class="form-control" name="region" id="region"
                                            value="{{ old('region', $product->region) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="wine_sub_region" class="form-label">Sub Region</label>
                                        <input type="text" class="form-control" name="wine_sub_region" id="wine_sub_region"
                                            value="{{ old('wine_sub_region', $product->wine_sub_region) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="designation" class="form-label">Designation</label>
                                        <input type="text" class="form-control" name="designation" id="designation"
                                            value="{{ old('designation', $product->designation) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="alcohol_vol" class="form-label">Alcohol Volume</label>
                                        <input type="text" class="form-control" name="alcohol_vol" id="alcohol_vol"
                                            value="{{ old('alcohol_vol', $product->alcohol_vol) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="residual_sugar" class="form-label">Residual Sugar</label>
                                        <input type="text" class="form-control" name="residual_sugar" id="residual_sugar"
                                            value="{{ old('residual_sugar', $product->residual_sugar) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="nature" class="form-label">Nature</label>
                                        <input type="text" class="form-control" name="nature" id="nature"
                                            value="{{ old('nature', $product->nature) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="acidity" class="form-label">Acidity</label>
                                        <input type="text" class="form-control" name="acidity" id="acidity"
                                            value="{{ old('acidity', $product->acidity) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="tannin_level" class="form-label">Tannin Level</label>
                                        <input type="text" class="form-control" name="tannin_level" id="tannin_level"
                                            value="{{ old('tannin_level', $product->tannin_level) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="body" class="form-label">Body</label>
                                        <input type="text" class="form-control" name="body" id="body"
                                            value="{{ old('body', $product->body) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="aging" class="form-label">Aging</label>
                                        <input type="text" class="form-control" name="aging" id="aging"
                                            value="{{ old('aging', $product->aging) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="barrel_type" class="form-label">Barrel Type</label>
                                        <input type="text" class="form-control" name="barrel_type" id="barrel_type"
                                            value="{{ old('barrel_type', $product->barrel_type) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="time_spent_aging" class="form-label">Time Spent Aging</label>
                                        <input type="text" class="form-control" name="time_spent_aging" id="time_spent_aging"
                                            value="{{ old('time_spent_aging', $product->time_spent_aging) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="closure_type" class="form-label">Closure Type</label>
                                        <input type="text" class="form-control" name="closure_type" id="closure_type"
                                            value="{{ old('closure_type', $product->closure_type) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="aroma" class="form-label">Aroma</label>
                                        <textarea class="form-control" name="aroma" id="aroma" rows="2">{{ old('aroma', $product->aroma) }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="palate" class="form-label">Palate</label>
                                        <textarea class="form-control" name="palate" id="palate" rows="2">{{ old('palate', $product->palate) }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="finish" class="form-label">Finish</label>
                                        <textarea class="form-control" name="finish" id="finish" rows="2">{{ old('finish', $product->finish) }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="sweetness_level" class="form-label">Sweetness Level</label>
                                        <input type="text" class="form-control" name="sweetness_level" id="sweetness_level"
                                            value="{{ old('sweetness_level', $product->sweetness_level) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="glass_ware" class="form-label">Glass Ware</label>
                                        <input type="text" class="form-control" name="glass_ware" id="glass_ware"
                                            value="{{ old('glass_ware', $product->glass_ware) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="retail_price" class="form-label">Retail Price (₹)&nbsp;</label>
                                        <input type="number" step="0.01" class="form-control" name="retail_price" id="retail_price"
                                            value="{{ old('retail_price', $product->retail_price) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="discounts" class="form-label">Discounts</label>
                                        <input type="text" class="form-control" name="discounts" id="discounts"
                                            value="{{ old('discounts', $product->discounts) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="optimal_drinking" class="form-label">Optimal Drinking</label>
                                        <input type="text" class="form-control" name="optimal_drinking" id="optimal_drinking"
                                            value="{{ old('optimal_drinking', $product->optimal_drinking) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="style" class="form-label">Style</label>
                                        <input type="text" class="form-control" name="style" id="style"
                                            value="{{ old('style', $product->style) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="decanting_time" class="form-label">Decanting Time</label>
                                        <input type="text" class="form-control" name="decanting_time" id="decanting_time"
                                            value="{{ old('decanting_time', $product->decanting_time) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="ageing_potential" class="form-label">Ageing Potential</label>
                                        <input type="text" class="form-control" name="ageing_potential" id="ageing_potential"
                                            value="{{ old('ageing_potential', $product->ageing_potential) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="cheese_pairing" class="form-label">Cheese Pairing</label>
                                        <select class="form-select select2" name="cheese_pairing[]" id="cheese_pairing" multiple>
                                            @foreach(\App\Models\CheeseProduct::all() as $cheese)
                                                <option value="{{ $cheese->name }}"
                                                    {{ collect(old('cheese_pairing', explode(',', $product->cheese_pairing ?? '')))->contains($cheese->name) ? 'selected' : '' }}>
                                                    {{ $cheese->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="importer_info" class="form-label">Importer Info</label>
                                        <input type="text" class="form-control" name="importer_info" id="importer_info"
                                            value="{{ old('importer_info', $product->importer_info) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="wine_story" class="form-label">Wine Story</label>
                                        <textarea class="form-control" name="wine_story" id="wine_story" rows="2">{{ old('wine_story', $product->wine_story) }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="tasting_notes" class="form-label">Tasting Notes</label>
                                        <textarea class="form-control" name="tasting_notes" id="tasting_notes" rows="2">{{ old('tasting_notes', $product->tasting_notes) }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="status">Status</label>
                                        <select class="form-select" name="status" id="status" required>
                                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Image Upload Section -->
                                <div class="mt-4">
                                        <div class="mt-2">
                                            @if ($product->image1)
                                            <p class="mb-1 fw-bold">Current Image:</p>
                                                <img src="{{ asset('storage/' . $product->image1) }}" alt="Product image"
                                                    class="img-thumbnail" style="width:150px; height:150px; object-fit:cover;">
                                            @else
                                            <p class="mb-1 fw-bold">Current Image:</p>
                                                <img src="{{ asset('storage/default.jpg' ) }}" alt="Product image"
                                                    class="img-thumbnail" style="width:150px; height:150px; object-fit:cover;">

                                            @endif
                                        </div>
                                </div>
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
                                                        <div id="image-preview" class="mt-4"></div> 
                                                        <input id="product_images" 
                                                            name="product_image_replace" 
                                                            type="file"
                                                            class="sr-only"
                                                            multiple 
                                                            accept="image/*"
                                                            onchange="previewImages(this)">
                                                    </label>
                                                    <p class="pl-1">or drag and drop</p>
                                                </div>
                                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                            </div>
                                        </div>
                                    </div>

                                <div class="row g-3 mt-3">
                                    <div class="col-md-6">
                                        <label for="categories" class="form-label">Category</label>
                                        <!-- <select class="form-select" name="categories" id="categories" required>
                                            <option value="">Select Category</option>
                                            <option value="Gifting" {{ old('categories', $product->categories) == 'Gifting' ? 'selected' : '' }}>Gifting</option>
                                            <option value="Wine and Cheese" {{ old('categories', $product->categories) == 'Wine and Cheese' ? 'selected' : '' }}>Wine and Cheese</option>
                                            <option value="Everyday sipping" {{ old('categories', $product->categories) == 'Everyday sipping' ? 'selected' : '' }}>Everyday sipping</option>
                                        </select> -->
                                                                                @php
                                            $savedValue = old('categories', $product->categories);

                                            // Your existing dropdown options
                                            $defaultOptions = [
                                                'Gifting',
                                                'Wine and Cheese',
                                                'Everyday Sipping',
                                            ];

                                            // Check if savedValue is NOT in the default dropdown list
                                            $shouldAddCustomOption = $savedValue && !in_array($savedValue, $defaultOptions);
                                        @endphp


                                        <select class="form-select" name="categories" id="categories" required>
                                            <option value="">Select Category</option>

                                            {{-- Show default options --}}
                                            @foreach ($defaultOptions as $opt)
                                                <option value="{{ $opt }}" {{ $savedValue == $opt ? 'selected' : '' }}>
                                                    {{ $opt }}
                                                </option>
                                            @endforeach

                                            {{-- If DB value is something like "Gifting, Celebration", add it dynamically --}}
                                            @if ($shouldAddCustomOption)
                                                <option value="{{ $savedValue }}" selected>{{ $savedValue }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline-secondary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update Product</button>
                                </div>
                            </div>
                        </form>

                            
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
                function previewImages(input) {
                    const preview = document.getElementById('image-preview');
                                
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
                            };
                            
                            reader.readAsDataURL(file);
                        });
                    }
                }


            // JavaScript for Image Management
            // function previewImages(input) {
            //     const preview = document.getElementById('image-preview');
                
            //     // Clear any existing previews from new file selection
            //     const existingPreviews = preview.querySelectorAll('.new-image-preview');
            //     existingPreviews.forEach(el => el.remove());
                
            //     if (input.files) {
            //         Array.from(input.files).forEach((file, index) => {
            //             const reader = new FileReader();
                        
            //             reader.onload = function(e) {
            //                 const div = document.createElement('div');
            //                 div.className = 'position-relative d-inline-block me-2 mb-2 new-image-preview';
            //                 div.innerHTML = `
            //                     <img src="${e.target.result}" 
            //                          alt="Preview" 
            //                          class="img-thumbnail product-thumbnail">
            //                     <div class="form-check mt-2">
            //                         <input class="form-check-input" type="radio" 
            //                                name="primary_image_new" 
            //                                value="${index}">
            //                         <label class="form-check-label">Set as primary</label>
            //                     </div>
            //                 `;
            //                 preview.appendChild(div);
            //             }
                        
            //             reader.readAsDataURL(file);
            //         });
            //     }
            // }
            
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
