<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Wine Recommendations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Thank you for completing the questionnaire!</h3>
                            <p class="text-sm text-gray-600">Based on your answers, we've selected these wines for you.</p>
                        </div>
                    </div>
                    
                    <div class="mb-6 p-4 bg-indigo-50 rounded-lg">
                        <h4 class="font-medium text-indigo-800 mb-2">Your Wine Preferences</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($preferences as $key => $value)
                                <div class="bg-white p-3 rounded shadow-sm">
                                    <span class="text-xs text-gray-500 uppercase">{{ str_replace('_', ' ', $key) }}</span>
                                    <p class="font-medium text-gray-800">{{ is_array($value) ? implode(', ', $value) : $value }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Recommended Products -->
                    @if(count($recommendedProducts) > 0)
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Recommended Wines For You</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($recommendedProducts as $product)
                                <div class="border rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                                        @if($product->image_url)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->wine_name }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center bg-gradient-to-br 
                                                @if($product->type == 'red') from-red-100 to-red-200
                                                @elseif($product->type == 'white') from-yellow-50 to-yellow-100
                                                @elseif($product->type == 'rose') from-pink-100 to-pink-200
                                                @else from-blue-100 to-blue-200 @endif">
                                                <svg class="h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <div class="flex justify-between items-start">
                                            <h4 class="font-medium text-gray-900">{{ $product->wine_name }}</h4>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                @if($product->type == 'red') bg-red-100 text-red-800
                                                @elseif($product->type == 'white') bg-yellow-100 text-yellow-800
                                                @elseif($product->type == 'rose') bg-pink-100 text-pink-800
                                                @else bg-blue-100 text-blue-800 @endif">
                                                {{ ucfirst($product->type) }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">{{ $product->winery }}</p>
                                        <p class="text-sm text-gray-500 mt-1">{{ $product->grape_variety }}</p>
                                        <div class="flex justify-between items-center mt-3">
                                            <p class="text-lg font-bold text-gray-900">${{ number_format($product->retail_price, 2) }}</p>
                                            <a href="{{ route('products.show', $product) }}" class="text-indigo-600 hover:text-indigo-900">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 p-6 rounded-md text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No recommendations found</h3>
                            <p class="mt-1 text-sm text-gray-500">We couldn't find wines matching your preferences.</p>
                        </div>
                    @endif
                    
                    <div class="mt-8 flex justify-between">
                        <a href="{{ route('user.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Back to Dashboard
                        </a>
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Browse All Wines
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>