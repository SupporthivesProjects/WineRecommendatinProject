<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div >
        <!-- Start::row-1 -->
            <div class="col-md-12">
                <div class="card mb-0">
                    <div class="row row-sm">
                        <div class="col-lg-6 col-xl-5 d-none d-lg-block text-center bg-primary details">
                        <div class="mt-5 pt-4 p-2 position-absolute text-center" >
                            <div class="clearfix"></div>
                            <!-- Center the image with mx-auto -->
                            <img src="{{ asset('assets/images/svgs/user.svg') }}" class="ht-100 mb-0 mx-auto" alt="user">
                            <h5 class="my-4 font-bold">Welcome Back !</h5>
                            <span class="text-white-6 fs-13 mb-5 mt-xl-0">Signup to create, discover and connect with the global community</span>
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
                                            <h5 class="text-start mb-2">Signin to Your Account</h5>
                                            <p class="mb-4 text-muted fs-13 ms-0 text-start">Signin to access Admin Dashboard</p>
                                            <!-- Email Address -->
                                            <div class="form-group text-start">
                                                <label class="form-label" for="email">Email</label>
                                                <x-text-input id="email" class="form-control" type="email" placeholder="Enter your email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                                <x-input-error :messages="$errors->get('email')"  class="mt-2" />
                                            </div>

                                            <!-- Password -->
                                            <div class="form-group text-start mt-4">
                                                <label class="form-label" for="password">Password</label>
                                                <x-text-input id="password" class="form-control" placeholder="Enter your password" type="password" name="password" required autocomplete="current-password" />
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
                                                <button 
                                                    type="submit" 
                                                    class="ms-3 btn btn-primary w-100"
                                                    data-loader
                                                    data-loading-text="Signing in..."
                                                    data-min-loading-time="800"
                                                >
                                                    {{ __('Log in') }}
                                                </button>
                                            </div>
                                        </form>
                                        <!-- End of integrated Laravel Form -->

                                        <div class="text-start mt-5 ms-0">
                                            @if (Route::has('password.request'))
                                                <div class="mb-1"><a href="{{ route('password.request') }}">Forgot password?</a></div>
                                            @endif
                                            <div>Don't have an account? <a href="{{ route('register') }}">Register Here</a></div>
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

    <!-- Include Button Loader Assets -->
    <link rel="stylesheet" href="{{ asset('assets/css/button-loader.css') }}">
    <script src="{{ asset('assets/js/button-loader.js') }}"></script>

    <!-- Handle validation errors -->
    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Reset all buttons if there are validation errors
            window.ButtonLoader.resetAll();
        });
    </script>
    @endif
</x-guest-layout>
