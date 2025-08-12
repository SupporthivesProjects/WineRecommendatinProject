<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-0">
                    <div class="row">
                        <!-- Left Side with Image -->
                        <div class="col-lg-6 col-xl-5 d-none d-lg-block text-center bg-primary details">
                            <div class="mt-5 pt-4 p-2 position-absolute text-center">
                                <div class="clearfix"></div>
                                <img src="{{ asset('assets/images/svgs/user.svg') }}" class="ht-100 mb-0 mx-auto" alt="user">
                                <h5 class="my-4 font-bold text-white">Get in Touch!</h5>
                                <span class="text-white-6 fs-13 mb-5 mt-xl-0">Have questions or feedback? We're here to help and would love to hear from you.</span>
                            </div>
                        </div>

                        <!-- Right Side with Form -->
                        <div class="col-lg-6 col-xl-7 col-xs-12 col-sm-12 login_form">
                            <div class="main-container container-fluid">
                                <div class="row">
                                    <div class="card-body mt-2 mb-2">
                                        <div class="clearfix"></div>
                                        
                                        <!-- Back Button -->
                                        <div class="mb-4">
                                            <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900">
                                                <i class="fas fa-arrow-left mr-1"></i> Back to Home
                                            </a>
                                        </div>

                                        <!-- Success Message -->
                                        @if (session('success'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('success') }}
                                            </div>
                                        @endif

                                        <h5 class="text-start mb-2">Contact Us</h5>
                                        <p class="mb-4 text-muted fs-13 ms-0 text-start">Fill out the form below and we'll get back to you soon</p>
                                        
                                        <form method="POST" action="{{ route('contact.submit') }}">
                                            @csrf
                                            
                                            <!-- Name Field -->
                                            <div class="form-group text-start">
                                                <label class="form-label" for="name">Full Name</label>
                                                <input id="name" name="name" type="text" class="form-control" 
                                                       placeholder="Enter your name" value="{{ old('name') }}" required>
                                                @error('name')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Email Field -->
                                            <div class="form-group text-start mt-4">
                                                <label class="form-label" for="email">Email</label>
                                                <input id="email" name="email" type="email" class="form-control" 
                                                       placeholder="Enter your email" value="{{ old('email') }}" required>
                                                @error('email')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Phone Field -->
                                            <div class="form-group text-start mt-4">
                                                <label class="form-label" for="phone">Phone Number</label>
                                                <input id="phone" name="phone" type="tel" class="form-control" 
                                                       placeholder="Enter your phone number" value="{{ old('phone') }}" required>
                                                @error('phone')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Message Field -->
                                            <div class="form-group text-start mt-4">
                                                <label class="form-label" for="message">Your Message</label>
                                                <textarea id="message" name="message" rows="4" class="form-control" 
                                                          placeholder="Type your message here..." required>{{ old('message') }}</textarea>
                                                @error('message')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Terms Checkbox -->
                                            <div class="form-group text-start mt-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                                    <label class="form-check-label" for="terms">
                                                        I agree to the <a href="#" class="text-primary">Terms and Conditions</a>
                                                    </label>
                                                    @error('terms')
                                                        <div class="text-danger mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    Send Message
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
