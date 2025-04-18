<x-app-layout :header_type="'transparent'">

    <style>
         footer 
        {
            margin-left: 0px; /* same as your sidebar width */
            width: 100%;    
        }
    </style>


    <!-- Hero Section -->
    <div class="wine-bg min-h-screen flex flex-col">
        <!-- Hero Content -->
        <div class="flex-grow flex items-center justify-center">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">Discover Your Perfect Winessss</h1>
                <p class="text-xl text-gray-200 mb-10 max-w-3xl mx-auto">
                    Our intelligent recommendation system helps you find the perfect wine for any occasion, based on
                    your taste preferences and food pairings...
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#explore"
                        class="bg-red-700 hover:bg-red-800 text-white px-8 py-3 rounded-md text-lg font-medium transition">
                        Explore Wines
                    </a>
                    <a href="#how-it-works"
                        class="bg-white/10 hover:bg-white/20 text-white border border-white/20 px-8 py-3 rounded-md text-lg font-medium transition backdrop-blur-sm">
                        How It Works
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div id="how-it-works" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2 text-center">How It Works</h2>
            <p class="text-gray-600 mb-12 text-center max-w-3xl mx-auto">
                Our recommendation system uses advanced algorithms to match you with wines you'll love.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="bg-red-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-700" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Create Your Profile</h3>
                    <p class="text-gray-600">
                        Sign up and tell us about your taste preferences, favorite wines, and dining habits.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div class="bg-red-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-700" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Get Personalized Recommendations</h3>
                    <p class="text-gray-600">
                        Our algorithm analyzes your preferences and suggests wines that match your unique taste profile.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div class="bg-red-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-700" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Discover & Enjoy</h3>
                    <p class="text-gray-600">
                        Explore your recommendations, rate wines you try, and refine your profile for even better
                        matches.
                    </p>
                </div>
            </div>
        </div>
    </div>


      <!-- Featured Wines Section -->
      <div id="explore" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2 text-center">Featured Wines</h2>
            <p class="text-gray-600 mb-12 text-center max-w-3xl mx-auto">
                Explore our curated selection of exceptional wines from around the world, each with its own unique
                character and story.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Wine Card 1 -->
                <div class="wine-card bg-white rounded-lg overflow-hidden shadow-md">
                    <img src="https://images.unsplash.com/photo-1586370434639-0fe43b2d32e6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                        alt="Red Wine" class="w-full h-60 object-cover">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-gray-900">Château Margaux 2015</h3>
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Red</span>
                        </div>
                        <p class="text-gray-600 mb-4">A magnificent Bordeaux with notes of black currant, violets, and
                            cedar. Elegant and powerful.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-900 font-bold">$189.99</span>
                            <button
                                class="bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded-md text-sm transition">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Wine Card 2 -->
                <div class="wine-card bg-white rounded-lg overflow-hidden shadow-md">
                    <img src="https://images.unsplash.com/photo-1724949629465-fa0d083ad09c?q=80&w=2880&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="White Wine" class="w-full h-60 object-cover">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-gray-900">Cloudy Bay Sauvignon Blanc</h3>
                            <span
                                class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">White</span>
                        </div>
                        <p class="text-gray-600 mb-4">Vibrant and crisp with intense flavors of passion fruit, lime, and
                            fresh herbs from New Zealand.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-900 font-bold">$34.99</span>
                            <button
                                class="bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded-md text-sm transition">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Wine Card 3 -->
                <div class="wine-card bg-white rounded-lg overflow-hidden shadow-md">
                    <img src="https://images.unsplash.com/photo-1700893417209-18dc88c989a0?q=80&w=2940&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="Sparkling Wine" class="w-full h-60 object-cover">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-gray-900">Dom Pérignon Vintage</h3>
                            <span
                                class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Sparkling</span>
                        </div>
                        <p class="text-gray-600 mb-4">Luxurious champagne with complex notes of almond, powdered cocoa,
                            white fruit, and dried flowers.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-900 font-bold">$219.99</span>
                            <button
                                class="bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded-md text-sm transition">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="#"
                    class="inline-block bg-red-700 hover:bg-red-800 text-white px-6 py-3 rounded-md text-lg font-medium transition">
                    View All Wines
                </a>
            </div>
        </div>
    </div>


    <!-- Food Pairing Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2 text-center">Perfect Food Pairings</h2>
            <p class="text-gray-600 mb-12 text-center max-w-3xl mx-auto">
                Enhance your dining experience with our expert food and wine pairing suggestions.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Pairing 1 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md flex flex-col md:flex-row">
                    <div class="md:w-1/2">
                        <img src="https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                            alt="Steak" class="w-full h-full object-cover">
                    </div>
                    <div class="md:w-1/2 p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Steak & Cabernet Sauvignon</h3>
                        <p class="text-gray-600 mb-4">
                            The rich tannins in Cabernet Sauvignon perfectly complement the proteins in a juicy steak,
                            creating a harmonious balance of flavors.
                        </p>
                        <a href="#"
                            class="text-red-700 hover:text-red-800 font-medium inline-flex items-center">
                            Explore this pairing
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Pairing 2 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-md flex flex-col md:flex-row">
                <div class="md:w-1/2">
                    <img src="https://images.unsplash.com/photo-1559737558-2f5a35f4523b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                        alt="Seafood" class="w-full h-full object-cover">
                </div>
                <div class="md:w-1/2 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Seafood & Chardonnay</h3>
                    <p class="text-gray-600 mb-4">
                        The buttery notes and subtle oak in Chardonnay enhance the delicate flavors of seafood,
                        especially when prepared with creamy sauces.
                    </p>
                    <a href="#"
                        class="text-red-700 hover:text-red-800 font-medium inline-flex items-center">
                        Explore this pairing
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="#"
                class="inline-block bg-red-700 hover:bg-red-800 text-white px-6 py-3 rounded-md text-lg font-medium transition">
                View All Pairings
            </a>
        </div>
    </div>
