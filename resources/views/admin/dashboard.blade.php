<x-app-layout>
    <style>
        /* Sidebar styles */
        .dashboard-container {
            display: flex;
            min-height: calc(100vh - 128px); /* Adjusted for both main nav and header */
        }
        
        .sidebar {
            width: 250px;
            background-color: white;
            border-right: 1px solid #e5e7eb;
            position: fixed;
            top: 128px; /* Position below both headers (64px + 64px) */
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
            margin-top: 60px; /* Adjusted for both headers (64px + 64px) */
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
                top: 128px; /* Keep consistent with desktop */
            }
            
            .main-content {
                margin-left: 0;
                margin-top: 60px; /* Keep consistent with desktop */
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
            
            <button id="mobile-menu-button" class="md:hidden p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </x-slot>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <nav class="py-4">
                <a href="#dashboard" class="sidebar-link" data-tab="dashboard">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
                
                <a href="#products" class="sidebar-link" data-tab="products">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Products
                </a>
                
                <a href="#stores" class="sidebar-link" data-tab="stores">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Stores
                </a>
                
                <a href="#users" class="sidebar-link" data-tab="users">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Users
                </a>
                
                <a href="#questionnaires" class="sidebar-link" data-tab="questionnaires">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Questionnaires
                </a>
                
                <a href="#settings" class="sidebar-link" data-tab="settings">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Settings
                </a>
            </nav>
        </div>

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
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="store_name">Store Name</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="store_name" name="store_name" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="gst_vat">GST/VAT</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="gst_vat" name="gst_vat" type="text">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="contact_number">Contact</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="contact_number" name="contact_number" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="group">Group</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="group" name="group" type="text">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="address">Address</label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="address" name="address" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="state">State</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="state" name="state" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="email">Email ID</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="email" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="business_type">Business Type</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="business_type" name="business_type" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="licence_type">License Type</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="licence_type" name="licence_type" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="license_number">License Number</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="license_number" name="license_number" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="status">Status</label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button class="bg-gray-500 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-gray-600" type="button" onclick="closeAddStoreModal()">
                                Cancel
                            </button>
                            <button class="bg-indigo-600 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-indigo-700" type="submit">
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
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="first_name">First Name</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="first_name" name="first_name" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="last_name">Last Name</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="last_name" name="last_name" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="mobile">Mobile Number</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="mobile" name="mobile" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="email">Email</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="email" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="password">Password</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="role">Role</label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="role" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="store_manager">Store Manager</option>
                                <option value="customer">Customer</option>
                            </select>
                        </div>
                        <div class="mb-4 store-field hidden">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="store_id">Assign Store</label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="store_id" name="store_id">
                                <option value="">Select Store</option>
                                @foreach($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->store_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="status">Status</label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button class="bg-gray-500 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-gray-600" type="button" onclick="closeAddUserModal()">
                                Cancel
                            </button>
                            <button class="bg-indigo-600 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-indigo-700" type="submit">
                                Add User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add Product Modal -->
    <div id="addProductModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Add Product</h3>
                <div class="mt-2 px-7 py-3">
                    <form action="{{ route('admin.products.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="wine_name">Wine Name</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="wine_name" name="wine_name" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="type">Type</label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="red">Red Wine</option>
                                <option value="white">White Wine</option>
                                <option value="rose">Rosé</option>
                                <option value="sparkling">Sparkling</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="winery">Winery</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="winery" name="winery" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="grape_variety">Grape Variety</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="grape_variety" name="grape_variety" type="text">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="country">Country</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="country" name="country" type="text">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="region">Region</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="region" name="region" type="text">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="retail_price">Retail Price</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="retail_price" name="retail_price" type="number" step="0.01" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="status">Status</label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button class="bg-gray-500 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-gray-600" type="button" onclick="closeAddProductModal()">
                                Cancel
                            </button>
                            <button class="bg-indigo-600 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-indigo-700" type="submit">
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
                                '#3B82F6'  // Blue
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
                                '#EC4899'  // Pink
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
                                '#F97316'  // Orange
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
                                '#EF4444'  // Red
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
                        datasets: [
                            {
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
    </script>
</x-app-layout>