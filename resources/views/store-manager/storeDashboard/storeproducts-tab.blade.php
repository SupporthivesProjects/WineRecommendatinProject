<x-admin-layout>
    <div class="py-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900">
                            ← Select Products for the Store
                        </a>
                    </div>

                    <!-- Product Checkboxes -->
                    <div class="px-6 py-4">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Select Products</h4>
                        <form action="" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($products as $product)
                                    @if($product->status === 'active')  <!-- Check if product is active -->
                                        <div class="flex items-center mb-2">
                                            <input type="checkbox" id="product_{{ $product->id }}" name="products[]" value="{{ $product->id }}" class="mr-2">
                                            <label for="product_{{ $product->id }}" class="text-gray-800">{{ $product->wine_name }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-4">
                                Submit
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
