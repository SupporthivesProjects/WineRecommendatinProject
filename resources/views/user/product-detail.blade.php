<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('products.index') }}" class="mr-2">
                <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $product->wine_name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row">
                        <!-- Product Image -->
                        <div class="md:w-1/3 mb-6 md:mb-0 md:pr-6">
                            <div class="h-64 md:h-96 bg-gray-200 rounded-lg overflow-hidden">
                                @if($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->wine_name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center bg-gradient-to-br 
                                        @if($product->type == 'red') from-red-100 to-red-200
                                        @elseif($product->type == 'white') from-yellow-50 to-yellow-100
                                        @elseif($product->type == 'rose') from-pink-100 to-pink-200
                                        @else from-blue-100 to-blue-200 @endif">
                                        <svg class="h-32 w-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Product Details -->
                        <div class="md:w-2/3">
                            <div class="flex justify-between items-start mb-4">
                                <h1 class="text-2xl font-bold text-gray-900">{{ $product->wine_name }}</h1>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    @if($product->type == 'red') bg-red-100 text-red-800
                                    @elseif($product->type == 'white') bg-yellow-100 text-yellow-800
                                    @elseif($product->type == 'rose') bg-pink-100 text-pink-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ ucfirst($product->type) }} Wine
                                </span>
                            </div>
                            
                            <p class="text-xl font-bold text-gray-900 mb-6">${{ number_format($product->retail_price, 2) }}</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Winery</h3>
                                    <p class="text-base text-gray-900">{{ $product->winery }}</p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Grape Variety</h3>
                                    <p class="text-base text-gray-900">{{ $product->grape_variety ?: 'Not specified' }}</p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Country</h3>
                                    <p class="text-base text-gray-900">{{ $product->country ?: 'Not specified' }}</p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Region</h3>
                                    <p class="text-base text-gray-900">{{ $product->region ?: 'Not specified' }}</p>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-6 mb-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Description</h3>
                                @if($product->description)
                                    <p class="text-gray-700">{{ $product->description }}</p>
                                @else
                                    <p class="text-gray-500 italic">No description available for this wine.</p>
                                @endif
                            </div>
                            
                            <div class="border-t border-gray-200 pt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Tasting Notes</h3>
                                @if($product->tasting_notes)
                                    <p class="text-gray-700">{{ $product->tasting_notes }}</p>
                                @else
                                    <p class="text-gray-500 italic">No tasting notes available for this wine.</p>
                                @endif
                            </div>
                            
                            <div class="mt-8 flex space-x-4">
                                <button type="button" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Find in Stores
                                </button>
                                <button type="button" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Similar Products -->
            @if(count($similarProducts) > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">You May Also Like</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach($similarProducts as $similarProduct)
                                <div class="border rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                    <div class="h-40 bg-gray-200 flex items-center justify-center">
                                        @if($similarProduct->image_url)
                                            <img src="{{ $similarProduct->image_url }}" alt="{{ $similarProduct->wine_name }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center bg-gradient-to-br 
                                                @if($similarProduct->type == 'red') from-red-100 to-red-200
                                                @elseif($similarProduct->type == 'white') from-yellow-50 to-yellow-100
                                                @elseif($similarProduct->type == 'rose') from-pink-100 to-pink-200
                                                @else from-blue-100 to-blue-200 @endif">
                                                <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <div class="flex justify-between items-start">
                                            <h4 class="font-medium text-gray-900 text-sm">{{ Str::limit($similarProduct->wine_name, 30) }}</h4>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                                @if($similarProduct->type == 'red') bg-red-100 text-red-800
                                                @elseif($similarProduct->type == 'white') bg-yellow-100 text-yellow-800
                                                @elseif($similarProduct->type == 'rose') bg-pink-100 text-pink-800
                                                @else bg-blue-100 text-blue-800 @endif">
                                                {{ ucfirst($similarProduct->type) }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-600 mt-1">{{ $similarProduct->winery }}</p>
                                        <div class="flex justify-between items-center mt-2">
                                            <p class="text-sm font-bold text-gray-900">${{ number_format($similarProduct->retail_price, 2) }}</p>
                                            <a href="{{ route('products.show', $similarProduct) }}" class="text-xs text-indigo-600 hover:text-indigo-900">View</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
