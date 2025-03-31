<nav class="bg-black/30 backdrop-blur-sm border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="text-white text-2xl font-bold">Wine Recommender</div>
            </div>
            <div class="flex items-center space-x-4">
                @if (Route::has('login'))
                    <div class="space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-white hover:text-gray-300 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-white hover:text-gray-300 transition">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded-md transition">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav>
