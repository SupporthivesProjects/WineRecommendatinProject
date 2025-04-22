<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Product Details') }}
            </h2>
            <a href="{{ route('admin.products.edit', $product) }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition">
                Edit Product
            </a>
        </div>
    </x-slot>

    <div class="py-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <a href="{{ route('admin.products.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            ← Back to Products
                        </a>
                    </div>

                    <!-- Product Details Card -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <!-- Header with Status -->
                        <div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ $product->wine_name }}
                            </h3>
                            <span
                                class="bg-{{ $product->status === 'active' ? 'green' : 'red' }}-200 text-{{ $product->status === 'active' ? 'green' : 'red' }}-800 py-1 px-3 rounded-full text-xs">
                                {{ ucfirst($product->status) }}
                            </span>
                        </div>

                        <!-- Product Images Gallery -->
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h4 class="text-md font-medium mb-4">Product Images</h4>

                            @if ($product->images && $product->images->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <!-- Main Image (Primary) -->
                                    <div class="md:col-span-2 row-span-2">
                                        @php
                                            $primaryImage =
                                                $product->images->where('is_primary', true)->first() ??
                                                $product->images->first();
                                        @endphp
                                        <div class="w-full overflow-hidden rounded-lg shadow-md">
                                            <img src="{{ asset('storage/products/' . $primaryImage->image_path) }}"
                                                alt="{{ $product->wine_name }}" class="w-full h-full object-contain"
                                                id="main-product-image">
                                        </div>
                                    </div>

                                    <!-- Thumbnail Gallery -->
                                    @foreach ($product->images as $image)
                                        <div class="cursor-pointer hover:opacity-75 transition-opacity">
                                            <div
                                                class="w-full h-32 overflow-hidden rounded-lg shadow-sm {{ $image->is_primary ? 'ring-2 ring-indigo-500' : '' }}">
                                                <img src="{{ asset('storage/products/' . $image->image_path) }}"
                                                    alt="{{ $product->wine_name }}" class="w-full h-full object-cover"
                                                    onclick="updateMainImage('{{ asset('storage/products/' . $image->image_path) }}')">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-gray-100 p-4 rounded-lg text-center">
                                    <p class="text-gray-500">No images available for this product</p>
                                </div>
                            @endif
                        </div>

                        <!-- Product Details -->
                        <div class="px-6 py-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Left Column -->
                                <div>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-1">Wine Name</p>
                                        <p class="font-medium text-gray-900">{{ $product->wine_name }}</p>
                                    </div>

                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-1">Type</p>
                                        <p class="font-medium text-gray-900">{{ ucfirst($product->type ?? 'N/A') }}</p>
                                    </div>

                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-1">Winery</p>
                                        <p class="font-medium text-gray-900">{{ $product->winery ?? 'N/A' }}</p>
                                    </div>

                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-1">Grape Variety</p>
                                        <p class="font-medium text-gray-900">{{ $product->grape_variety ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-1">Country</p>
                                        <p class="font-medium text-gray-900">{{ $product->country ?? 'N/A' }}</p>
                                    </div>

                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-1">Region</p>
                                        <p class="font-medium text-gray-900">{{ $product->wine_sub_region ?? 'N/A' }}
                                        </p>
                                    </div>

                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-1">Retail Price</p>
                                        <p class="font-medium text-gray-900 text-lg text-indigo-600">
                                            ${{ number_format($product->retail_price, 2) }}</p>
                                    </div>

                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-1">Status</p>
                                        <p class="font-medium text-gray-900">{{ ucfirst($product->status) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions Footer -->
                        <div class="bg-gray-50 px-6 py-4 flex justify-end">
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2">
                                    Delete
                                </button>
                            </form>
                            <a href="{{ route('admin.products.edit', $product) }}"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Image Gallery -->
    <script>
        function updateMainImage(imageSrc) {
            document.getElementById('main-product-image').src = imageSrc;
        }
    </script>
</x-admin-layout>