</div>

<!-- Testimonials Section -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2 text-center">What Our Users Say</h2>
        <p class="text-gray-600 mb-12 text-center max-w-3xl mx-auto">
            Discover how Wine Recommender has transformed the wine experience for our community.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Testimonial 1 -->
            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                <div class="flex items-center mb-4">
                    <div
                        class="h-12 w-12 rounded-full bg-red-200 flex items-center justify-center text-red-700 font-bold text-xl">
                        JD
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-semibold text-gray-900">James Davis</h4>
                        <div class="flex text-yellow-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <!-- Repeat star SVGs 4 more times -->
                        </div>
                    </div>
                </div>
                <p class="text-gray-600 italic">
                    "I used to spend hours researching wines before dinner parties. Wine Recommender has saved me so
                    much time and introduced me to amazing wines I never would have discovered on my own."
                </p>
            </div>

            <!-- Testimonial 2 -->
            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                <div class="flex items-center mb-4">
                    <div
                        class="h-12 w-12 rounded-full bg-red-200 flex items-center justify-center text-red-700 font-bold text-xl">
                        SL
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-semibold text-gray-900">Sarah Lee</h4>
                        <div class="flex text-yellow-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <!-- Repeat star SVGs 4 more times -->
                        </div>
                    </div>
                </div>
                <p class="text-gray-600 italic">
                    "As a beginner in the world of wine, I was overwhelmed by all the choices. This app has been my
                    personal sommelier, guiding me to wines that match my taste perfectly."
                </p>
            </div>

            <!-- Testimonial 3 -->
            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                <div class="flex items-center mb-4">
                    <div
                        class="h-12 w-12 rounded-full bg-red-200 flex items-center justify-center text-red-700 font-bold text-xl">
                        MR
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-semibold text-gray-900">Michael Rodriguez</h4>
                        <div class="flex text-yellow-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <!-- Repeat star SVGs 4 more times -->
                        </div>
                    </div>
                </div>
                <p class="text-gray-600 italic">
                    "The food pairing suggestions are spot on! I've impressed my friends at dinner parties with
                    perfect wine selections that complement every dish."
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Owl Carousel Code -->
<!-- Carousel Section -->
<section class="py-12 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Wine Moments</h2>

        <div class="owl-carousel owl-theme">
            @foreach ([
                'https://media.istockphoto.com/id/1182488944/photo/just-one-more-chapter.webp?a=1&b=1&s=612x612&w=0&k=20&c=Bda3jU5w-qMIuGX9ZFpymDsaDj9kRMhVSrZMB7Nf1mg=',
                'https://media.istockphoto.com/id/526246287/photo/meat-wine-restaurant.webp?a=1&b=1&s=612x612&w=0&k=20&c=65c7kZ0paj831ILgFNjnIDMCvRwQszn3qzVjpaYAORo=',
                'https://media.istockphoto.com/id/626154424/photo/pouring-red-wine.webp?a=1&b=1&s=612x612&w=0&k=20&c=4QA15zbQxUHbGKMT67hl_VZcIrfpIZ4t5RaYE77Jja8=',
                'https://media.istockphoto.com/id/626154424/photo/pouring-red-wine.webp?a=1&b=1&s=612x612&w=0&k=20&c=4QA15zbQxUHbGKMT67hl_VZcIrfpIZ4t5RaYE77Jja8=',
                'https://media.istockphoto.com/id/476976729/photo/wine-tasting-at-restaurant.webp?a=1&b=1&s=612x612&w=0&k=20&c=jpLOBX57Z9r91cb2yFOUkl27pa3kn4d6K9yvPctrLug='
            ] as $image)
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <img src="{{ $image }}" alt="Wine image" class="w-full h-64 object-cover">
                </div>
            @endforeach
        </div>
    </div>
</section>


<!-- Newsletter Section -->
<div class="py-16 bg-red-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="lg:w-1/2">
                <h2 class="text-3xl font-bold text-white mb-2">Join Our Wine Community</h2>
                <p class="text-red-100 mb-6 lg:mb-0">
                    Subscribe to our newsletter for exclusive wine recommendations, special offers, and expert tips
                    on wine appreciation.
                </p>
            </div>
            <div class="lg:w-1/2">
                <form class="sm:flex">
                    <label for="email-address" class="sr-only">Email address</label>
                    <input id="email-address" name="email" type="email" autocomplete="email" required
                        class="w-full px-5 py-3 placeholder-gray-500 focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-700 focus:ring-white focus:outline-none rounded-md"
                        placeholder="Enter your email">
                    <div class="mt-3 sm:mt-0 sm:ml-3">
                        <button type="submit"
                            class="w-full flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-700 focus:ring-white">
                            Subscribe
                        </button>
                    </div>
                </form>
                <p class="mt-3 text-sm text-red-200">
                    We care about your data. Read our <a href="#" class="text-white underline">Privacy Policy</a>.
                </p>
            </div>
        </div>
    </div>
</div>


</x-app-layout>
