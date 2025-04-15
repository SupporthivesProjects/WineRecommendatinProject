<!-- Analytics Section -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Products by Type Chart -->
    <div class="bg-white p-4 rounded shadow">
        <h4 class="text-center mb-2">Wine Types</h4>
        <div class="chart-container" style="height: 200px;">
            <canvas id="storeproductsChart"></canvas>
        </div>
    </div>
    
    <!-- Grape Varieties Chart -->
    <div class="bg-white p-4 rounded shadow">
        <h4 class="text-center mb-2">Top Grape Varieties</h4>
        <div class="chart-container" style="height: 200px;">
            <canvas id="storegrapesChart"></canvas>
        </div>
    </div>
    
    <!-- Countries Chart -->
    <div class="bg-white p-4 rounded shadow">
        <h4 class="text-center mb-2">Wine Origins</h4>
        <div class="chart-container" style="height: 200px;">
            <canvas id="storecountriesChart"></canvas>
        </div>
    </div>
    
    <!-- Price Ranges Chart -->
    <div class="bg-white p-4 rounded shadow">
        <h4 class="text-center mb-2">Price Distribution</h4>
        <div class="chart-container" style="height: 200px;">
            <canvas id="storepricesChart"></canvas>
        </div>
    </div>
</div>

<!-- Users and Stores Section -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Users Chart -->
    <div class="bg-white p-4 rounded shadow">
        <h4 class="text-center mb-2">Users</h4>
        <div class="chart-container" style="height: 200px;">
            <canvas id="storeusersChart"></canvas>
        </div>
    </div>
    
    <!-- Stores Chart -->
    <div class="bg-white p-4 rounded shadow">
        <h4 class="text-center mb-2">Stores</h4>
        <div class="chart-container" style="height: 200px;">
            <canvas id="storestoresChart"></canvas>
        </div>
    </div>
</div>

<!-- Questionnaire Usage Chart -->
<div class="bg-white p-4 rounded shadow mb-6">
    <h4 class="text-center mb-2">Questionnaire Usage in Last Week</h4>
    <div class="chart-container" style="height: 300px;">
        <canvas id="storesquestionnaireChart"></canvas>
    </div>
</div>

<!-- Recent Products Table -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Recent Products</h3>
            <a href="#products" class="text-indigo-600 hover:text-indigo-900 tab-link" data-tab="products">View All</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Wine Name</th>
                        <th class="py-3 px-6 text-left">Type</th>
                        <th class="py-3 px-6 text-left">Winery</th>
                        <th class="py-3 px-6 text-left">Price</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @forelse($products as $product)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="py-3 px-6 text-left">{{ $product->id }}</td>
                        <td class="py-3 px-6 text-left">{{ $product->wine_name }}</td>
                        <td class="py-3 px-6 text-left">{{ ucfirst($product->type) }}</td>
                        <td class="py-3 px-6 text-left">{{ $product->winery }}</td>
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
                    @empty
                    <tr>
                        <td colspan="7" class="py-3 px-6 text-center">No products found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
