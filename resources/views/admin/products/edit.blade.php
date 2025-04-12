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
                        <a href="{{ route('admin.products.show', $product) }}" class="text-indigo-600 hover:text-indigo-900">
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

                    <form action="{{ route('admin.products.update', $product) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Product Information</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Left Column -->
                                    <div>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="wine_name">Wine Name</label>
                                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="wine_name" name="wine_name" type="text" value="{{ old('wine_name', $product->wine_name) }}" required>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="type">Type</label>
                                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="type" name="type" required>
                                                <option value="">Select Type</option>
                                                <option value="red" {{ old('type', $product->type) == 'red' ? 'selected' : '' }}>Red Wine</option>
                                                <option value="white" {{ old('type', $product->type) == 'white' ? 'selected' : '' }}>White Wine</option>
                                                <option value="rose" {{ old('type', $product->type) == 'rose' ? 'selected' : '' }}>Rosé</option>
                                                <option value="sparkling" {{ old('type', $product->type) == 'sparkling' ? 'selected' : '' }}>Sparkling</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="winery">Winery</label>
                                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="winery" name="winery" type="text" value="{{ old('winery', $product->winery) }}" required>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="grape_variety">Grape Variety</label>
                                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="grape_variety" name="grape_variety" type="text" value="{{ old('grape_variety', $product->grape_variety) }}">
                                        </div>
                                    </div>
                                    
                                    <!-- Right Column -->
                                    <div>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="country">Country</label>
                                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="country" name="country" type="text" value="{{ old('country', $product->country) }}">
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="wine_sub_region">Region</label>
                                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="wine_sub_region" name="wine_sub_region" type="text" value="{{ old('wine_sub_region', $product->wine_sub_region) }}">
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="retail_price">Retail Price ($)</label>
                                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="retail_price" name="retail_price" type="number" step="0.01" value="{{ old('retail_price', $product->retail_price) }}" required>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="status">Status</label>
                                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="status" name="status" required>
                                                <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 px-6 py-4 flex items-center justify-end space-x-3 border-t border-gray-200">
                                <a href="{{ route('admin.products.show', $product) }}" class="bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-gray-50 transition">
                                    Cancel
                                </a>
                                <button class="bg-indigo-600 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-indigo-700 transition" type="submit">
                                    Update Product
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>