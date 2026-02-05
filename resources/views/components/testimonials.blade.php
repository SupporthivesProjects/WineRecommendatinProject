@props(['testimonials'])

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <style>
        .testimonial-item {
            padding: 0 15px;
        }
        .owl-nav {
            position: absolute;
            top: -60px;
            right: 0;
        }
        .owl-prev, .owl-next {
            background: #f3f4f6 !important;
            width: 40px;
            height: 40px;
            border-radius: 50% !important;
            margin: 0 5px;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        .owl-prev:hover, .owl-next:hover {
            background: #e5e7eb !important;
        }
        .owl-dots {
            margin-top: 20px;
            text-align: center;
        }
        .owl-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #d1d5db !important;
            margin: 0 5px;
        }
        .owl-dot.active {
            background: #ef4444 !important;
        }
    </style>
@endpush

<section class="py-16 bg-white relative" id="testimonials">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2 text-center">What Our Users Say</h2>
        <p class="text-gray-600 mb-12 text-center max-w-3xl mx-auto">
            Discover how Wine Recommender has transformed the wine experience for our community.
        </p>

        @if($testimonials->count() > 0)
            @if($testimonials->count() > 3)
                <div class="testimonials-carousel owl-carousel owl-theme">
                    @foreach($testimonials as $testimonial)
                        <div class="testimonial-item bg-gray-50 p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div class="flex items-center mb-4">
                                @if($testimonial->image_url)
                                    <img src="{{ asset('storage/' . $testimonial->image_url) }}" 
                                         alt="{{ $testimonial->name }}"
                                         class="h-12 w-12 rounded-full object-cover">
                                @else
                                    <div class="h-12 w-12 rounded-full bg-red-200 flex items-center justify-center text-red-700 font-bold text-xl">
                                        {{ $testimonial->initials }}
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $testimonial->name }}</h4>
                                    @if($testimonial->position || $testimonial->company)
                                        <p class="text-sm text-gray-500">
                                            {{ $testimonial->position }}{{ $testimonial->position && $testimonial->company ? ', ' : '' }}
                                            {{ $testimonial->company }}
                                        </p>
                                    @endif
                                    <div class="flex text-yellow-400 mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                viewBox="0 0 20 20" fill="{{ $i <= $testimonial->rating ? 'currentColor' : '#E5E7EB' }}">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-600 italic">
                                "{{ $testimonial->testimonial }}"
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($testimonials as $testimonial)
                        <div class="bg-gray-50 p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div class="flex items-center mb-4">
                                @if($testimonial->image_url)
                                    <img src="{{ asset('storage/' . $testimonial->image_url) }}" 
                                         alt="{{ $testimonial->name }}"
                                         class="h-12 w-12 rounded-full object-cover">
                                @else
                                    <div class="h-12 w-12 rounded-full bg-red-200 flex items-center justify-center text-red-700 font-bold text-xl">
                                        {{ $testimonial->initials }}
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $testimonial->name }}</h4>
                                    @if($testimonial->position || $testimonial->company)
                                        <p class="text-sm text-gray-500">
                                            {{ $testimonial->position }}{{ $testimonial->position && $testimonial->company ? ', ' : '' }}
                                            {{ $testimonial->company }}
                                        </p>
                                    @endif
                                    <div class="flex text-yellow-400 mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                viewBox="0 0 20 20" fill="{{ $i <= $testimonial->rating ? 'currentColor' : '#E5E7EB' }}">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-600 italic">
                                "{{ $testimonial->testimonial }}"
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        @else
            <div class="text-center py-8">
                <p class="text-gray-500">No testimonials available at the moment.</p>
            </div>
        @endif
    </div>
</section>

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function() {
            if ($('.testimonials-carousel').length) {
                $('.testimonials-carousel').owlCarousel({
                    loop: true,
                    margin: 20,
                    nav: true,
                    dots: true,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    autoplayHoverPause: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        768: {
                            items: 2
                        },
                        1024: {
                            items: 3
                        }
                    },
                    navText: [
                        '<i class="fas fa-chevron-left"></i>',
                        '<i class="fas fa-chevron-right"></i>'
                    ]
                });
            }
        });
    </script>
@endpush
