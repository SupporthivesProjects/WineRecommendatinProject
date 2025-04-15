<x-app-layout>
    <style>
        footer {
        margin-left: 250px; /* same as your sidebar width */
        width: calc(100% - 250px); /* to prevent horizontal scroll */
        }



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
                {{ __('WineRecommender Store Admin Panel') }}
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
        <x-sidebar />

        <!-- Main Content -->
        <div class="main-content">
            <div id="storedashboard" class="tab-content">
                @include('store-manager.storeDashboard.storedashboard-tab')
            </div>
            <div id="storeproducts" class="tab-content hidden">
                @include('store-manager.storeDashboard.storeproducts-tab')
            </div>
            <div id="storefeaturedproducts" class="tab-content hidden">
                @include('store-manager.storeDashboard.storefeaturedproducts-tab')
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
           
            // Get saved tab or fallback
            const savedTab = localStorage.getItem('activeTab');
            const fallbackTabs = ['storedashboard', 'dashboard']; // add more if needed

            if (savedTab && document.getElementById(savedTab)) {
                activateTab(savedTab);
            } else {
                // Loop through fallback options and activate the first available one
                const fallback = fallbackTabs.find(tabId => document.getElementById(tabId));
                if (fallback) {
                    activateTab(fallback);
                } else {
                    console.warn("No valid tab found to activate.");
                }
            }

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
            const productsTypeCtx = document.getElementById('storeproductsChart');
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
            const grapesCtx = document.getElementById('storegrapesChart');
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
            const countriesCtx = document.getElementById('storecountriesChart');
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
            const pricesCtx = document.getElementById('storepricesChart');
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
            const usersCtx = document.getElementById('storeusersChart');
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
            const storesCtx = document.getElementById('storestoresChart');
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
            const questionnaireCtx = document.getElementById('storequestionnaireChart');
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