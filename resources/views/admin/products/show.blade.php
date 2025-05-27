    @extends('layouts.bootdashboard')
    @section('admindashboardcontent')
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Breadcrumb -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb mb-4">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Product Details</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->wine_name }}</li>
                    </ol>
                </div>
                <div>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-icon-text">
                        <i class="fe fe-arrow-left me-2"></i> Back to List
                    </a>
                </div>
            </div>

            <!-- Product Card -->
            <div class="card shadow-sm border-0 p-3">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 text-primary">{{ $product->wine_name }}</h3>
                    <span class="badge bg-{{ $product->status === 'active' ? 'success' : 'danger' }} text-uppercase px-3 py-2">
                        {{ ucfirst($product->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <!-- Product Images -->
                    <h5 class="mb-3 text-dark">Product Images</h5>
                    @if ($product->images && $product->images->count() > 0)
                        <div class="row">
                            @php
                                $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
                            @endphp
                            <div class="col-md-6 mb-3">
                                <div class="border p-2 rounded bg-light">
                                    <img id="main-product-image" src="{{ asset('storage/products/' . $primaryImage->image_path) }}" class="img-fluid rounded w-100" alt="{{ $product->wine_name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-2">
                                    @foreach ($product->images as $image)
                                        <div class="col-4">
                                            <img src="{{ asset('storage/products/' . $image->image_path) }}" class="img-thumbnail {{ $image->is_primary ? 'border border-3 border-primary' : '' }}" style="cursor:pointer;" onclick="updateMainImage('{{ asset('storage/products/' . $image->image_path) }}')">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-muted">No images available for this product.</p>
                    @endif

                    <!-- Additional Image Fields (image1 - image4) -->
                    @php $additionalImages = ['image1', 'image2', 'image3', 'image4']; @endphp
                    <div class="row mt-4">
                        @foreach ($additionalImages as $imgField)
                            @if (!empty($product->$imgField))
                                <div class="col-md-3 mb-3">
                                    <div class="border p-2 rounded bg-light">
                                        <img src="{{ asset('storage/products/' . $product->$imgField) }}" class="img-fluid rounded" alt="{{ $imgField }}">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Product Info Grid -->
                    <h5 class="mt-5 mb-3 text-dark">Product Information</h5>
                    <div class="row">
                        @foreach ($product->getAttributes() as $field => $value)
                            @if (!in_array($field, ['id', 'created_at', 'updated_at', 'image1', 'image2', 'image3', 'image4']) && !is_array($value))
                                <div class="col-md-6 mb-3">
                                    <div class="border p-3 rounded bg-light h-100">
                                        <strong class="d-block text-secondary">{{ ucwords(str_replace('_', ' ', $field)) }}</strong>
                                        <div class="text-dark">{{ $value ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="card-footer bg-white text-end">
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger me-2">Delete</button>
                    </form>
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">Edit</a>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    @push('scripts')
    <script>
        function updateMainImage(imageSrc) {
            document.getElementById('main-product-image').src = imageSrc;
        }
    </script>
    @endpush
    @endsection
