
@extends('layouts.bootdashboard')
@section('admindashboardcontent')

<div class="">
    <div class="container">
        <!-- Start::page-header -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
            <div>
                <h2 class="main-content-title fs-24 mb-1">Welcome To Products Board</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
            </div>

            <div>
                <!-- <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a> -->
                <a href="{{ route('user.products') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        <!-- End::page-header -->
        

        <!-- Start::row-1 -->
        <div class="row row-sm">
            <div class="col-lg-12 col-md-12">
                <div class="card custom-card productdesc">
                    <div class="card-body h-100">
                        <div class="row">
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <div class="row">
                                    <div class="col-md-7 offset-md-1 col-sm-9 col-8">
                                        <div class="product-carousel">
                                            <div id="carousel" class="carousel slide" data-bs-ride="false">
                                                <div class="carousel-inner">
                                                    @php
                                                        $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
                                                    @endphp

                                                    @if($primaryImage)
                                                        <div class="thumb my-2">
                                                            <img src="{{ asset('storage/products/' . $primaryImage->image_path) }}" alt="Product Image">
                                                        </div>
                                                    @else
                                                        <div class="thumb my-2">
                                                            <img src="{{ asset('images/default.jpg') }}" alt="Default Product Image">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Right Column --}}
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <div class="mt-4 mb-4">
                                    <h4 class="mt-1 mb-3">{{ $product->wine_name }}</h4>
                                    <h5>
                                        @php
                                            $icons = [
                                                'red' => '<i class="fas fa-wine-glass text-danger" title="Red Wine"></i>',
                                                'white' => '<i class="fas fa-wine-glass text-warning" title="White Wine"></i>',
                                                'sparkling' => '<i class="fas fa-champagne-glasses text-info" title="Sparkling Wine"></i>',
                                                'still' => '<i class="fas fa-tint text-primary" title="Still Wine"></i>',
                                            ];

                                            $textClasses = [
                                                'red' => 'text-danger',
                                                'white' => 'text-warning',
                                                'sparkling' => 'text-info',
                                                'still' => 'text-primary',
                                            ];

                                            $type = $product->type ?? 'unknown';
                                        @endphp

                                        {!! $icons[$type] ?? '<i class="fas fa-question-circle"></i>' !!}
                                        <span class="{{ $textClasses[$type] ?? 'text-muted' }}">{{ ucfirst($type) }} Wine</span>
                                    </h5>
                                    <p class="text-muted float-start me-3">
                                        <span class="fe fe-star text-warning"></span>
                                        <span class="fe fe-star text-warning"></span>
                                        <span class="fe fe-star text-warning"></span>
                                        <span class="fe fe-star text-warning"></span>
                                        <span class="fe fe-star"></span>
                                    </p>
                                    <p class="text-muted mb-4">( 135 Customers Review )</p>

                                    @if($product->discounts)
                                        <h6 class="text-success text-uppercase">{{ $product->discounts }} % Off</h6>
                                    @endif

                                    <h5 class="mb-2">
                                        Price:
                                        @if($product->discounts)
                                            @php
                                                $discountAmount = $product->retail_price * ($product->discounts / 100);
                                                $discountedPrice = $product->retail_price - $discountAmount;
                                            @endphp
                                            <span class="text-muted me-2"><del>₹{{ number_format($product->retail_price, 2) }} INR</del></span>
                                            <b>₹{{ number_format($discountedPrice, 2) }} INR</b>
                                        @else
                                            <b>₹{{ number_format($product->retail_price, 2) }} INR</b>
                                        @endif

                                    </h5>

                                    <h6 class="mt-4 fs-16">Description</h6>
                                    <p>{{ $product->tasting_notes ?? 'N/A' }}</p>

                                    <div class="d-flex mt-2">
                                        <div class="mt-2 sizes">Quantity:</div>
                                        <div class="d-flex ms-2">
                                            <form method="POST" action="">
                                                @csrf
                                                <div class="form-group">
                                                    <select name="quantity" class="form-control wd-150">
                                                        @for ($i = 1; $i <= 4; $i++)
                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Specifications --}}
                        <div class="mt-4">
                            <h5 class="mb-3">Specifications :</h5>
                            <div class="table-responsive">
                                <table class="table mb-0 border table-bordered text-nowrap">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Type</th>
                                            <td>{{ $product->type ? ucfirst($product->type) : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Brand</th>
                                            <td>{{ $product->winery ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Color</th>
                                            <td>{{ $product->color ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Alcohol Volume</th>
                                            <td>{{ $product->alcohol_vol }}%</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Closure Type</th>
                                            <td>{{ $product->closure_type }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Vintage Year</th>
                                            <td>{{ $product->vintage_year }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Country</th>
                                            <td>{{ $product->country }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Designation</th>
                                            <td>{{ $product->designation ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">SP Mentions</th>
                                            <td>{{ $product->sp_mentions ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Wine Story</th>
                                            <td style="white-space: normal; word-wrap: break-word;">{{ $product->wine_story ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> {{-- card-body --}}
                </div>
            </div>
            <!-- All Ratings and Reviews -->
            <div class="col-xl-12 mt-4">
                <div class="card">
                    <div>
                        <div class="d-flex p-3">
                            <h5 class="float-start main-content-label mb-0 mt-2">All Ratings and Reviews</h5>
                            <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm float-end ms-auto">Top Rated</a>
                        </div>
                        <div class="media mt-0 p-4 border-bottom border-top">
                            <div class="d-flex me-3">
                                <a href="javascript:void(0);"><img class="media-image avatar avatar-md rounded-circle" alt="64x64" src="../assets/images/faces/8.jpg"> </a>
                            </div>
                            <div class="media-body">
                                <h5 class="mt-0 mb-1 fw-medium fs-16">Bruce Tran
                                    <span class="fs-14 ms-0" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="verified"><i class="fa fa-check-circle-o text-success"></i></span>
                                </h5>
                                <span class="text-muted fs-13">Tue, 20 Mar 2020</span>
                                <div class="text-warning mt-1">
                                    <i class="bx bxs-star active"></i>
                                    <i class="bx bxs-star active"></i>
                                    <i class="bx bxs-star active"></i>
                                    <i class="bx bxs-star active"></i>
                                    <i class="bx bxs-star"></i>
                                    </div>
                                <p class="font-13  mb-2 mt-2">
                                    Lorem Ipsum available, quis Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et  nostrud exercitation ullamco laboris   commodo consequat.
                                </p>
                                <a href="javascript:void(0);" class="me-2"><span class="badge bg-primary">Helpful</span></a>
                                <a href="javascript:void(0);" class="me-2"><span class="">Comment</span></a>
                                <a href="javascript:void(0);" class="me-2"><span class="">Report</span></a>
                            </div>
                        </div>
                        <div class="media mt-0  p-4 border-bottom">
                            <div class="d-flex me-3">
                                <a href="javascript:void(0);"><img class="media-image avatar avatar-md rounded-circle" alt="64x64" src="../assets/images/faces/3.jpg"> </a>
                            </div>
                            <div class="media-body">
                                <h5 class="mt-0 mb-1 fw-medium fs-16">Mina Harpe
                                    <span class="fs-14 ms-0" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="verified"><i class="fa fa-check-circle-o text-success"></i></span>
                                </h5>
                                <span class="text-muted fs-13">Tue, 20 Mar 2020</span>
                                <div class="text-warning mt-1">
                                    <i class="bx bxs-star active"></i>
                                    <i class="bx bxs-star active"></i>
                                    <i class="bx bxs-star active"></i>
                                    <i class="bx bxs-star active"></i>
                                    <i class="bx bxs-star"></i>
                                    </div>
                                <p class="font-13  mb-2 mt-2">
                                    Lorem Ipsum available, quis Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et  nostrud exercitation ullamco laboris   commodo consequat.
                                </p>
                                <a href="javascript:void(0);" class="me-2"><span class="badge bg-primary">Helpful</span></a>
                                <a href="javascript:void(0);" class="me-2"><span class="">Comment</span></a>
                                <a href="javascript:void(0);" class="me-2"><span class="">Report</span></a>
                            </div>
                        </div>
                        <div class="media mt-0 p-4 border-bottom">
                            <div class="d-flex me-3">
                                <a href="javascript:void(0);"><img class="media-image avatar avatar-md rounded-circle" alt="64x64" src="../assets/images/faces/5.jpg"> </a>
                            </div>
                            <div class="media-body">
                                <h5 class="mt-0 mb-1 fw-medium fs-16">Maria Quinn
                                    <span class="fs-14 ms-0" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="verified"><i class="fa fa-check-circle-o text-success"></i></span>
                                </h5>
                                <span class="text-muted fs-13">Tue, 20 Mar 2020</span>
                                <div class="text-warning mt-1">
                                    <i class="bx bxs-star active"></i>
                                    <i class="bx bxs-star active"></i>
                                    <i class="bx bxs-star active"></i>
                                    <i class="bx bxs-star active"></i>
                                    <i class="bx bxs-star text-light"></i>
                                    </div>
                                <p class="font-13  mb-2 mt-2">
                                    Lorem Ipsum available, quis Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et  nostrud exercitation ullamco laboris   commodo consequat.
                                </p>
                                <a href="javascript:void(0);" class="me-2"><span class="badge bg-primary">Helpful</span></a>
                                <a href="javascript:void(0);" class="me-2"><span class="">Comment</span></a>
                                <a href="javascript:void(0);" class="me-2"><span class="">Report</span></a>
                            </div>
                        </div>
                        <div class="d-grid">
                            <a class="text-center w-100 p-3 fw-medium" href="javascript:void(0);">See All Reviews</a>
                        </div>
                    </div>
                    <div class="border-top px-4 pb-2 pt-4">
                        <h5 class="mb-4">Leave Comment</h5>
                        <div class="mb-1">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <div class="mb-3 fw-medium">Your Name</div> <input class="form-control" placeholder="Your Name" type="text">
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="mb-3 fw-medium">Email Address</div> <input class="form-control" placeholder="Email Address" type="text">
                                </div>
                            </div>
                        </div>
                        <span class="star-rating">
                            <a href="javascript:void(0);"><i class="icofont-ui-rating icofont-2x"></i></a>
                            <a href="javascript:void(0);"><i class="icofont-ui-rating icofont-2x"></i></a>
                            <a href="javascript:void(0);"><i class="icofont-ui-rating icofont-2x"></i></a>
                            <a href="javascript:void(0);"><i class="icofont-ui-rating icofont-2x"></i></a>
                            <a href="javascript:void(0);"><i class="icofont-ui-rating icofont-2x"></i></a>
                        </span>
                        <form>
                            <div class="form-group">
                                <div class="mb-3 fw-medium">Your Comment</div>
                                <textarea class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary mt-3 mb-0" type="button">Post your review</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <div class="col-xl-12 mt-4">
                <div class="card">
                    <div class="d-flex p-3 border-bottom">
                        <h5 class="main-content-label mb-0 mt-2">Related Products</h5>
                    </div>
                    <div class="p-4">
                        <div class="row row-sm">
                            @foreach ($relatedProducts as $product)
                                <div class="col-xl-4 wine-card-container" data-type="{{ strtolower($product->type) }}"
                                    data-vintage-year="{{ $product->vintage_year }}"
                                    data-winery="{{ $product->winery }}"
                                    data-retail-price="{{ $product->retail_price }}"
                                    data-country="{{ $product->country }}">
                                    <div class="card custom-card wine-card">
                                        <!-- Image -->
                                        <div class="image-wrapper" style="position: relative;">
                                            @php
                                                $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
                                            @endphp
                                            <img src="{{ $primaryImage ? asset('storage/products/' . $primaryImage->image_path) : asset('images/default.jpg') }}" class="card-img-top rounded-0" alt="{{ $product->wine_name }}">
                                            
                                            @if ($product->is_featured == 1)
                                                <span class="featured-badge">Featured</span>
                                            @endif
                                        </div>

                                        <!-- Product Info -->
                                        <div class="card-body">
                                            <h5 class="card-title fw-semibold">{{ $product->wine_name }}</h5>
                                            @php
                                                $type = strtolower($product->type);
                                                $emoji = match($type) {
                                                    'red' => '🍷',
                                                    'white' => '🥂',
                                                    'sparkling' => '✨',
                                                    default => ''
                                                };
                                            @endphp
                                            <p>
                                                <strong>Type:</strong> {{ ucfirst($type) }}
                                                @if ($emoji)
                                                    <span style="font-size: 1.5em;">{{ $emoji }}</span>
                                                @endif
                                            </p>

                                            <p><strong>Vintage Year:</strong> {{ $product->vintage_year }}</p>
                                            <a href="{{ route('user.productdetails', $product->id) }}" class="btn btn-dark mt-2 rounded-0">
                                                I want to try Now !!
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
                                    


        </div>
        <!--End::row-1 -->
    </div>
</div>

@endsection




