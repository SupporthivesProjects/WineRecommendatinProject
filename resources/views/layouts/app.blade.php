<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="og:title" content="TechSomm">
    <meta property="og:description" content="Your digital sommelier for effortless wine discovery and perfect pairings.">
    <meta property="og:image" content="https://app.wine.supporthives.com/assets/images/links/share_preview.jpg">
    <meta property="og:url" content="https://app.wine.supporthives.com/">
    <meta property="og:type" content="website">

    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="TechSomm">
    <meta name="twitter:description" content="Your digital sommelier for effortless wine discovery and perfect pairings.">
    <meta name="twitter:image" content="https://app.wine.supporthives.com/assets/images/links/share_preview.jpg">




    <title>{{ config('app.name', 'Wine Recommender') }}</title>

    <!-- Basic CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- You can also use CDN for frameworks like Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        footer {
            margin-left: 250px;
            /* same as your sidebar width */
            width: calc(100% - 250px);
            /* to prevent horizontal scroll */
        }

        .wine-bg {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1506377247377-2a5b3b417ebb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
        }

        .wine-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .wine-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>

    <!-- Scripts -->
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen {{ isset($header_type) && $header_type == 'transparent' ? '' : 'bg-gray-100' }}">
        @if (isset($header_type) && $header_type == 'transparent')
            @include('layouts.header')
        @else
            @include('layouts.navigation')
        @endif

        <!-- Page Heading -->
        @if (isset($header) && !isset($header_type))
            <header class="bg-white shadow border-b border-gray-100 sticky top-16 z-40 w-full">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        @include('layouts.footer')
    </div>

    <!-- Back to Top Button -->
    <a href="#"
        class="fixed bottom-6 right-6 bg-red-700 hover:bg-red-800 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </a>

    <!-- Optional JavaScript for enhanced functionality -->
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>

    <!-- jQuery (required for Owl Carousel) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                loop: true,
                margin: 20,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
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
                }
            });
        });
    </script>
    <script>
        function playTak() {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const buf = ctx.createBuffer(1, ctx.sampleRate * 0.04, ctx.sampleRate);
            const data = buf.getChannelData(0);
            for (let i = 0; i < data.length; i++) {
                data[i] = (Math.random() * 2 - 1) * Math.pow(1 - i / data.length, 8);
            }
            const src = ctx.createBufferSource();
            src.buffer = buf;
            const gain = ctx.createGain();
            gain.gain.setValueAtTime(0.10, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.04);
            src.connect(gain);
            gain.connect(ctx.destination);
            src.start();
        }

        $(document).on('click', 'button, a, .btn, input, select, textarea, label, td, th, .nav-link, .dropdown-item, .form-check-input, .form-select, .card, .list-group-item, .badge, .close, .alert, [data-bs-toggle], [role="button"], [tabindex]', function () {
            playTak();
        });
    </script>

</body>

</html>
