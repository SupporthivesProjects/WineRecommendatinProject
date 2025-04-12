<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Details') }}
            </h2>
            {{-- <a href="{{ route('admin.users.edit', $user) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition">
                Edit User
            </a> --}}
        </div>
    </x-slot>

    <div class="py-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            ← Back to Users
                        </a>
                    </div>

                    <!-- User Details Card -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <!-- Header with Status -->
                        <div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ $user->first_name }} {{ $user->last_name }}
                            </h3>
                            <span class="bg-{{ $user->status === 'active' ? 'green' : 'red' }}-200 text-{{ $user->status === 'active' ? 'green' : 'red' }}-800 py-1 px-3 rounded-full text-xs">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>

                        <!-- User Details -->
                        <div class="px-6 py-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Left Column -->
                                <div>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-1">First Name</p>
                                        <p class="font-medium text-gray-900">{{ $user->first_name }}</p>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-1">Last Name</p>
                                        <p class="font-medium text-gray-900">{{ $user->last_name }}</p>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-1">Email</p>
                                        <p class="font-medium text-gray-900">{{ $user->email }}</p>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-1">Mobile</p>
                                        <p class="font-medium text-gray-900">{{ $user->mobile ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                
                                <!-- Right Column -->
                                <div>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-1">Role</p>
                                        <p class="font-medium text-gray-900">
                                            <span class="bg-blue-200 text-blue-800 py-1 px-3 rounded-full text-xs">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </p>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-1">Store</p>
                                        <p class="font-medium text-gray-900">
                                            @if($user->store)
                                                <a href="{{ route('admin.stores.show', $user->store) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    {{ $user->store->store_name }}
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-1">Status</p>
                                        <div class="flex items-center">
                                            <p class="font-medium text-gray-900 mr-3">{{ ucfirst($user->status) }}</p>
                                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="bg-{{ $user->status === 'active' ? 'red' : 'indigo' }}-600 hover:bg-{{ $user->status === 'active' ? 'red' : 'green' }}-700 text-white text-xs py-1 px-2 rounded focus:outline-none focus:shadow-outline">
                                                    {{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-1">Created</p>
                                        <p class="font-medium text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions Footer -->
                        <div class="bg-gray-50 px-6 py-4 flex justify-end">
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2">
                                    Delete
                                </button>
                            </form>
                            {{-- <a href="{{ route('admin.users.edit', $user) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Edit
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>