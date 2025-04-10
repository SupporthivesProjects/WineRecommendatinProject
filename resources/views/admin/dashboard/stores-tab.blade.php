<!-- Stores Section -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Stores</h3>
            <button type="button" class="bg-indigo-600 text-white py-1 px-4 rounded hover:bg-indigo-700 transition" onclick="openAddStoreModal()">
                Add Store
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID</th>
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
                        <td class="py-3 px-6 text-left">{{ $store->id }}</td>
                        <td class="py-3 px-6 text-left">{{ $store->store_name }}</td>
                        <td class="py-3 px-6 text-left">{{ $store->state }}</td>
                        <td class="py-3 px-6 text-left">{{ $store->contact_number }}</td>
                        <td class="py-3 px-6 text-left">
                            <span class="bg-{{ $store->status === 'active' ? 'green' : 'red' }}-200 text-{{ $store->status === 'active' ? 'green' : 'red' }}-800 py-1 px-3 rounded-full text-xs">
                                {{ ucfirst($store->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <a href="{{ route('admin.stores.show', $store) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
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
    </div>
</div>
