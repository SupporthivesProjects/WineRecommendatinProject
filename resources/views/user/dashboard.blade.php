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
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
    </style>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Wine Recommender Dashboard') }}
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
        <x-user-sidebar />

        <!-- Main Content -->
        <div class="main-content">
            <!-- Tab content containers -->
            <div id="dashboard" class="tab-content active">
                <!-- Welcome Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Welcome, {{ Auth::user()->name }}!</h3>
                        
                        @if(session('success'))
                            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-green-700">
                                            {{ session('success') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-red-700">
                                            {{ session('error') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="mt-4 flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                <p class="text-gray-600">Your wine expertise level:</p>
                                <div class="mt-2">
                                    @if(Auth::user()->expertise_level)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                            @if(Auth::user()->expertise_level == 'first_sip') bg-green-100 text-green-800
                                            @elseif(Auth::user()->expertise_level == 'savy_sipper') bg-blue-100 text-blue-800
                                            @else bg-purple-100 text-purple-800 @endif">
                                            @if(Auth::user()->expertise_level == 'first_sip')
                                                First Sip
                                            @elseif(Auth::user()->expertise_level == 'savy_sipper')
                                                Savvy Sipper
                                            @else
                                                Wine Pro
                                            @endif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                            Not Assessed
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mt-4 md:mt-0">
                                @if(Auth::user()->expertise_level)
                                    <a href="{{ route('questionnaires.expertise') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Reassess Expertise
                                    </a>
                                @else
                                    <a href="{{ route('questionnaires.expertise') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Take Expertise Assessment
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Quick Links -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200 h-full flex flex-col">
                            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-indigo-100 text-indigo-600 mb-4">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Wine Questionnaires</h3>
                            <p class="text-gray-600 mb-4 flex-grow">Take our wine questionnaires to get personalized recommendations.</p>
                            <a href="{{ route('questionnaires.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                View Questionnaires
                            </a>
                        </div>
                    </div>
                
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200 h-full flex flex-col">
                            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-red-100 text-red-600 mb-4">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Browse Wines</h3>
                            <p class="text-gray-600 mb-4 flex-grow">Explore our collection of wines from around the world.</p>
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                View All Wines
                            </a>
                        </div>
                    </div>
                
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200 h-full flex flex-col">
                            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-green-100 text-green-600 mb-4">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Find Stores</h3>
                            <p class="text-gray-600 mb-4 flex-grow">Locate stores near you that carry our recommended wines.</p>
                            <a href="{{ route('stores.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Find Stores
                            </a>
                        </div>
                    </div>
                </div>
            
                <!-- Recent Recommendations -->
                @if(count($recentRecommendations ?? []) > 0)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Your Recent Recommendations</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @foreach($recentRecommendations as $product)
                                    <div class="border rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                        <div class="h-40 bg-gray-200 flex items-center justify-center">
                                            @if($product->image_url)
                                                <img src="{{ $product->image_url }}" alt="{{ $product->wine_name }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center bg-gradient-to-br 
                                                    @if($product->type == 'red') from-red-100 to-red-200
                                                    @elseif($product->type == 'white') from-yellow-50 to-yellow-100
                                                    @elseif($product->type == 'rose') from-pink-100 to-pink-200
                                                    @else from-blue-100 to-blue-200 @endif">
                                                    <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <div class="flex justify-between items-start mb-4">
                                                <h4 class="font-medium text-gray-900 text-sm">{{ Str::limit($product->wine_name, 30) }}</h4>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                                    @if($product->type == 'red') bg-red-100 text-red-800
                                                    @elseif($product->type == 'white') bg-yellow-100 text-yellow-800
                                                    @elseif($product->type == 'rose') bg-pink-100 text-pink-800
                                                    @else bg-blue-100 text-blue-800 @endif">
                                                    {{ ucfirst($product->type) }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-600 mt-1">{{ $product->winery }}</p>
                                            <div class="flex justify-between items-center mt-2">
                                                <p class="text-sm font-bold text-gray-900">${{ number_format($product->retail_price, 2) }}</p>
                                                <a href="{{ route('products.show', $product) }}" class="text-xs text-indigo-600 hover:text-indigo-900">View</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            
                <!-- Available Questionnaires -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Available Questionnaires</h3>
                        
                        @if(count($questionnaires ?? []) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($questionnaires as $questionnaire)
                                    <div class="border rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                        <div class="p-6">
                                            <div class="flex justify-between items-start mb-4">
                                                <h4 class="font-medium text-gray-900">{{ $questionnaire->name }}</h4>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    @if($questionnaire->level == 'first_sip') bg-green-100 text-green-800
                                                    @elseif($questionnaire->level == 'savy_sipper') bg-blue-100 text-blue-800
                                                    @else bg-purple-100 text-purple-800 @endif">
                                                    @if($questionnaire->level == 'first_sip')
                                                        First Sip
                                                    @elseif($questionnaire->level == 'savy_sipper')
                                                        Savvy Sipper
                                                    @else
                                                        Wine Pro
                                                    @endif
                                                </span>
                                            </div>
                                        
                                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($questionnaire->description, 120) }}</p>
                                        
                                            <div class="flex justify-between items-center">
                                                <span class="text-xs text-gray-500">
                                                    {{ count(is_array($questionnaire->questions) ? $questionnaire->questions : json_decode($questionnaire->questions, true) ?? []) }} questions
                                                </span>
                                                <a href="{{ route('questionnaires.show', $questionnaire) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Take Questionnaire
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-50 p-6 rounded-md text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No questionnaires available</h3>
                                <p class="mt-1 text-sm text-gray-500">Check back later for new wine questionnaires.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div id="questionnaires" class="tab-content">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">All Questionnaires</h3>
                        
                        @if(count($questionnaires ?? []) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($questionnaires as $questionnaire)
                                    <div class="border rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                        <div class="p-6">
                                            <div class="flex justify-between items-start mb-4">
                                                <h4 class="font-medium text-gray-900">{{ $questionnaire->name }}</h4>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    @if($questionnaire->level == 'first_sip') bg-green-100 text-green-800
                                                    @elseif($questionnaire->level == 'savy_sipper') bg-blue-100 text-blue-800
                                                    @else bg-purple-100 text-purple-800 @endif">
                                                    @if($questionnaire->level == 'first_sip')
                                                        First Sip
                                                    @elseif($questionnaire->level == 'savy_sipper')
                                                        Savvy Sipper
                                                    @else
                                                        Wine Pro
                                                    @endif
                                                </span>
                                            </div>
                                        
                                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($questionnaire->description, 120) }}</p>
                                        
                                            <div class="flex justify-between items-center">
                                                <span class="text-xs text-gray-500">
                                                    {{ count(is_array($questionnaire->questions) ? $questionnaire->questions : json_decode($questionnaire->questions, true) ?? []) }} questions
                                                </span>
                                                <a href="{{ route('questionnaires.show', $questionnaire) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Take Questionnaire
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-50 p-6 rounded-md text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No questionnaires available</h3>
                                <p class="mt-1 text-sm text-gray-500">Check back later for new wine questionnaires.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div id="wines" class="tab-content">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Browse Our Wine Collection</h3>
                        
                        <div class="mb-6">
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                View All Wines
                            </a>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="border rounded-lg overflow-hidden hover:shadow-lg transition-shadow bg-red-50">
                                <a href="{{ route('products.index', ['type' => 'red']) }}" class="block p-6 text-center">
                                    <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-red-100 text-red-600 mb-4 mx-auto">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-medium text-gray-900">Red Wines</h4>
                                </a>
                            </div>
                            
                            <div class="border rounded-lg overflow-hidden hover:shadow-lg transition-shadow bg-yellow-50">
                                <a href="{{ route('products.index', ['type' => 'white']) }}" class="block p-6 text-center">
                                    <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-yellow-100 text-yellow-600 mb-4 mx-auto">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-medium text-gray-900">White Wines</h4>
                                </a>
                            </div>
                            
                            <div class="border rounded-lg overflow-hidden hover:shadow-lg transition-shadow bg-pink-50">
                                <a href="{{ route('products.index', ['type' => 'rose']) }}" class="block p-6 text-center">
                                    <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-pink-100 text-pink-600 mb-4 mx-auto">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-medium text-gray-900">Rosé Wines</h4>
                                </a>
                            </div>
                            
                            <div class="border rounded-lg overflow-hidden hover:shadow-lg transition-shadow bg-blue-50">
                                <a href="{{ route('products.index', ['type' => 'sparkling']) }}" class="block p-6 text-center">
                                    <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-blue-100 text-blue-600 mb-4 mx-auto">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-medium text-gray-900">Sparkling Wines</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="recommendations" class="tab-content">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Your Wine Recommendations</h3>
                        
                        @if(count($recentRecommendations ?? []) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @foreach($recentRecommendations as $product)
                                    <div class="border rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                        <div class="h-40 bg-gray-200 flex items-center justify-center">
                                            @if($product->image_url)
                                                <img src="{{ $product->image_url }}" alt="{{ $product->wine_name }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center bg-gradient-to-br 
                                                    @if($product->type == 'red') from-red-100 to-red-200
                                                    @elseif($product->type == 'white') from-yellow-50 to-yellow-100
                                                    @elseif($product->type == 'rose') from-pink-100 to-pink-200
                                                    @else from-blue-100 to-blue-200 @endif">
                                                    <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <div class="flex justify-between items-start mb-4">
                                                <h4 class="font-medium text-gray-900 text-sm">{{ Str::limit($product->wine_name, 30) }}</h4>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                                    @if($product->type == 'red') bg-red-100 text-red-800
                                                    @elseif($product->type == 'white') bg-yellow-100 text-yellow-800
                                                    @elseif($product->type == 'rose') bg-pink-100 text-pink-800
                                                    @else bg-blue-100 text-blue-800 @endif">
                                                    {{ ucfirst($product->type) }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-600 mt-1">{{ $product->winery }}</p>
                                            <div class="flex justify-between items-center mt-2">
                                                <p class="text-sm font-bold text-gray-900">${{ number_format($product->retail_price, 2) }}</p>
                                                <a href="{{ route('products.show', $product) }}" class="text-xs text-indigo-600 hover:text-indigo-900">View</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-50 p-6 rounded-md text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No recommendations yet</h3>
                                <p class="mt-1 text-sm text-gray-500">Take a questionnaire to get personalized wine recommendations.</p>
                                <div class="mt-6">
                                    <a href="{{ route('questionnaires.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Take a Questionnaire
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div id="stores" class="tab-content">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Find Wine Stores Near You</h3>
                        
                        <div class="mb-6">
                            <a href="{{ route('stores.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                View All Stores
                            </a>
                        </div>
                        
                        <div class="bg-gray-50 p-6 rounded-md">
                            <div class="text-center mb-6">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Find stores that carry our wines</h3>
                                <p class="mt-1 text-sm text-gray-500">Search for stores by location or browse our partner stores.</p>
                            </div>
                            
                            <div class="max-w-md mx-auto">
                                <form action="{{ route('stores.index') }}" method="GET">
                                    <div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
                                        <input type="text" name="location" placeholder="Enter your location" class="flex-1 px-4 py-2 focus:outline-none">
                                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 hover:bg-indigo-700 focus:outline-none">
                                            Search
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="profile" class="tab-content">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Your Profile</h3>
                        
                        <div class="mb-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-20 w-20 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500">
                                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900">{{ Auth::user()->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        Wine Expertise: 
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if(Auth::user()->expertise_level == 'first_sip') bg-green-100 text-green-800
                                            @elseif(Auth::user()->expertise_level == 'savy_sipper') bg-blue-100 text-blue-800
                                            @elseif(Auth::user()->expertise_level == 'pro') bg-purple-100 text-purple-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            @if(Auth::user()->expertise_level == 'first_sip')
                                                First Sip
                                            @elseif(Auth::user()->expertise_level == 'savy_sipper')
                                                Savvy Sipper
                                            @elseif(Auth::user()->expertise_level == 'pro')
                                                Wine Pro
                                            @else
                                                Not Assessed
                                            @endif
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Account Settings</h4>
                            
                            <div class="space-y-4">
                                <a href="{{ route('profile.edit') }}" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        <div>
                                            <h5 class="text-sm font-medium text-gray-900">Edit Profile</h5>
                                            <p class="text-xs text-gray-500">Update your personal information and email</p>
                                        </div>
                                    </div>
                                </a>
                                
                                <a href="{{ route('questionnaires.expertise') }}" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <h5 class="text-sm font-medium text-gray-900">Wine Expertise Assessment</h5>
                                            <p class="text-xs text-gray-500">Update your wine knowledge level</p>
                                        </div>
                                    </div>
                                </a>
                                
                                <a href="{{ route('password.request') }}" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                        </svg>
                                        <div>
                                            <h5 class="text-sm font-medium text-gray-900">Change Password</h5>
                                            <p class="text-xs text-gray-500">Update your password</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Tab Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get active tab from localStorage or default to dashboard
            const activeTab = localStorage.getItem('userActiveTab') || 'dashboard';
            
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
                    localStorage.setItem('userActiveTab', tabId);
                });
            });
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
                tab.classList.remove('active');
                tab.style.display = 'none';
            });
            
            // Show selected tab content
            const activeContent = document.getElementById(tabId);
            if (activeContent) {
                activeContent.classList.add('active');
                activeContent.style.display = 'block';
            }
        }
    </script>
</x-app-layout>