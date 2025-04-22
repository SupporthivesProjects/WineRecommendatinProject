<x-app-layout>
    <style>
        /* Sidebar styles */
        .dashboard-container {
            display: flex;
            min-height: calc(100vh - 128px);
            /* Adjusted for both main nav and header */
        }

        .sidebar {
            width: 250px;
            background-color: white;
            border-right: 1px solid #e5e7eb;
            position: fixed;
            top: 128px;
            /* Position below both headers (64px + 64px) */
            height: calc(100vh - 128px);
            z-index: 10;
            overflow-y: auto;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #4B5563;
            transition: all 0.2s;
        }

        .sidebar-link:hover {
            background-color: #F3F4F6;
        }

        .sidebar-link.active {
            background-color: #EEF2FF;
            color: #4F46E5;
            border-left: 3px solid #4F46E5;
        }

        .sidebar-icon {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.75rem;
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 1.5rem;
            margin-top: 60px;
            /* Adjusted for both headers (64px + 64px) */
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
                top: 128px;
                /* Keep consistent with desktop */
            }

            .main-content {
                margin-left: 0;
                margin-top: 60px;
                /* Keep consistent with desktop */
            }

            .sidebar.open {
                width: 250px;
            }
        }
    </style>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('WineRecommender Admin Panel') }}
            </h2>

            <button id="mobile-menu-button"
                class="md:hidden p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>
    </x-slot>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <x-sidebar />


        <!-- Main Content -->
        <div class="main-content">
            <!-- Tab content containers -->
            <div id="dashboard" class="tab-content">
                @include('admin.dashboard.dashboard-tab')
            </div>

            <div id="products" class="tab-content hidden">
                @include('admin.dashboard.products-tab')
            </div>

            <div id="stores" class="tab-content hidden">
                @include('admin.dashboard.stores-tab')
            </div>

            <div id="users" class="tab-content hidden">
                @include('admin.dashboard.users-tab')
            </div>

            <div id="questionnaires" class="tab-content hidden">
                @include('admin.dashboard.questionnaires-tab')
            </div>

            <div id="settings" class="tab-content hidden">
                @include('admin.dashboard.settings-tab')
            </div>
        </div>
    </div>

    <!-- Add Store Modal -->
    <div id="addStoreModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Add Store</h3>
                <div class="mt-2 px-7 py-3">
                    <form action="{{ route('admin.stores.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="store_name">Store
                                Name</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="store_name" name="store_name" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="gst_vat">GST/VAT</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="gst_vat" name="gst_vat" type="text">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="contact_number">Contact</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="contact_number" name="contact_number" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="group">Group</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="group" name="group" type="text">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="address">Address</label>
                            <textarea
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="address" name="address" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="state">State</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="state" name="state" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="email">Email
                                ID</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="email" name="email" type="email" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="business_type">Business Type</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="business_type" name="business_type" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="licence_type">License Type</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="licence_type" name="licence_type" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="license_number">License Number</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="license_number" name="license_number" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="status">Status</label>
                            <select
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button
                                class="bg-gray-500 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-gray-600"
                                type="button" onclick="closeAddStoreModal()">
                                Cancel
                            </button>
                            <button
                                class="bg-indigo-600 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-indigo-700"
                                type="submit">
                                Add Store
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Add New User</h3>
                <div class="mt-2 px-7 py-3">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        @if ($errors->any())
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul class="list-disc pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="first_name">First
                                Name</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('first_name') border-red-500 @enderror"
                                id="first_name" name="first_name" type="text" value="{{ old('first_name') }}"
                                required>
                            @error('first_name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="last_name">Last
                                Name</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('last_name') border-red-500 @enderror"
                                id="last_name" name="last_name" type="text" value="{{ old('last_name') }}"
                                required>
                            @error('last_name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="mobile">Mobile
                                Number</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('mobile') border-red-500 @enderror"
                                id="mobile" name="mobile" type="text" value="{{ old('mobile') }}" required>
                            @error('mobile')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="email">Email</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                                id="email" name="email" type="email" value="{{ old('email') }}" required>
                            @error('email')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="password">Password</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror"
                                id="password" name="password" type="password" required>
                            @error('password')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="role">Role</label>
                            <select
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('role') border-red-500 @enderror"
                                id="role" name="role" required>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="store_manager" {{ old('role') == 'store_manager' ? 'selected' : '' }}>
                                    Store Manager</option>
                                <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer
                                </option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4 store-field {{ old('role') == 'store_manager' ? '' : 'hidden' }}">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="store_id">Assign
                                Store</label>
                            <select
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('store_id') border-red-500 @enderror"
                                id="store_id" name="store_id">
                                <option value="">Select Store</option>
                                @foreach ($stores as $store)
                                    <option value="{{ $store->id }}"
                                        {{ old('store_id') == $store->id ? 'selected' : '' }}>{{ $store->store_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('store_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="status">Status</label>
                            <select
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('status') border-red-500 @enderror"
                                id="status" name="status" required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button
                                class="bg-gray-500 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-gray-600"
                                type="button" onclick="closeAddUserModal()">
                                Cancel
                            </button>
                            <button
                                class="bg-indigo-600 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-indigo-700"
                                type="submit">
                                Add User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div id="addProductModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Add Product</h3>
                <div class="mt-2 px-7 py-3">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="wine_name">Wine
                                Name</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="wine_name" name="wine_name" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="type">Type</label>
                            <select
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="red">Red Wine</option>
                                <option value="white">White Wine</option>
                                <option value="rose">Rosé</option>
                                <option value="sparkling">Sparkling</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="winery">Winery</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="winery" name="winery" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="grape_variety">Grape Variety</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="grape_variety" name="grape_variety" type="text">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="country">Country</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="country" name="country" type="text">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="region">Region</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="region" name="region" type="text">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="retail_price">Retail Price</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="retail_price" name="retail_price" type="number" step="0.01" required>
                        </div>

                        <!-- New Multiple Image Upload Section -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left">Product Images</label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="product_images"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                            <span>Upload images</span>
                                            <input id="product_images" name="product_images[]" type="file"
                                                class="sr-only" multiple accept="image/*"
                                                onchange="previewImages(this)">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                </div>
                            </div>

                            <!-- Image Preview Container -->
                            <div id="image-preview-container" class="mt-2 grid grid-cols-2 gap-2"></div>

                            <!-- Primary Image Selection -->
                            <div id="primary-image-selection" class="mt-2 hidden">
                                <label class="block text-gray-700 text-sm font-bold mb-2 text-left">Select Primary
                                    Image</label>
                                <select name="primary_image" id="primary_image"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Select Primary Image</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left"
                                for="status">Status</label>
                            <select
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button
                                class="bg-gray-500 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-gray-600"
                                type="button" onclick="closeAddProductModal()">
                                Cancel
                            </button>
                            <button
                                class="bg-indigo-600 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-indigo-700"
                                type="submit">
                                Add Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- JavaScript for Charts and Modal Functionality -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Tab persistence using localStorage
        document.addEventListener('DOMContentLoaded', function() {
            // Get active tab from localStorage or default to dashboard
            const activeTab = localStorage.getItem('activeTab') || 'dashboard';

            // Activate the tab
            activateTab(activeTab);

            // Mobile menu toggle
            document.getElementById('mobile-menu-button').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('open');
            });

            // Tab navigation
            document.querySelectorAll('.sidebar-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tabId = this.getAttribute('data-tab');
                    activateTab(tabId);

                    // Save active tab to localStorage
                    localStorage.setItem('activeTab', tabId);
                });
            });

            // Tab links within content
            document.querySelectorAll('.tab-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tabId = this.getAttribute('data-tab');
                    activateTab(tabId);

                    // Save active tab to localStorage
                    localStorage.setItem('activeTab', tabId);
                });
            });

            // Role-based fields in user form
            if (document.getElementById('role')) {
                document.getElementById('role').addEventListener('change', function() {
                    if (this.value === 'store_manager') {
                        document.querySelector('.store-field').classList.remove('hidden');
                    } else {
                        document.querySelector('.store-field').classList.add('hidden');
                    }
                });
            }

            // Initialize Charts
            initializeCharts();
        });

        // Function to activate a tab
        function activateTab(tabId) {
            // Remove active class from all links
            document.querySelectorAll('.sidebar-link').forEach(link => {
                link.classList.remove('active');
            });

            // Add active class to selected link
            const activeLink = document.querySelector(`.sidebar-link[data-tab="${tabId}"]`);
            if (activeLink) {
                activeLink.classList.add('active');
            }

            // Hide all tab content
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });

            // Show selected tab content
            const activeContent = document.getElementById(tabId);
            if (activeContent) {
                activeContent.classList.remove('hidden');
            }
        }

        // Modal Functions
        function openAddStoreModal() {
            document.getElementById('addStoreModal').classList.remove('hidden');
        }

        function closeAddStoreModal() {
            document.getElementById('addStoreModal').classList.add('hidden');
        }

        function openAddUserModal() {
            document.getElementById('addUserModal').classList.remove('hidden');
        }

        function closeAddUserModal() {
            document.getElementById('addUserModal').classList.add('hidden');
        }

        function openAddProductModal() {
            document.getElementById('addProductModal').classList.remove('hidden');
        }

        function closeAddProductModal() {
            document.getElementById('addProductModal').classList.add('hidden');
        }

        // Initialize Charts
        function initializeCharts() {
            // Products by Type Pie Chart
            const productsTypeCtx = document.getElementById('productsChart');
            if (productsTypeCtx) {
                const productsTypeChart = new Chart(productsTypeCtx.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: {!! json_encode($productTypeLabels) !!},
                        datasets: [{
                            data: {!! json_encode($productTypeData) !!},
                            backgroundColor: [
                                '#EF4444', // Red
                                '#F59E0B', // Amber
                                '#EC4899', // Pink
                                '#3B82F6' // Blue
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Products by Wine Type'
                            }
                        }
                    }
                });
            }

            // Add a new chart for grape varieties
            const grapesCtx = document.getElementById('grapesChart');
            if (grapesCtx) {
                const grapesChart = new Chart(grapesCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($grapeLabels ?? ['Cabernet Sauvignon', 'Chardonnay', 'Merlot', 'Pinot Noir', 'Sauvignon Blanc']) !!},
                        datasets: [{
                            label: 'Number of Wines',
                            data: {!! json_encode($grapeData ?? [0, 0, 0, 0, 0]) !!},
                            backgroundColor: '#8B5CF6',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Top Grape Varieties'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            // Add a new chart for countries
            const countriesCtx = document.getElementById('countriesChart');
            if (countriesCtx) {
                const countriesChart = new Chart(countriesCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($countryLabels) !!},
                        datasets: [{
                            data: {!! json_encode($countryData ?? [0, 0, 0, 0, 0]) !!},
                            backgroundColor: [
                                '#10B981', // Green
                                '#3B82F6', // Blue
                                '#F59E0B', // Amber
                                '#8B5CF6', // Purple
                                '#EC4899' // Pink
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Wines by Country'
                            }
                        }
                    }
                });
            }

            // Add a new chart for price ranges
            const pricesCtx = document.getElementById('pricesChart');
            if (pricesCtx) {
                const pricesChart = new Chart(pricesCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($priceLabels ?? ['Under $15', '$15-$30', '$30-$50', '$50-$100', 'Over $100']) !!},
                        datasets: [{
                            label: 'Number of Wines',
                            data: {!! json_encode($priceData ?? [0, 0, 0, 0, 0]) !!},
                            backgroundColor: '#F97316',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Wines by Price Range'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            // Users Pie Chart
            const usersCtx = document.getElementById('usersChart');
            if (usersCtx) {
                const usersChart = new Chart(usersCtx.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: {!! json_encode($userLabels ?? ['Admins', 'Store Managers', 'Customers']) !!},
                        datasets: [{
                            data: {!! json_encode($userData ?? [0, 0, 0]) !!},
                            backgroundColor: [
                                '#10B981', // Green
                                '#6366F1', // Indigo
                                '#F97316' // Orange
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    }
                });
            }

            // Stores Pie Chart
            const storesCtx = document.getElementById('storesChart');
            if (storesCtx) {
                const storesChart = new Chart(storesCtx.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: {!! json_encode($storeLabels ?? ['Active', 'Inactive']) !!},
                        datasets: [{
                            data: {!! json_encode($storeData ?? [0, 0]) !!},
                            backgroundColor: [
                                '#10B981', // Green
                                '#EF4444' // Red
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    }
                });
            }

            // Questionnaire Usage Bar Chart
            const questionnaireCtx = document.getElementById('questionnaireChart');
            if (questionnaireCtx) {
                const questionnaireChart = new Chart(questionnaireCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($dates ?? ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5']) !!},
                        datasets: [{
                                label: 'Admin',
                                data: {!! json_encode($adminData ?? [0, 0, 0, 0, 0]) !!},
                                backgroundColor: '#3B82F6', // Blue
                            },
                            {
                                label: 'Admin1',
                                data: {!! json_encode($admin1Data ?? [0, 0, 0, 0, 0]) !!},
                                backgroundColor: '#10B981', // Green
                            },
                            {
                                label: 'Admin2',
                                data: {!! json_encode($admin2Data ?? [0, 0, 0, 0, 0]) !!},
                                backgroundColor: '#F97316', // Orange
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }

        function previewImages(input) {
            const previewContainer = document.getElementById('image-preview-container');
            const primaryImageSelect = document.getElementById('primary_image');
            const primaryImageSection = document.getElementById('primary-image-selection');

            // Clear previous previews
            previewContainer.innerHTML = '';
            primaryImageSelect.innerHTML = '<option value="">Select Primary Image</option>';

            if (input.files && input.files.length > 0) {
                primaryImageSection.classList.remove('hidden');

                for (let i = 0; i < input.files.length; i++) {
                    const file = input.files[i];
                    const reader = new FileReader();

                    // Create preview element
                    const previewWrapper = document.createElement('div');
                    previewWrapper.className = 'relative border rounded p-1';

                    const previewImage = document.createElement('img');
                    previewImage.className = 'w-full h-24 object-cover';

                    reader.onload = function(e) {
                        previewImage.src = e.target.result;

                        // Add option to primary image dropdown
                        const option = document.createElement('option');
                        option.value = i;
                        option.textContent = `Image ${i + 1}`;
                        primaryImageSelect.appendChild(option);

                        // Set first image as primary by default
                        if (i === 0) {
                            option.selected = true;
                        }
                    }

                    reader.readAsDataURL(file);

                    // Create remove button
                    const removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.className =
                        'absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center';
                    removeButton.textContent = 'x';
                    removeButton.onclick = function() {
                        previewWrapper.remove();

                        // Remove from primary image dropdown
                        const options = primaryImageSelect.querySelectorAll('option');
                        for (let opt of options) {
                            if (opt.value === i.toString()) {
                                opt.remove();
                                break;
                            }
                        }

                        // Hide primary image section if no images left
                        if (previewContainer.children.length === 0) {
                            primaryImageSection.classList.add('hidden');
                        }
                    };

                    previewWrapper.appendChild(previewImage);
                    previewWrapper.appendChild(removeButton);
                    previewContainer.appendChild(previewWrapper);
                }
            } else {
                primaryImageSection.classList.add('hidden');
            }
        }

        // Updated unified filtering script for dashboard.blade.php
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize filtering for the active tab
            initializeTabFiltering();

            // Set up filtering when tabs change
            document.querySelectorAll('.sidebar-link, .tab-link').forEach(link => {
                link.addEventListener('click', function() {
                    // Allow time for the tab content to be displayed
                    setTimeout(initializeTabFiltering, 100);
                });
            });

            function initializeTabFiltering() {
                // Determine which tab is active
                const activeTab = document.querySelector('.tab-content:not(.hidden)').id;

                // Set up filtering based on active tab
                switch (activeTab) {
                    case 'users':
                        setupFiltering('user-search-input', 'role-filter-select', 'clear-user-filters',
                            filterUsers);
                        break;
                    case 'products':
                        setupFiltering('product-search-input', 'type-filter-select', 'clear-product-filters',
                            filterProducts);
                        break;
                    case 'stores':
                        setupFiltering('store-search-input', 'state-filter-select', 'clear-store-filters',
                            filterStores);
                        break;
                }
            }

            function setupFiltering(searchInputId, filterSelectId, clearBtnId, filterFunction) {
                const searchInput = document.getElementById(searchInputId);
                const filterSelect = document.getElementById(filterSelectId);
                const clearFiltersBtn = document.getElementById(clearBtnId);

                if (!searchInput || !filterSelect || !clearFiltersBtn) return;

                // Add event listeners
                searchInput.addEventListener('input', filterFunction);
                filterSelect.addEventListener('change', filterFunction);

                // Clear filters button
                clearFiltersBtn.addEventListener('click', function() {
                    searchInput.value = '';
                    filterSelect.value = '';
                    filterFunction();
                });

                // Initial filtering
                filterFunction();
            }

            // Users filtering function
            function filterUsers() {
                const searchInput = document.getElementById('user-search-input');
                const roleFilter = document.getElementById('role-filter-select');
                const clearFiltersBtn = document.getElementById('clear-user-filters');
                const userRows = document.querySelectorAll('#users tbody tr');

                if (!searchInput || !roleFilter || !userRows.length) return;

                const searchTerm = searchInput.value.toLowerCase();
                const roleValue = roleFilter.value.toLowerCase();
                let hasVisibleRows = false;

                userRows.forEach(row => {
                    // Skip the "No users found" row if it exists
                    if (row.cells.length === 1 && row.cells[0].colSpan > 1) {
                        row.classList.add('hidden');
                        return;
                    }

                    // Get cell values - adjust indexes based on your table structure
                    const name = row.cells[0].textContent.toLowerCase();
                    const contact = row.cells[1].textContent.toLowerCase();
                    const email = row.cells[2].textContent.toLowerCase();
                    const role = row.cells[3].textContent.toLowerCase();

                    const matchesSearch = searchTerm === '' ||
                        name.includes(searchTerm) ||
                        contact.includes(searchTerm) ||
                        email.includes(searchTerm);

                    const matchesRole = roleValue === '' || role.includes(roleValue);

                    if (matchesSearch && matchesRole) {
                        row.classList.remove('hidden');
                        hasVisibleRows = true;
                    } else {
                        row.classList.add('hidden');
                    }
                });

                // Show "No users found" message if no matching rows
                const tbody = document.querySelector('#users tbody');
                if (!tbody) return;

                const noResultsRow = tbody.querySelector('tr.no-results');
                if (!hasVisibleRows) {
                    if (!noResultsRow) {
                        const newRow = document.createElement('tr');
                        newRow.className = 'no-results';
                        newRow.innerHTML =
                            '<td colspan="6" class="py-3 px-6 text-center">No matching users found</td>';
                        tbody.appendChild(newRow);
                    } else {
                        noResultsRow.classList.remove('hidden');
                    }
                } else if (noResultsRow) {
                    noResultsRow.classList.add('hidden');
                }

                // Update clear filters button visibility
                if (searchTerm || roleValue) {
                    clearFiltersBtn.classList.remove('hidden');
                } else {
                    clearFiltersBtn.classList.add('hidden');
                }
            }

            // Products filtering function
            function filterProducts() {
                const searchInput = document.getElementById('product-search-input');
                const typeFilter = document.getElementById('type-filter-select');
                const clearFiltersBtn = document.getElementById('clear-product-filters');
                const productRows = document.querySelectorAll('#products tbody tr');

                if (!searchInput || !typeFilter || !productRows.length) return;

                const searchTerm = searchInput.value.toLowerCase();
                const typeValue = typeFilter.value.toLowerCase();
                let hasVisibleRows = false;

                productRows.forEach(row => {
                    // Skip the "No products found" row if it exists
                    if (row.cells.length === 1 && row.cells[0].colSpan > 1) {
                        row.classList.add('hidden');
                        return;
                    }

                    // Get cell values - adjust indexes based on your table structure
                    const productName = row.cells[0].textContent.toLowerCase();
                    const type = row.cells[1].textContent.toLowerCase();
                    const winery = row.cells[2].textContent.toLowerCase();
                    const country = row.cells[3].textContent.toLowerCase();

                    const matchesSearch = searchTerm === '' ||
                        productName.includes(searchTerm) ||
                        winery.includes(searchTerm) ||
                        country.includes(searchTerm);

                    const matchesType = typeValue === '' || type.toLowerCase().includes(typeValue);

                    if (matchesSearch && matchesType) {
                        row.classList.remove('hidden');
                        hasVisibleRows = true;
                    } else {
                        row.classList.add('hidden');
                    }
                });

                // Show "No products found" message if no matching rows
                const tbody = document.querySelector('#products tbody');
                if (!tbody) return;

                const noResultsRow = tbody.querySelector('tr.no-results');
                if (!hasVisibleRows) {
                    if (!noResultsRow) {
                        const newRow = document.createElement('tr');
                        newRow.className = 'no-results';
                        newRow.innerHTML =
                            '<td colspan="8" class="py-3 px-6 text-center">No matching products found</td>';
                        tbody.appendChild(newRow);
                    } else {
                        noResultsRow.classList.remove('hidden');
                    }
                } else if (noResultsRow) {
                    noResultsRow.classList.add('hidden');
                }

                // Update clear filters button visibility
                if (searchTerm || typeValue) {
                    clearFiltersBtn.classList.remove('hidden');
                } else {
                    clearFiltersBtn.classList.add('hidden');
                }
            }

            // Stores filtering function
            function filterStores() {
                const searchInput = document.getElementById('store-search-input');
                const stateFilter = document.getElementById('state-filter-select');
                const clearFiltersBtn = document.getElementById('clear-store-filters');
                const storeRows = document.querySelectorAll('#stores tbody tr');

                if (!searchInput || !stateFilter || !storeRows.length) return;

                const searchTerm = searchInput.value.toLowerCase();
                const stateValue = stateFilter.value.toLowerCase();
                let hasVisibleRows = false;

                storeRows.forEach(row => {
                    // Skip the "No stores found" row if it exists
                    if (row.cells.length === 1 && row.cells[0].colSpan > 1) {
                        row.classList.add('hidden');
                        return;
                    }

                    // Get cell values - adjust indexes based on your table structure
                    const storeName = row.cells[0].textContent.toLowerCase();
                    const location = row.cells[1].textContent.toLowerCase();
                    const contact = row.cells[2].textContent.toLowerCase();

                    const matchesSearch = searchTerm === '' ||
                        storeName.includes(searchTerm) ||
                        location.includes(searchTerm) ||
                        contact.includes(searchTerm);

                    const matchesState = stateValue === '' || location.includes(stateValue);

                    if (matchesSearch && matchesState) {
                        row.classList.remove('hidden');
                        hasVisibleRows = true;
                    } else {
                        row.classList.add('hidden');
                    }
                });

                // Show "No stores found" message if no matching rows
                const tbody = document.querySelector('#stores tbody');
                if (!tbody) return;

                const noResultsRow = tbody.querySelector('tr.no-results');
                if (!hasVisibleRows) {
                    if (!noResultsRow) {
                        const newRow = document.createElement('tr');
                        newRow.className = 'no-results';
                        newRow.innerHTML =
                            '<td colspan="6" class="py-3 px-6 text-center">No matching stores found</td>';
                        tbody.appendChild(newRow);
                    } else {
                        noResultsRow.classList.remove('hidden');
                    }
                } else if (noResultsRow) {
                    noResultsRow.classList.add('hidden');
                }

                // Update clear filters button visibility
                if (searchTerm || stateValue) {
                    clearFiltersBtn.classList.remove('hidden');
                } else {
                    clearFiltersBtn.classList.add('hidden');
                }
            }
        });


        // Add this to the existing JavaScript in dashboard.blade.php
        document.addEventListener('DOMContentLoaded', function() {
            // Role-based fields in user form
            const roleSelect = document.getElementById('role');
            const storeField = document.querySelector('.store-field');

            if (roleSelect && storeField) {
                // Initial check
                if (roleSelect.value === 'store_manager') {
                    storeField.classList.remove('hidden');
                } else {
                    storeField.classList.add('hidden');
                }

                // On change
                roleSelect.addEventListener('change', function() {
                    if (this.value === 'store_manager') {
                        storeField.classList.remove('hidden');
                    } else {
                        storeField.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</x-app-layout>
