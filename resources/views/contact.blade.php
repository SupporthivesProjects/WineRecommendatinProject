@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
        <style>
            .contact-hero {
                background-image: url('{{ asset('images/BrowseWines3.jpg') }}');
                height: 60vh;
                display: flex;
                align-items: center;
                position: relative;
                margin-bottom: 0;
                background-attachment: fixed;
            }

            .contact-hero::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.6);
            }

            .contact-hero-content {
                position: relative;
                z-index: 1;
                color: white;
                text-align: center;
                width: 100%;
                padding: 0 20px;
            }

            .contact-section {
                padding: 60px 0;
                background-color: #f8f9fa;
            }

            .contact-card {
                background: white;
                border-radius: 8px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            /* Modern Form Styles */
            .contact-form {
                background: #fff;
                border-radius: 12px;
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                border: 1px solid rgba(0, 0, 0, 0.05);
            }

            .contact-form:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
            }

            .back-home-btn {
                color: #6c757d;
                text-decoration: none;
                font-weight: 500;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
            }

            .back-home-btn:hover {
                color: #8b0000;
                transform: translateX(-3px);
            }

            .form-header {
                position: relative;
                padding-bottom: 15px;
            }

            .form-header .header-line {
                width: 60px;
                height: 3px;
                background: #8b0000;
                margin: 15px auto 0;
                border-radius: 3px;
            }

            .form-floating>label {
                color: #6c757d;
            }

            .form-control,
            .form-select {
                border-radius: 8px;
                padding: 1rem 1rem;
                border: 1px solid #e1e5ee;
                transition: all 0.3s ease;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: #8b0000;
                box-shadow: 0 0 0 0.25rem rgba(139, 0, 0, 0.1);
            }

            .form-check-input:checked {
                background-color: #8b0000;
                border-color: #8b0000;
            }

            .btn-primary {
                background-color: #8b0000;
                border: none;
                padding: 12px 24px;
                font-weight: 500;
                letter-spacing: 0.5px;
                border-radius: 8px;
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                background-color: #6a0000;
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(139, 0, 0, 0.2);
            }

            /* Floating labels animation */
            .form-floating>.form-control:focus~label,
            .form-floating>.form-control:not(:placeholder-shown)~label,
            .form-floating>.form-control-plaintext~label,
            .form-floating>.form-select~label {
                transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
                color: #8b0000;
            }

            .btn-primary {
                background-color: #8b0000;
                border-color: #8b0000;
            }

            .btn-primary:hover {
                background-color: #6a0000;
                border-color: #6a0000;
            }
        </style>
    @endpush

    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="contact-hero-content">
            <h1 class="text-white" style="font-family: 'Cinzel Decorative', serif;">Contact Us</h1>
            <p class="lead">We'd love to hear from you</p>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="contact-card">
                        <div class="row">
                            <!-- Contact Form -->
                            <div class="col-lg-7">
                                <div class="contact-form p-4 p-lg-5">
                                    <a href="{{ route('home') }}" class="back-home-btn mb-4">
                                        <i class="fas fa-arrow-left mr-2"></i> Back to Home
                                    </a>

                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    <div class="form-header mb-5 text-center">
                                        <h2 class="fw-bold mb-2">Get In Touch</h2>
                                        <p class="text-muted">We'll get back to you as soon as possible</p>
                                        <div class="header-line"></div>
                                    </div>

                                    <form method="POST" action="{{ route('contact.submit') }}" class="needs-validation"
                                        novalidate>
                                        @csrf

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        id="name" name="name" value="{{ old('name') }}"
                                                        placeholder="John Doe" required>
                                                    <label for="name">Full Name <span
                                                            class="text-danger">*</span></label>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        id="email" name="email" value="{{ old('email') }}"
                                                        placeholder="name@example.com" required>
                                                    <label for="email">Email <span class="text-danger">*</span></label>
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-floating mb-4">
                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                                id="phone" name="phone" value="{{ old('phone') }}"
                                                placeholder="Phone Number" required>
                                            <label for="phone">Phone Number <span class="text-danger">*</span></label>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-floating mb-4">
                                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message"
                                                style="height: 120px;" placeholder="Your Message" required>{{ old('message') }}</textarea>
                                            <label for="message">Your Message <span class="text-danger">*</span></label>
                                            @error('message')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-check mb-4">
                                            <input class="form-check-input @error('terms') is-invalid @enderror"
                                                type="checkbox" id="terms" name="terms"
                                                {{ old('terms') ? 'checked' : '' }} required>
                                            <label class="form-check-label small" for="terms">
                                                I agree to the <a href="#" class="text-decoration-underline">Terms and
                                                    Conditions</a> <span class="text-danger">*</span>
                                            </label>
                                            @error('terms')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <span class="me-2">Send Message</span>
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Contact Info -->
                            <div class="col-lg-5 bg-dark text-white p-5 d-flex flex-column justify-content-center">
                                <h3 class="mb-4">Contact Information</h3>
                                <p class="mb-5">Have questions? Reach out to us through any of these channels.</p>

                                <div class="mb-4">
                                    <h5><i class="fas fa-map-marker-alt mr-2"></i> Our Location</h5>
                                    <p class="ml-4">123 Wine Valley Road, Napa, CA 94558</p>
                                </div>

                                <div class="mb-4">
                                    <h5><i class="fas fa-phone-alt mr-2"></i> Phone</h5>
                                    <p class="ml-4">+1 (555) 123-4567</p>
                                </div>

                                <div class="mb-4">
                                    <h5><i class="fas fa-envelope mr-2"></i> Email</h5>
                                    <p class="ml-4">info@winecellar.com</p>
                                </div>

                                <div class="mt-4">
                                    <h5 class="mb-3">Follow Us</h5>
                                    <div class="social-links">
                                        <a href="#" class="text-white mr-3"><i
                                                class="fab fa-facebook-f fa-lg"></i></a>
                                        <a href="#" class="text-white mr-3"><i
                                                class="fab fa-twitter fa-lg"></i></a>
                                        <a href="#" class="text-white mr-3"><i
                                                class="fab fa-instagram fa-lg"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    {{-- <div class="map-container">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12587.123456789012!2d-122.2875!3d38.2975!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzjCsDE3JzUxLjAiTiAxMjLCsDE3JzE1LjAiVw!5e0!3m2!1sen!2sus!4v1234567890123!5m2!1sen!2sus" 
            width="100%" 
            height="400" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy">
        </iframe>
    </div> --}}
    <script>
        // Form validation
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
@endsection
