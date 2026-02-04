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
            }
            #image-preview img {
                max-width: 100%;
                max-height: 200px;
                margin-bottom: 10px;
            }
        </style>
    @endpush
    
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">{{ isset($product) ? 'Edit' : 'Create' }} Cheese Product</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.cheese-products.index') }}">Cheese Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($product) ? 'Edit' : 'Create' }}</li>
                    </ol>
                </div>
                <div class="d-flex">
                    <a href="{{ route('admin.cheese-products.index') }}" class="btn btn-wave btn-secondary my-2">
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
                            <h4 class="card-title">{{ isset($product) ? 'Edit' : 'Create New' }} Cheese Product</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($product) ? route('admin.cheese-products.update', $product->id) : route('admin.cheese-products.store') }}" 
                                  method="POST" 
                                  enctype="multipart/form-data">
                                @csrf
                                @if(isset($product))
                                    @method('PUT')
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   value="{{ old('name', $product->name ?? '') }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea name="description" id="description" rows="4" 
                                                     class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description ?? '') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <!-- <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">₹</span>
                                                <input type="number" name="price" id="price" step="0.01" min="0" 
                                                       class="form-control @error('price') is-invalid @enderror" 
                                                       value="{{ old('price', $product->price ?? '') }}" required>
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div> -->
                                        </div>

                                        <div class="form-check form-switch mb-3">
                                            <input type="hidden" name="is_active" value="0">
                                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                                                   value="1" {{ (old('is_active', isset($product) ? $product->is_active : true) ? 'checked' : '') }}>
                                            <label class="form-check-label" for="is_active">Active</label>
                                            @error('is_active')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Product Image</h5>
                                            </div>
                                            <div class="card-body text-center">
                                                @if(isset($product) && $product->image)
                                                    <div id="image-preview">
                                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                                             alt="{{ $product->name }}" class="img-fluid mb-3">
                                                    </div>
                                                @else
                                                    <div id="image-preview" class="d-none">
                                                        <img src="#" alt="Preview" class="img-fluid mb-3">
                                                    </div>
                                                @endif
                                                
                                                <div class="form-group">
                                                    <input type="file" name="image" id="image" 
                                                           class="form-control @error('image') is-invalid @enderror" 
                                                           onchange="previewImage(this)">
                                                    @error('image')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                    <small class="form-text text-muted">Recommended size: 600x600px</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary me-2">
                                            <i class="fe fe-save me-2"></i>{{ isset($product) ? 'Update' : 'Create' }} Product
                                        </button>
                                        <a href="{{ route('admin.cheese-products.index') }}" class="btn btn-light">
                                            <i class="fe fe-x me-2"></i>Cancel
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::row -->
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                if (preview.classList.contains('d-none')) {
                    preview.classList.remove('d-none');
                }
                preview.querySelector('img').src = e.target.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
    @endpush
@endsection
