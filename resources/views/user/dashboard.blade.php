
@extends('layouts.bootdashboard')
@section('admindashboardcontent')

@push('styles')
<style>
.move-arrow {
    animation: arrowBounce 1s infinite ease-in-out;
    margin-left: 5px;
}

@keyframes arrowBounce {
    0% { transform: translateX(0); }
    50% { transform: translateX(5px); }
    100% { transform: translateX(0); }
}

</style>

@endpush
<!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Wine Recommendation Dashboard</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Recommendation Dashboard</li>
                    </ol>
                </div>
            </div>

            <!-- End::page-header -->
            <!-- Start Row 1 -->

            <!-- Start::row-1 -->
                <div class="row row-sm">
                    <div class="col-sm-12 col-lg-12 col-xl-8">
                        <!-- Purple box row starts -->
                        <div class="row row-sm banner-img">
                            <div class="col-sm-12 col-lg-12 col-xl-12">
                                <div class="card bg-primary custom-card card-box">
                                    <div class="card-body p-4">
                                        <div class="row">
                                            <div class="offset-xl-3 offset-sm-6 col-xl-8 col-sm-6 col-12 text-end">
                                                <h4 class="d-flex mb-3 justify-content-end">
                                                    <span class="fw-bold text-fixed-white ">Welcome !</span>
                                                </h4>
                                                <p class="tx-white-7 mb-1 fs-3  ">Welcome to a world where, <br> every bottle tells a story.</p>
                                            </div>
                                        </div>
                                        <img src="{{ asset('images/3312991-photoroom.png') }}" alt="user-img" style="width:300px;height:200px">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Purple Box row ends -->
                         <!-- Start::row -->
                            <div class="row row-sm">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="card-item">
                                                <div class="card-item-icon card-icon">
                                                    <img src="{{ asset('images/wine-bottle.png') }}">
                                                </div>
                                                <div class="card-item-title mb-2">
                                                    <label class="main-content-label fs-15fw-bold mb-1">Products</label>
                                                    <span class="d-block fs-15 mb-0 text-muted">Welcome to the<br>Cellar</span>
                                                </div>
                                                <div class="card-item-body">
                                                    <div class="card-item-stat">
                                                        <h4 class="fw-bold"></h4>
                                                        <a href="{{ route('user.products') }}" class="btn btn-sm btn-outline-primary mt-2">View
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="card-item">
                                                <div class="card-item-icon card-icon">
                                                <img src="{{ asset('images/form.png') }}">
                                                </div>
                                                <div class="card-item-title mb-2">
                                                    <label class="main-content-label fs-13 fw-bold mb-1">Questionnaires</label>
                                                    <span class="d-block fs-15 mb-0 text-muted">Find Your<br> Perfect Pour</span>
                                                </div>
                                                <div class="card-item-body">
                                                    <div class="card-item-stat">
                                                        <h4 class="fw-bold"></h4>
                                                        <a href="" class="btn btn-sm btn-outline-primary mt-2">View
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-4">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="card-item">
                                                <div class="card-item-icon card-icon">
                                                    <img src="{{ asset('images/red-wine.png') }}">
                                                </div>
                                                <div class="card-item-title  mb-2">
                                                    <label class="main-content-label fs-13 fw-bold mb-1">Featured Products</label>
                                                    <span class="d-block fs-15 mb-0 text-muted">Handpicked Elegance. Uncork the Best.</span>
                                                </div>
                                                <div class="card-item-body">
                                                    <div class="card-item-stat">
                                                        <h4 class="fw-bold"></h4>
                                                        <a href="{{ route('user.featuredproducts') }}" class="btn btn-sm btn-outline-primary mt-2">View
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- End::row -->

                        
                    </div><!-- End of first col -->
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <div class="card custom-card">
                            <div class="card-header justify-content-between">
                                <div class="card-title">Top Picks</div>
                            </div>
                            <div class="card-body">
                                <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="{{ asset('storage/products/chateau_margaux_2015.jpg') }}" class="d-block w-100" alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('storage/products/chateau_margaux_2015.jpg') }}" class="d-block w-100" alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('storage/products/chateau_margaux_2015.jpg') }}" class="d-block w-100" alt="...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- end of row 1 -->
             <!--Second row starts  -->

                <!-- Start::row-6 -->
                    <div class="row row-sm">
                        <div class="col-xl-4">
                            <div class="card custom-card">
                                <img src="{{ asset('images/questinnaire4.jpg') }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h6 class="card-title fw-semibold">First Sip (Basic Level)</h6>
                                    <h3 class="card-title">"Every expert was once a beginner."</h3>
                                    <p class="card-text mb-3 text-muted">Just getting started? Discover your taste preferences with simple, 
                                        fun questions that guide you to wines you’ll love. No pressure—just your first step into the 
                                        world of wine.
                                    </p>
                                        <a href="{{ route('user.featuredproducts') }}" class="btn  btn-primary mt-2">I want to try Now !!
                                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon move-arrow" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                            </svg>
                                        </a>
                            
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card custom-card">
                                <div class="card-body">
                                <h6 class="card-title fw-semibold">Savvy Sipper (Semi-Pro Level)</h6>
                                <h3 class="card-title">"You've got the swirl, now master the sip."</h3>
                                    <p class="card-text mb-3 text-muted">Already know a Cabernet from a Pinot? Dive deeper into regions, aromas, 
                                        and notes. This questionnaire refines your palate and helps you explore the wines that suit your 
                                        evolving taste.
                                    </p>
                                        <a href="{{ route('user.featuredproducts') }}" class="btn  btn-primary mt-2">I want to try Now !!
                                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon move-arrow" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                            </svg>
                                        </a>
                
                                </div>
                                <img src="{{ asset('images/questionnaire2.jpg') }}" class="card-img-bottom" alt="...">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <h6 class="card-title fw-semibold mb-1">Pro (Advanced Level)</h6>
                                    <h3 class="card-title">"Challenge your palate. Define your style."</h3>
                                    <p class="card-text mb-1 text-muted">You speak the language of tannins and terroir. This expert-level quiz 
                                        delves into nuanced wine traits, helping you pinpoint exactly what excites 
                                        your refined wine-loving senses.
                                    </p>
                                    <a href="{{ route('user.featuredproducts') }}" class="btn  btn-primary mt-2">I want to try Now !!
                                        <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon move-arrow" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                        </svg>
                                    </a>
                                </div>
                                <img src="{{ asset('images/questionnaire3.jpg') }}" class="card-img rounded-0" alt="...">
                                
                            </div>
                        </div>
                    </div>
             <!-- Second row ends -->
        </div>
    </div>
@endsection
@push('scripts')

@endpush
