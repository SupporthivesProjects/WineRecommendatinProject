<!-- Users Section -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Users</h3>
            <button type="button" class="bg-indigo-600 text-white py-1 px-4 rounded hover:bg-indigo-700 transition" onclick="openAddUserModal()">
                Add User
            </button>
        </div>

        <!-- Search Bar -->
        <div class="mb-4">
            <div class="flex items-center">
                <div class="relative flex-grow">
                    <input type="text" id="user-search-input" placeholder="Search users by name or email..."
                        value="{{ request('user_search') }}"
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
                    <select id="role-filter-select"
                        class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role_filter') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="store_manager" {{ request('role_filter') == 'store_manager' ? 'selected' : '' }}>
                            Store Manager</option>
                        <option value="customer" {{ request('role_filter') == 'customer' ? 'selected' : '' }}>Customer
                        </option>
                    </select>
                </div>
                <button id="clear-user-filters"
                    class="ml-2 text-sm text-gray-600 hover:text-indigo-600 {{ request('user_search') || request('role_filter') ? '' : 'hidden' }}">
                    Clear filters
                </button>
            </div>
        </div>

        <!-- Add this JavaScript at the bottom of the file -->

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Name</th>
                        <th class="py-3 px-6 text-left">Contact</th>
                        <th class="py-3 px-6 text-left">Email</th>
                        <th class="py-3 px-6 text-left">Role</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @forelse($users as $user)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-6 text-left">{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td class="py-3 px-6 text-left">{{ $user->mobile }}</td>
                            <td class="py-3 px-6 text-left">{{ $user->email }}</td>
                            <td class="py-3 px-6 text-left">{{ ucfirst($user->role) }}</td>
                            <td class="py-3 px-6 text-center">
                                <a href="{{ route('admin.users.show', $user) }}"
                                    class="text-indigo-600 hover:text-indigo-900">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-3 px-6 text-center">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $users->appends(request()->except('page'))->links() }}
        </div>
    </div>
</div>
