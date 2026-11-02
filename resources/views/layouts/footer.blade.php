<style>
    /* TechSomm footer: deep wine with light text, gold Submit (was navy and template purple) */
    .landing-footer {
        background-color: #3b0f1a !important;
    }
    .landing-footer,
    .landing-footer p,
    .landing-footer h4,
    .landing-footer .main-footer {
        color: rgba(255, 255, 255, 0.85) !important;
    }
    .landing-footer a {
        color: rgba(255, 255, 255, 0.85) !important;
    }
    .landing-footer a:hover {
        color: #e0c58b !important;
    }
    .landing-footer hr {
        border-top-color: rgba(224, 197, 139, 0.25) !important;
    }
    .landing-footer #button-addon2 {
        background-color: #de9313 !important;
        border-color: #de9313 !important;
        color: #2d0606 !important;
        font-weight: 500;
    }
    .landing-footer #button-addon2:hover {
        background-color: #e0c58b !important;
        border-color: #e0c58b !important;
    }
    .landing-footer .btn-icon {
        background-color: rgba(224, 197, 139, 0.15) !important;
        color: #e0c58b !important;
    }
</style>
<section class="section landing-footer pb-0 text-fixed-white demo-footer px-4">
            <div class="container">
                <div class="row">
                    <div class="p-2 mb-0">
                        <div class="card-body p-0">
                            <div class="top-footer">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-12 col-md-12 reveal revealleft position-relative">
                                        <a href="{{ route('home') }}"><img loading="lazy" alt="TechSomm" class="logo mb-3"
                                                src="{{ asset('images/logofullwhite.png') }}" style="width:180px;"></a>
                                        
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-md-4 reveal revealleft position-relative">
                                        <ul class="mb-5 mb-lg-0 ps-0">
                                            <li><a href="{{ route('home') }}#HIW">How it Works?</a></li>
                                            <li><a href="{{ route('home') }}#featuredwines">Browse Wines</a></li>
                                            <li><a href="{{ route('home') }}#pairing">Pairing Wines</a></li>
                                            <li><a href="{{ route('home') }}#testimonials">Whats users say</a></li>
                                            <li><a href="{{ route('home') }}#Moments">Moments</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-md-4 reveal revealleft position-relative ">
                                        
                                        <ul class="mb-5 mb-lg-0 ps-0">
                                            <li><a href="{{ route('contact') }}">Contact US</a></li>
                                            <li><a href="{{ route('about') }}">About Us</a></li>
                                            <li><a href="{{ route('services') }}">Services</a></li>
                                            <li><a href="{{ route('contact') }}">Careers @ TechSomm </a></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-4 col-sm-12 col-md-4 reveal revealleft">
                                        <div class="">
                                            <h4 style="font-size: 20px;">Wine Recommender</h4>
                                            <p class="mb-5 my-2  mb-lg-3">Discover Your perfect wine match with our intelligent recommendation system.
                                            </p>
                                            <!-- <a href="index.html"><img loading="lazy" alt="" class="logo mb-3"
                                                src="{{ asset('images/logoblackred.png') }}" style="width:100px;"></a> -->
                                            <p></p>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter your email"
                                                        aria-label="Example text with button addon"
                                                       >
                                                    <button class="btn btn-primary" type="button"
                                                        id="button-addon2">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btn-list mt-6 mb-3">
                                            <button type="button" class="btn btn-icon rounded-pill"><i
                                                    class="fs-14 fe fe-facebook"></i></button>
                                            <button type="button" class="btn btn-icon rounded-pill"><i
                                                    class="fs-14 fe fe-twitter"></i></button>
                                            <button type="button" class="btn btn-icon rounded-pill"><i
                                                    class="fs-14 fe fe-instagram"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-0">
                            
                        </div>
                       

                    </div>
                </div>
            </div>
            <footer class="main-footer px-0 text-center pt-0">
                <div class="container pt-0">
                    <div class="row text-center">
                        <div class="col-md-12 col-sm-12">
                            Copyright © <span id="year"></span> <a href="javascript:void(0)">Supporthives</a>.
                            Designed with <span class="fa fa-heart text-danger"></span> by <a
                                href="javascript:void(0)"> Supporthives Technologies </a> All rights reserved.
                        </div>
                    </div>
                </div>
            </footer>
</section>
