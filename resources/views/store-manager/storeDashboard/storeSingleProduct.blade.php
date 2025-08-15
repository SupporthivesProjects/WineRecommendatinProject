
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
            <div>
                <!-- <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a> -->
                <a href="{{ route('store-manager.dashboard') }}" class="btn btn-secondary">
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
                                                    <div class="thumb my-2">
                                                        <img src="{{ asset('storage/' . $product->image1) }}" alt="Product Image">
                                                    </div>
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
                                    <h5>
                                        <span class="text-black">Method : {{ ucfirst($product->Method) }} </span>
                                    </h5>
                                    <h5>
                                        <span class="text-black">Grape Variety : {{ ucfirst($product->grape_variety) }} </span>
                                    </h5>
                                    <h5>
                                        <span class="text-black">Region : {{ ucfirst($product->wine_sub_region) }} </span>
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

                                  
                                    <h6 class="mt-4 fs-16">Tasting Notes</h6>
                                    <p>{{ $product->tasting_notes ?? 'N/A' }}</p>    


                                </div>
                            </div>
                        </div>

                        {{-- Specifications --}}
                        <div class="mt-4">
                            <h5 class="mb-3">Specifications :</h5>
                            <div class="table-responsive">
                            @php
                                // Type icons + colors
                                $typeIcons = [
                                    'red'       => '<i class="fas fa-wine-glass text-danger"></i>',
                                    'white'     => '<i class="fas fa-wine-glass text-warning"></i>',
                                    'sparkling' => '<i class="fas fa-champagne-glasses text-info"></i>',
                                    'ros'       => '<i class="fas fa-wine-glass text-pink"></i>',
                                    'dessert'   => '<i class="fas fa-ice-cream text-warning"></i>',
                                    'bordeaux'  => '<i class="fas fa-wine-bottle text-purple"></i>',
                                ];

                                // Method icons + colors
                                $methodIcons = [
                                    'still'           => '<i class="fas fa-tint text-primary"></i>',
                                    'semi sparkling'  => '<i class="fas fa-bubbles text-info"></i>', // may need a replacement icon if bubbles not available
                                    'sparkling'       => '<i class="fas fa-champagne-glasses text-warning"></i>',
                                    'fortified'       => '<i class="fas fa-wine-bottle text-danger"></i>',
                                ];

                                // General default icon
                                $defaultIcon = '<i class="fas fa-tag text-secondary"></i>';

                                // Extra field icons
                                $extraIcons = [
                                    'sp_mentions'        => '<i class="fas fa-comment-alt text-muted"></i>',
                                    'vintage_year'       => '<i class="fas fa-calendar-alt text-secondary"></i>',
                                    'alcohol_vol'        => '<i class="fas fa-percentage text-danger"></i>',
                                    'nature'             => '<i class="fas fa-leaf text-success"></i>',
                                    'body'               => '<i class="fas fa-balance-scale text-info"></i>',
                                    'time_spent_aging'   => '<i class="fas fa-hourglass-half text-warning"></i>',
                                    'closure_type'       => '<i class="fas fa-wine-bottle text-secondary"></i>',
                                    'serving_temperature'=> '<i class="fas fa-thermometer-half text-primary"></i>',
                                    'ageging_potential'  => '<i class="fas fa-clock text-secondary"></i>',
                                    'cheese_pairing'     => '<i class="fas fa-cheese text-warning"></i>',
                                    'importer_info'      => '<i class="fas fa-truck text-secondary"></i>',
                                ];

                                $type = strtolower($product->type ?? 'n/a');
                                $method = strtolower($product->method ?? 'n/a');
                            @endphp

                            <table class="table mb-0 border table-bordered text-nowrap align-middle">
                                <tbody>
                                    <tr>
                                        <th scope="row">Type</th>
                                        <td>{!! $typeIcons[$type] ?? $defaultIcon !!} {{ ucfirst($product->type) ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Method</th>
                                        <td>{!! $methodIcons[$method] ?? $defaultIcon !!} {{ ucfirst($product->method) ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">SP Mentions</th>
                                        <td>{!! $extraIcons['sp_mentions'] ?? $defaultIcon !!} {{ $product->sp_mentions ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Vintage</th>
                                        <td>{!! $extraIcons['vintage_year'] ?? $defaultIcon !!} {{ $product->vintage_year ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Alcohol Volume</th>
                                        <td>{!! $extraIcons['alcohol_vol'] ?? $defaultIcon !!} {{ $product->alcohol_vol }}%</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Nature</th>
                                        <td>{!! $extraIcons['nature'] ?? $defaultIcon !!} {{ $product->nature }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Body</th>
                                        <td>{!! $extraIcons['body'] ?? $defaultIcon !!} {{ $product->body }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Time spent in Aging</th>
                                        <td>{!! $extraIcons['time_spent_aging'] ?? $defaultIcon !!} {{ $product->time_spent_aging }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Closure Type</th>
                                        <td>{!! $extraIcons['closure_type'] ?? $defaultIcon !!} {{ $product->closure_type }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Serving Temperature</th>
                                        <td>{!! $extraIcons['serving_temperature'] ?? $defaultIcon !!} {{ $product->serving_temperature }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Aging Potential</th>
                                        <td>{!! $extraIcons['ageging_potential'] ?? $defaultIcon !!} {{ $product->ageging_potential ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Cheese pairings</th>
                                        <td style="white-space: normal; word-wrap: break-word;">{!! $extraIcons['cheese_pairing'] ?? $defaultIcon !!} {{ $product->cheese_pairing ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Importer</th>
                                        <td style="white-space: normal; word-wrap: break-word;">{!! $extraIcons['importer_info'] ?? $defaultIcon !!} {{ $product->importer_info ?? 'N/A' }}</td>
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


