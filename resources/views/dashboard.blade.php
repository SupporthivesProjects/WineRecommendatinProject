<x-app-layout>
    <style>
        /* Sidebar styles */
        .dashboard-container {
            display: flex;
            min-height: calc(100vh - 65px);
        }
        
        .sidebar {
            width: 250px;
            background-color: white;
            border-right: 1px solid #e5e7eb;
            position: fixed;
            height: calc(100vh - 65px);
            z-index: 10;
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
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }
            
            .main-content {
                margin-left: 0;
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
                <a href="#dashboard" class="sidebar-link active">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
                
                <a href="#products" class="sidebar-link">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Products
                </a>
                
                <a href="#stores" class="sidebar-link">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Stores
                </a>
                
                <a href="#users" class="sidebar-link">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Users
                </a>
                
                <a href="#questionnaires" class="sidebar-link">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Questionnaires
                </a>
                
                <a href="#settings" class="sidebar-link">
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
            <div id="dashboard">
                <!-- Analytics Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Products Chart -->
                    <div class="bg-white p-4 rounded shadow">
                        <h4 class="text-center mb-2">Products</h4>
                        <div class="chart-container" style="height: 200px;">
                            <canvas id="productsChart"></canvas>
                        </div>
                    </div>
                    
                    <!-- Users Chart -->
                    <div class="bg-white p-4 rounded shadow">
                        <h4 class="text-center mb-2">Users</h4>
                        <div class="chart-container" style="height: 200px;">
                            <canvas id="usersChart"></canvas>
                        </div>
                    </div>
                    
                    <!-- Stores Chart -->
                    <div class="bg-white p-4 rounded shadow">
                        <h4 class="text-center mb-2">Stores</h4>
                        <div class="chart-container" style="height: 200px;">
                            <canvas id="storesChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Questionnaire Usage Chart -->
                <div class="bg-white p-4 rounded shadow mb-6">
                    <h4 class="text-center mb-2">No of times Questionnaire used in last one week</h4>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="questionnaireChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div id="stores" class="mt-6">
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
                                        <th class="py-3 px-6 text-left">Status</th>
                                        <th class="py-3 px-6 text-center">Details</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm">
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-6 text-left">1</td>
                                        <td class="py-3 px-6 text-left">ABC Wine</td>
                                        <td class="py-3 px-6 text-left">Mumbai</td>
                                        <td class="py-3 px-6 text-left">
                                            <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs">Active</span>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">View</a>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-6 text-left">2</td>
                                        <td class="py-3 px-6 text-left">XYZ Wine</td>
                                        <td class="py-3 px-6 text-left">Pune</td>
                                        <td class="py-3 px-6 text-left">
                                            <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs">Active</span>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">View</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="users" class="mt-6">
                <!-- Users Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Users</h3>
                            <button type="button" class="bg-indigo-600 text-white py-1 px-4 rounded hover:bg-indigo-700 transition" onclick="openAddUserModal()">
                                Add Users
                            </button>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                                        <th class="py-3 px-6 text-left">Sr.No</th>
                                        <th class="py-3 px-6 text-left">Name</th>
                                        <th class="py-3 px-6 text-left">Contact</th>
                                        <th class="py-3 px-6 text-left">Email</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm">
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-6 text-left">1</td>
                                        <td class="py-3 px-6 text-left">John</td>
                                        <td class="py-3 px-6 text-left">98765</td>
                                        <td class="py-3 px-6 text-left">johh@gmail</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add Store Modal -->
    <div id="addStoreModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Add Store</h3>
                <div class="mt-2 px-7 py-3">
                    <form>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="store_name">Store Name</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="store_name" type="text">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="vat">VAT</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="vat" type="text">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="contact">Contact</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="contact" type="text">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="group">Group</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="group" type="text">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="address">Address</label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="address"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="state">State</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="state" type="text">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="email">Email ID</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="type">Type</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="type" type="text">
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button class="bg-gray-500 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-gray-600" type="button" onclick="closeAddStoreModal()">
                                Cancel
                            </button>
                            <button class="bg-indigo-600 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-indigo-700" type="button">
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
                    <form>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="first_name">First Name</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="first_name" type="text">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="last_name">Last Name</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="last_name" type="text">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="mobile">Mobile Number</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="mobile" type="text">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="user_email">Email</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="user_email" type="email">
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button class="bg-gray-500 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-gray-600" type="button" onclick="closeAddUserModal()">
                                Cancel
                            </button>
                            <button class="bg-indigo-600 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-indigo-700" type="button">
                                Add User
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
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('open');
        });
        
        // Section navigation
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', function(e) {
                // Remove active class from all links
                document.querySelectorAll('.sidebar-link').forEach(l => {
                    l.classList.remove('active');
                });
                
                // Add active class to clicked link
                this.classList.add('active');
                
                // Hide all sections
                document.querySelectorAll('#dashboard, #stores, #users, #products, #questionnaires, #settings').forEach(section => {
                    section.style.display = 'none';
                });
                
                // Show the target section
                const targetId = this.getAttribute('href').substring(1);
                document.getElementById(targetId).style.display = 'block';
                
                // Prevent default anchor behavior
                e.preventDefault();
            });
        });
        
        // Initially hide all sections except dashboard
        document.querySelectorAll('#stores, #users, #products, #questionnaires, #settings').forEach(section => {
            section.style.display = 'none';
        });
        
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

        // Initialize Charts
        document.addEventListener('DOMContentLoaded', function() {
            // Products Pie Chart
            const productsCtx = document.getElementById('productsChart').getContext('2d');
            const productsChart = new Chart(productsCtx, {
                type: 'pie',
                data: {
                    labels: ['Red Wine', 'White Wine', 'Rosé', 'Sparkling'],
                    datasets: [{
                        data: [45, 30, 15, 10],
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
                }
            });
            
            // Users Pie Chart
            const usersCtx = document.getElementById('usersChart').getContext('2d');
            const usersChart = new Chart(usersCtx, {
                type: 'pie',
                data: {
                    labels: ['Admins', 'Store Managers', 'Customers'],
                    datasets: [{
                        data: [5, 15, 80],
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
            
            // Stores Pie Chart
            const storesCtx = document.getElementById('storesChart').getContext('2d');
            const storesChart = new Chart(storesCtx, {
                type: 'pie',
                data: {
                    labels: ['Active', 'Inactive'],
                    datasets: [{
                        data: [85, 15],
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
            
            // Questionnaire Usage Bar Chart
            const questionnaireCtx = document.getElementById('questionnaireChart').getContext('2d');
            const questionnaireChart = new Chart(questionnaireCtx, {
                type: 'bar',
                data: {
                    labels: ['12 Jan', '13 Jan', '14 Jan', '15 Jan', '16 Jan'],
                    datasets: [
                        {
                            label: 'Admin',
                            data: [12, 19, 8, 15, 10],
                            backgroundColor: '#3B82F6', // Blue
                        },
                        {
                            label: 'Admin1',
                            data: [8, 12, 6, 9, 14],
                            backgroundColor: '#10B981', // Green
                        },
                        {
                            label: 'Admin2',
                            data: [5, 10, 4, 7, 9],
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
        });
    </script>
</x-app-layout>