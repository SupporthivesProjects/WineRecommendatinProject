<!-- Products Section -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Products</h3>
            <button type="button" class="bg-indigo-600 text-white py-1 px-4 rounded hover:bg-indigo-700 transition" onclick="openAddProductModal()">
                Add Product
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID</th>
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
                    @if(isset($products) && count($products) > 0)
                        @foreach($products as $product)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-6 text-left">{{ $product->id }}</td>
                            <td class="py-3 px-6 text-left">{{ $product->wine_name }}</td>
                            <td class="py-3 px-6 text-left">{{ ucfirst($product->type) }}</td>
                            <td class="py-3 px-6 text-left">{{ $product->winery }}</td>
                            <td class="py-3 px-6 text-left">{{ $product->country }}</td>
                            <td class="py-3 px-6 text-left">${{ number_format($product->retail_price, 2) }}</td>
                            <td class="py-3 px-6 text-left">
                                <span class="bg-{{ $product->status === 'active' ? 'green' : 'red' }}-200 text-{{ $product->status === 'active' ? 'green' : 'red' }}-800 py-1 px-3 rounded-full text-xs">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <a href="{{ route('admin.products.show', $product) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
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
    </div>
</div>
