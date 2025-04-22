<!-- Stores Section -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Stores</h3>
            <button type="button" class="bg-indigo-600 text-white py-1 px-4 rounded hover:bg-indigo-700 transition"
                onclick="openAddStoreModal()">
                Add Store
            </button>
        </div>

        <!-- Search Bar -->
        <div class="mb-4">
            <div class="flex items-center">
                <div class="relative flex-grow">
                    <input type="text" id="store-search-input" placeholder="Search stores..."
                        value="{{ request('store_search') }}"
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
                    <select id="state-filter-select"
                        class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All States</option>
                        @foreach ($statesList ?? [] as $state)
                            <option value="{{ $state }}"
                                {{ request('store_filter') == $state ? 'selected' : '' }}>{{ $state }}</option>
                        @endforeach
                    </select>
                </div>
                <button id="clear-store-filters"
                    class="ml-2 text-sm text-gray-600 hover:text-indigo-600 {{ request('store_search') || request('store_filter') ? '' : 'hidden' }}">
                    Clear filters
                </button>
            </div>
        </div>


        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Store Name</th>
                        <th class="py-3 px-6 text-left">Location</th>
                        <th class="py-3 px-6 text-left">Contact</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @forelse($stores as $store)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-6 text-left">{{ $store->store_name }}</td>
                            <td class="py-3 px-6 text-left">{{ $store->state }}</td>
                            <td class="py-3 px-6 text-left">{{ $store->contact_number }}</td>
                            <td class="py-3 px-6 text-left">
                                <span
                                    class="bg-{{ $store->status === 'active' ? 'green' : 'red' }}-200 text-{{ $store->status === 'active' ? 'green' : 'red' }}-800 py-1 px-3 rounded-full text-xs">
                                    {{ ucfirst($store->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <a href="{{ route('admin.stores.show', $store) }}"
                                    class="text-indigo-600 hover:text-indigo-900">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-3 px-6 text-center">No stores found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $stores->appends(request()->except('page'))->links() }}
        </div>
    </div>
</div>
