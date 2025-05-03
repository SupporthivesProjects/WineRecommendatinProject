
@extends('layouts.bootdashboard')
@section('admindashboardcontent')

<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Start::page-header -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
            <div>
                <h2 class="main-content-title fs-24 mb-1">Welcome To Products Board</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
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
                                    <div class="col-2">
                                        <div class="clearfix carousel-slider">
                                            <div id="thumbcarousel" class="carousel slide" data-bs-interval="false">
                                                <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        @foreach (['image1', 'image2', 'image3', 'image4'] as $index => $img)
                                                            @if($product->$img)
                                                                <div data-bs-target="#carousel" data-bs-slide-to="{{ $index }}" class="thumb my-2">
                                                                    <img src="{{ asset('storage/' . $product->$img) }}" alt="thumb-{{ $index }}">
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7 offset-md-1 col-sm-9 col-8">
                                        <div class="product-carousel">
                                            <div id="carousel" class="carousel slide" data-bs-ride="false">
                                                <div class="carousel-inner">
                                                    @foreach (['image1', 'image2', 'image3', 'image4'] as $index => $img)
                                                        @if($product->$img)
                                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                                <img src="{{ asset('storage/' . $product->$img) }}" alt="product-image-{{ $index }}" class="img-fluid mx-auto d-block">
                                                            </div>
                                                        @endif
                                                    @endforeach
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
                                    <p>{{ $product->wine_story }}</p>

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
                                            <th scope="row">Tasting Notes</th>
                                            <td style="white-space: normal; word-wrap: break-word;">{{ $product->tasting_notes ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> {{-- card-body --}}
                </div>
            </div>
        </div>
        <!--End::row-1 -->
    </div>
</div>

@endsection


