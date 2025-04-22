<!-- Products Section -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Products</h3>
            <button type="button" class="bg-indigo-600 text-white py-1 px-4 rounded hover:bg-indigo-700 transition"
                onclick="openAddProductModal()">
                Add Product
            </button>
        </div>

        <!-- Search Bar -->
        <div class="mb-4">
            <div class="flex items-center">
                <div class="relative flex-grow">
                    <input type="text" id="product-search-input" placeholder="Search products..."
                        value="{{ request('product_search') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <div class="absolute right-0 top-0 mt-2 mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                <div class="ml-2">
                    <select id="type-filter-select"
                        class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Types</option>
                        <option value="red" {{ request('product_filter') == 'red' ? 'selected' : '' }}>Red Wine
                        </option>
                        <option value="white" {{ request('product_filter') == 'white' ? 'selected' : '' }}>White Wine
                        </option>
                        <option value="rose" {{ request('product_filter') == 'rose' ? 'selected' : '' }}>Rosé</option>
                        <option value="sparkling" {{ request('product_filter') == 'sparkling' ? 'selected' : '' }}>
                            Sparkling</option>
                    </select>
                </div>
                <button id="clear-product-filters"
                    class="ml-2 text-sm text-gray-600 hover:text-indigo-600 {{ request('product_search') || request('product_filter') ? '' : 'hidden' }}">
                    Clear filters
                </button>
            </div>
        </div>



        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Wine Name</th>
                        <th class="py-3 px-6 text-left">Type</th>
                        <th class="py-3 px-6 text-left">Winery</th>
                        <th class="py-3 px-6 text-left">Country</th>
                        <th class="py-3 px-6 text-left">Price</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @if (isset($products) && count($products) > 0)
                        @foreach ($products as $product)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6 text-left">{{ $product->wine_name }}</td>
                                <td class="py-3 px-6 text-left">{{ ucfirst($product->type) }}</td>
                                <td class="py-3 px-6 text-left">{{ $product->winery }}</td>
                                <td class="py-3 px-6 text-left">{{ $product->country }}</td>
                                <td class="py-3 px-6 text-left">${{ number_format($product->retail_price, 2) }}</td>
                                <td class="py-3 px-6 text-left">
                                    <span
                                        class="bg-{{ $product->status === 'active' ? 'green' : 'red' }}-200 text-{{ $product->status === 'active' ? 'green' : 'red' }}-800 py-1 px-3 rounded-full text-xs">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <a href="{{ route('admin.products.show', $product) }}"
                                        class="text-indigo-600 hover:text-indigo-900">View</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="py-3 px-6 text-center">No products found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-4">
            @if (isset($products) && $products->hasPages())
                {{ $products->appends(request()->except('page'))->links() }}
            @endif
        </div>
    </div>
</div>
