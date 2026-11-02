<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <style>
        .password-wrapper{
            position:relative;
        }

        .toggle-password{
            position:absolute;
            top:50%;
            right:15px;
            transform:translateY(-50%);
            cursor:pointer;
            z-index:10;
            color:#6c757d;
            font-size:18px;
        }
        html,
        body{
            height:100%;
            margin:0;
            overflow:hidden;
            background:var(--brand-cream-50, #f8f5f2) !important;
        }

        /* Remove white bottom band */
        body{
            display:flex;
            flex-direction:column;
        }

        /* Main wrapper */
        .min-h-screen{
            min-height:100vh !important;
            background:var(--brand-cream-50, #f8f5f2) !important;
        }

        /* Brand panel and form (was the admin template's purple) */
        .signpages .details{
            background:var(--brand-wine-900, #3b0f1a) !important;
        }
        .signpages .details h5{
            color:var(--brand-gold-200, #e0c58b);
        }
        .signpages .login_form .form-control{
            min-height:44px;
        }
        .signpages .login_form .form-control:focus{
            border-color:var(--brand-wine-500, #a8324a);
            box-shadow:0 0 0 0.2rem rgba(168, 50, 74, 0.25);
        }
        .signpages .login_form .btn-primary{
            min-height:44px;
            border-radius:4px !important;
            font-weight:500;
        }
        .signpages .login_form .btn-primary:hover{
            background-color:var(--brand-wine-900, #3b0f1a) !important;
            border-color:var(--brand-wine-900, #3b0f1a) !important;
        }
        .signpages #remember_me{
            accent-color:var(--brand-wine-700, #7b1e3a);
        }

        /* Kiosk/tablet positioning */
        @media screen and (min-width: 700px) and (max-width: 1100px){

            .min-h-screen{
                justify-content:flex-start !important;
                padding-top:120px !important;
            }

        }

        /* Laptop and desktop: full-height split, brand panel left, form right */
        @media (min-width: 992px){
            .min-h-screen{
                padding:0 !important;
                justify-content:stretch !important;
            }
            .login-logo-wrapper{
                display:none;
            }
            .signpages,
            .signpages > div,
            .signpages .col-md-12,
            .signpages .card,
            .signpages .card > .row{
                width:100%;
                min-height:100vh;
                margin:0;
            }
            .signpages{
                flex:1 1 auto;
            }
            .signpages > div,
            .signpages .col-md-12{
                padding:0;
            }
            .signpages .card{
                border:0;
                border-radius:0;
                box-shadow:none;
            }
            .signpages .details,
            .signpages .login_form{
                flex:0 0 50%;
                max-width:50%;
                display:flex !important;
                align-items:center;
                justify-content:center;
            }
            /* Keep the logo and text above the theme's colour overlay (.details::before) */
            .signpages .details > .position-absolute{
                position:relative !important;
                z-index:1;
                margin:0 !important;
                padding:0 24px !important;
            }
            .signpages .login_form .main-container{
                width:100%;
                max-width:480px;
            }
        }

        /* Back to Website: gold outline pill on the wine panel, wine outline on the cream background */
        /* Phones and tablets: top right, clear of the small logo at the top left */
        .login-back-home{
            position:fixed;
            top:16px;
            right:16px;
            z-index:20;
            display:inline-flex;
            align-items:center;
            gap:8px;
            min-height:40px;
            padding:8px 16px;
            border:1px solid var(--brand-wine-700, #7b1e3a);
            border-radius:999px;
            background:rgba(255, 255, 255, 0.85);
            color:var(--brand-wine-700, #7b1e3a);
            font-size:14px;
            font-weight:500;
            letter-spacing:0.02em;
            text-decoration:none;
            transition:background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }
        /* It sits inside the .row, so undo Bootstrap's full-width ".row > *" sizing */
        .signpages > a.login-back-home{
            left:auto;
            width:auto;
            max-width:calc(100% - 32px);
            margin:0;
            padding:8px 16px;
        }
        .login-back-home svg{
            width:16px;
            height:16px;
            flex:0 0 auto;
        }
        .login-back-home:hover,
        .login-back-home:focus-visible{
            background:var(--brand-wine-700, #7b1e3a);
            color:#fff;
        }
        .login-back-home:focus-visible{
            outline:2px solid var(--brand-gold-500, #de9313);
            outline-offset:2px;
        }
        @media (min-width: 992px){
            .signpages > a.login-back-home{
                top:24px;
                left:24px;
                right:auto;
            }
            .login-back-home{
                border-color:rgba(224, 197, 139, 0.7);
                background:transparent;
                color:#fff;
            }
            .login-back-home svg{
                color:var(--brand-gold-200, #e0c58b);
            }
            .login-back-home:hover,
            .login-back-home:focus-visible{
                background:var(--brand-gold-200, #e0c58b);
                border-color:var(--brand-gold-200, #e0c58b);
                color:var(--brand-wine-900, #3b0f1a);
            }
            .login-back-home:hover svg,
            .login-back-home:focus-visible svg{
                color:var(--brand-wine-900, #3b0f1a);
            }
        }
    </style>
    <a href="{{ route('home') }}" class="login-back-home">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M3 10.5 12 3l9 7.5"/>
            <path d="M5 9.5V20a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1V9.5"/>
        </svg>
        Back to Website
    </a>
    <div >
        <!-- Start::row-1 -->
            <div class="col-md-12">
                <div class="card mb-0">
                    <div class="row row-sm">
                        <div class="col-lg-6 col-xl-5 d-none d-lg-block text-center bg-primary details">
                        <div class="mt-5 pt-4 p-2 position-absolute text-center" >
                            <div class="clearfix"></div>
                            <!-- Center the image with mx-auto -->
                            <!-- <img src="{{ asset('assets/images/svgs/user.svg') }}" class="ht-100 mb-0 mx-auto" alt="user"> -->
                            <a href="{{ route('home') }}" class="d-inline-block" aria-label="Go to the TechSomm website">
                                <img src="{{ asset('images/logofullwhite.png') }}" class="img-fluid mb-0 mx-auto" style="max-width:150px;" alt="TechSomm">
                            </a>
                            <h5 class="my-4 font-bold">Welcome back</h5>
                            <span class="text-white-6 fs-13 mb-5 mt-xl-0">Sign in to open the TechSomm wine kiosk.</span>
                        </div>

                        </div>
                        <div class="col-lg-6 col-xl-7 col-xs-12 col-sm-12 login_form">
                            <div class="main-container container-fluid">
                                <div class="row row-sm">
                                    <div class="card-body mt-2 mb-2">
                                        <div class="clearfix"></div>
                                        <!-- Start of integrated Laravel Form -->
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <h5 class="text-start mb-2">Sign in</h5>
                                            <p class="mb-4 text-muted fs-13 ms-0 text-start">Use your store account email and password.</p>
                                            <!-- Email Address -->
                                            <div class="form-group text-start">
                                                <label class="form-label" for="email">Email</label>
                                                <x-text-input id="email" class="form-control" type="email" placeholder="Enter your email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                                <x-input-error :messages="$errors->get('email')"  class="mt-2" />
                                            </div>

                                            <!-- Password -->
                                            <!-- <div class="form-group text-start mt-4">
                                                <label class="form-label" for="password">Password</label>
                                                <x-text-input id="password" class="form-control" placeholder="Enter your password" type="password" name="password" required autocomplete="current-password" />
                                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                            </div> -->
                                            <div class="form-group text-start mt-4">
                                                <label class="form-label" for="password">Password</label>
                                                <div class="password-wrapper">
                                                    <x-text-input 
                                                        id="password"
                                                        class="form-control pe-5"
                                                        placeholder="Enter your password"
                                                        type="password"
                                                        name="password"
                                                        required
                                                        autocomplete="current-password"
                                                    />
                                                    <span class="toggle-password" onclick="togglePassword()">
                                                        <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                                    </span>

                                                </div>
                                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                            </div>

                                            <!-- Remember Me -->
                                            <div class="block mt-4 text-left">
                                                <label for="remember_me" class="inline-flex items-center">
                                                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                                </label>
                                            </div>

                                            <div class="flex items-center justify-end mt-4">
                                                

                                                <x-primary-button class="btn btn-primary w-100">
                                                    {{ __('Log in') }}
                                                </x-primary-button>
                                            </div>
                                        </form>
                                        <!-- End of integrated Laravel Form -->

                                        <div class="text-start mt-5 ms-0">
                                            @if (Route::has('password.request'))
                                                <!-- <div class="mb-1"><a href="{{ route('password.request') }}">Forgot password?</a></div> -->
                                            @endif
                                            <!-- <div>Don't have an account? <a href="#">Register Here</a></div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- End::row-1 -->
    </div>


    <script>
        function togglePassword(){

            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');

            if(passwordInput.type === 'password'){

                passwordInput.type = 'text';

                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');

            }else{

                passwordInput.type = 'password';

                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>

    <!-- <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form> -->
</x-guest-layout>
