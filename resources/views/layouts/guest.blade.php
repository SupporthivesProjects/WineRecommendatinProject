<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

            <!-- Favicon -->
            <link rel="icon" href="{{ asset('images/wine_store_favicon.ico') }}" type="image/x-icon">

            <!-- Authentication-main Js -->
            <script src="{{ asset('assets/js/authentication-main.js') }}"></script>

            <!-- Bootstrap Css -->
            <link id="style" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" >

            <!-- Style Css -->
            <link href="{{ asset('assets/css/styles.min.css') }}" rel="stylesheet" >

            <!-- Icons Css -->
            <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" >

            <script>
                if(localStorage.spruhalandingdarktheme){
                    document.querySelector("html").setAttribute("data-theme-mode","dark")
                }
                if(localStorage.spruhalandingrtl){
                    document.querySelector("html").setAttribute("dir","rtl")
                    document.querySelector("#style")?.setAttribute("href", "../assets/libs/bootstrap/css/bootstrap.rtl.min.css");
                }
            </script>

            <!-- Scripts -->
            @vite(['resources/css/app.css', 'resources/js/app.js'])

    

    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-30 h-30 fill-current text-gray-500" />
                </a>
            </div>

            <div class="row signpages text-center">
                {{ $slot }}
            </div>
        </div>

         <!-- Custom-Switcher JS -->
        <script src="{{ asset('assets/js/custom-switcher.min.js') }}"></script>

        <!-- Bootstrap JS -->
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


    </body>
</html>
