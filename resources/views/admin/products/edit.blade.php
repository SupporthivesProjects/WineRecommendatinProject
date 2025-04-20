<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <a href="{{ route('admin.products.show', $product) }}"
                            class="text-indigo-600 hover:text-indigo-900">
                            ← Back to Product Details
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.update', $product) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Product Information</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Left Column -->
                                    <div>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2"
                                                for="wine_name">Wine Name</label>
                                            <input
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                id="wine_name" name="wine_name" type="text"
                                                value="{{ old('wine_name', $product->wine_name) }}" required>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2"
                                                for="type">Type</label>
                                            <select
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                id="type" name="type" required>
                                                <option value="">Select Type</option>
                                                <option value="red"
                                                    {{ old('type', $product->type) == 'red' ? 'selected' : '' }}>Red
                                                    Wine</option>
                                                <option value="white"
                                                    {{ old('type', $product->type) == 'white' ? 'selected' : '' }}>White
                                                    Wine</option>
                                                <option value="rose"
                                                    {{ old('type', $product->type) == 'rose' ? 'selected' : '' }}>Rosé
                                                </option>
                                                <option value="sparkling"
                                                    {{ old('type', $product->type) == 'sparkling' ? 'selected' : '' }}>
                                                    Sparkling</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2"
                                                for="winery">Winery</label>
                                            <input
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                id="winery" name="winery" type="text"
                                                value="{{ old('winery', $product->winery) }}" required>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2"
                                                for="grape_variety">Grape Variety</label>
                                            <input
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                id="grape_variety" name="grape_variety" type="text"
                                                value="{{ old('grape_variety', $product->grape_variety) }}">
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2"
                                                for="country">Country</label>
                                            <input
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                id="country" name="country" type="text"
                                                value="{{ old('country', $product->country) }}">
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2"
                                                for="wine_sub_region">Region</label>
                                            <input
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                id="wine_sub_region" name="wine_sub_region" type="text"
                                                value="{{ old('wine_sub_region', $product->wine_sub_region) }}">
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2"
                                                for="retail_price">Retail Price ($)</label>
                                            <input
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                id="retail_price" name="retail_price" type="number" step="0.01"
                                                value="{{ old('retail_price', $product->retail_price) }}" required>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2"
                                                for="status">Status</label>
                                            <select
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                id="status" name="status" required>
                                                <option value="active"
                                                    {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="inactive"
                                                    {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>
                                                    Inactive</option>
                                            </select>
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
                                                        <input id="product_images" name="product_images[]"
                                                            type="file" class="sr-only" multiple accept="image/*"
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

                            <div
                                class="bg-gray-50 px-6 py-4 flex items-center justify-end space-x-3 border-t border-gray-200">
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

    <!-- JavaScript for Image Management -->
    <script>
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
</x-admin-layout>
