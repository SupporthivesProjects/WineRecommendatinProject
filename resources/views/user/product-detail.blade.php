@extends('layouts.bootdashboard')
@section('admindashboardcontent')
    <style>
        /* Star Rating Styles */
        .rating-stars {
            display: inline-block;
            unicode-bidi: bidi-override;
            direction: ltr;
        }

        .rating-stars input[type="radio"] {
            display: none;
        }

        .rating-stars .star-label {
            color: #ddd;
            cursor: pointer;
            display: inline-block;
            padding: 0 2px;
        }

        .rating-stars .bx {
            font-size: 1.5rem;
            transition: color 0.2s;
        }

        .rating-stars .star-label:hover .bx,
        .rating-stars .star-label:hover ~ .star-label .bx,
        .rating-stars input[type="radio"]:checked ~ .star-label .bx,
        .rating-stars input[type="radio"]:checked ~ .star-label ~ .star-label .bx {
            color: #ddd;
        }

        .rating-stars .star-label .bxs-star,
        .rating-stars .star-label:hover .bx,
        .rating-stars input[type="radio"]:checked ~ .star-label .bx,
        .rating-stars input[type="radio"]:checked ~ .star-label ~ .star-label .bx {
            color: #ffc107;
        }
        .product-main-image {
            width: 100%;
            height: 450px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .page-header-breadcrumb > div {
                margin-bottom: 20px;
            }

            .page-header-breadcrumb > div:last-child {
                margin-bottom: 0;
            }
        }

        .card.custom-card.wine-card .image-wrapper img.card-img-top {
            object-fit: contain;
            width: 308px;
            height: 287px;
            display: flex;
            margin-left: auto;
            margin-right: auto;
        }
        .image-wrapper {
            padding: 10px;
        }
    </style>
    

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const starInputs = document.querySelectorAll('.rating-stars input[type="radio"]');
            const starLabels = document.querySelectorAll('.rating-stars .star-label');
            
            // Initialize stars based on checked input
            function updateStars() {
                const checkedInput = document.querySelector('.rating-stars input[type="radio"]:checked');
                if (!checkedInput) return;
                
                const rating = parseInt(checkedInput.value);
                starLabels.forEach((label, index) => {
                    const star = label.querySelector('i');
                    if (index < rating) {
                        star.classList.remove('bx-star');
                        star.classList.add('bxs-star');
                    } else {
                        star.classList.remove('bxs-star');
                        star.classList.add('bx-star');
                    }
                });
            }
            
            // Initialize on page load
            updateStars();
            
            // Handle click events
            starInputs.forEach(input => {
                input.addEventListener('change', updateStars);
            });
            
            // Hover effect
            starLabels.forEach((label, index) => {
                label.addEventListener('mouseenter', () => {
                    starLabels.forEach((l, i) => {
                        const star = l.querySelector('i');
                        if (i <= index) {
                            star.classList.remove('bx-star');
                            star.classList.add('bxs-star');
                        } else {
                            star.classList.remove('bxs-star');
                            star.classList.add('bx-star');
                        }
                    });
                });
                
                label.addEventListener('mouseleave', updateStars);
            });
        });
    </script>

    <div class="">
        <div class="container">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Products Boards</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Products</li>
                    </ol>
                </div>

                <div>
                    <a href="{{ route('user.cart') }}" class="btn btn-dark me-2">
                        View Cart (<span id="cart-count">{{ count($cart ?? []) }}</span>)
                    </a>

                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
                <!-- <div>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div> -->
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
                                                            <img src="{{ asset('storage/' . $product->image1) }}"
                                                                alt="Product Image" class="product-main-image">
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
                                                    'red' =>
                                                        '<i class="fas fa-wine-glass text-danger" title="Red Wine"></i>',
                                                    'white' =>
                                                        '<i class="fas fa-wine-glass text-warning" title="White Wine"></i>',
                                                    'sparkling' =>
                                                        '<i class="fas fa-champagne-glasses text-info" title="Sparkling Wine"></i>',
                                                    'still' =>
                                                        '<i class="fas fa-tint text-primary" title="Still Wine"></i>',
                                                ];

                                                $textClasses = [
                                                    'red' => 'text-danger',
                                                    'white' => 'text-warning',
                                                    'sparkling' => 'text-info',
                                                    'still' => 'text-primary',
                                                ];

                                                $type = strtolower(trim($product->type ?? 'unknown'));
                                            @endphp

                                            {!! $icons[$type] ?? '<i class="fas fa-question-circle"></i>' !!}
                                            <span class="{{ $textClasses[$type] ?? 'text-muted' }}">{{ ucfirst($type) }}
                                                Wine</span>
                                        </h5>
                                        <h5>
                                            <span class="text-black">Method : {{ ucfirst($product->Method) }} </span>
                                        </h5>
                                        <h5>
                                            <span class="text-black">Grape Variety : {{ ucfirst($product->grape_variety) }}
                                            </span>
                                        </h5>
                                        <h5>
                                            <span class="text-black">Region : {{ ucfirst($product->wine_sub_region) }}
                                            </span>
                                        </h5>

                                        <p class="text-muted float-start me-3">
                                            @if($totalReviews > 0)
                                                <span class="fw-medium">{{ number_format($averageRating, 1) }}/5.0</span>
                                            @else
                                                <span class="text-muted">No ratings yet</span>
                                            @endif
                                        </p>
                                        <p class="text-muted mb-4">({{ $totalReviews }} {{ Str::plural('Review', $totalReviews) }})</p>

                                        @if ($product->discounts)
                                            <h6 class="text-success text-uppercase">{{ $product->discounts }} % Off</h6>
                                        @endif

                                        <h5 class="mb-2">
                                            Price:
                                            @if ($product->discounts)
                                                @php
                                                    $discountAmount =
                                                        $product->retail_price * ($product->discounts / 100);
                                                    $discountedPrice = $product->retail_price - $discountAmount;
                                                @endphp
                                                <span class="text-muted me-2"><del>₹{{ number_format($product->retail_price, 2) }}
                                                        INR</del></span>
                                                <b>₹{{ number_format($discountedPrice, 2) }} INR</b>
                                            @else
                                                <b>₹{{ number_format($product->retail_price, 2) }} INR</b>
                                            @endif

                                        </h5>


                                        <h6 class="mt-4 fs-16">Tasting Notes</h6>
                                        <p>{{ $product->tasting_notes ?? 'N/A' }}</p>
                                        <div class="mt-4">
                                            <button
                                                class="btn border border-dark w-100 rounded-0 buy-now-btn {{ collect($cart ?? [])->pluck('id')->contains($product->id) ? 'btn-dark' : 'btn-light' }}"
                                                data-product-id="{{ $product->id }}"
                                                data-product-name="{{ $product->wine_name }}"
                                                data-product-price="{{ $product->retail_price }}">

                                                {{ collect($cart ?? [])->pluck('id')->contains($product->id) ? 'Remove from Cart' : 'Buy Now' }}

                                            </button>
                                        </div>

                                        <div class="d-flex mt-2">
                                            <!-- <div class="mt-2 sizes">Quantity:</div>
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
                                                </div> -->
                                        </div>
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
                                            'red' => '<i class="fas fa-wine-glass text-danger"></i>',
                                            'white' => '<i class="fas fa-wine-glass text-warning"></i>',
                                            'sparkling' => '<i class="fas fa-champagne-glasses text-info"></i>',
                                            'ros' => '<i class="fas fa-wine-glass text-pink"></i>',
                                            'dessert' => '<i class="fas fa-ice-cream text-warning"></i>',
                                            'bordeaux' => '<i class="fas fa-wine-bottle text-purple"></i>',
                                        ];

                                        // Method icons + colors
                                        $methodIcons = [
                                            'still' => '<i class="fas fa-tint text-primary"></i>',
                                            'semi sparkling' => '<i class="fas fa-bubbles text-info"></i>', // may need a replacement icon if bubbles not available
                                            'sparkling' => '<i class="fas fa-champagne-glasses text-warning"></i>',
                                            'fortified' => '<i class="fas fa-wine-bottle text-danger"></i>',
                                        ];

                                        // General default icon
                                        $defaultIcon = '<i class="fas fa-tag text-secondary"></i>';

                                        // Extra field icons
                                        $extraIcons = [
                                            'sp_mentions' => '<i class="fas fa-comment-alt text-muted"></i>',
                                            'vintage_year' => '<i class="fas fa-calendar-alt text-secondary"></i>',
                                            'alcohol_vol' => '<i class="fas fa-percentage text-danger"></i>',
                                            'nature' => '<i class="fas fa-leaf text-success"></i>',
                                            'body' => '<i class="fas fa-balance-scale text-info"></i>',
                                            'time_spent_aging' => '<i class="fas fa-hourglass-half text-warning"></i>',
                                            'closure_type' => '<i class="fas fa-wine-bottle text-secondary"></i>',
                                            'serving_temperature' =>
                                                '<i class="fas fa-thermometer-half text-primary"></i>',
                                            'ageging_potential' => '<i class="fas fa-clock text-secondary"></i>',
                                            'cheese_pairing' => '<i class="fas fa-cheese text-warning"></i>',
                                            'importer_info' => '<i class="fas fa-truck text-secondary"></i>',
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
                                                <th scope="row">Vintage <small>[ Please check for recent editions with our store manager ]</small></th>
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
                                                <td>{!! $extraIcons['ageging_potential'] ?? $defaultIcon !!} {{ $product->ageing_potential ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Cheese pairings</th>
                                                <td style="white-space: normal; word-wrap: break-word;">
                                                    {!! $extraIcons['cheese_pairing'] ?? $defaultIcon !!} {{ $product->cheese_pairing ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Importer</th>
                                                <td style="white-space: normal; word-wrap: break-word;">
                                                    {!! $extraIcons['importer_info'] ?? $defaultIcon !!} {{ $product->importer_info ?? 'N/A' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div> {{-- card-body --}}
                    </div>
                </div>
                <!-- All Ratings and Reviews -->
                {{-- <div class="col-xl-12 mt-4">
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
                                <button class="btn btn-primary mt-3 mb-0" type="button">Post your notes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}

                <!-- Reviews Section -->
                <div class="col-xl-12 mt-4">
                    <div class="card">
                        <!-- Add Review Form -->
                        @auth
                            <div class="border-top px-4 pb-2 pt-4">
                                <h5 class="mb-4">Your Tasting Notes</h5>

                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                @if ($hasUserReviewed = $product->reviews->where('user_id', auth()->id())->isNotEmpty())
                                    <div class="alert alert-info">
                                        You have already submitted a tasting note for this product.
                                    </div>
                                @else
                                    <form action="{{ route('user.reviews.store') }}" method="POST" id="reviewForm">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                                        <div class="mb-4">
                                            <div class="mb-2 fw-medium">Your Rating</div>
                                            <div class="rating-stars">
                                                @php
                                                    $selectedRating = old('rating', 5);
                                                @endphp
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <input type="radio" id="star{{ $i }}" name="rating"
                                                        value="{{ $i }}"
                                                        {{ $selectedRating == $i ? 'checked' : '' }}>
                                                    <label for="star{{ $i }}" class="star-label"
                                                        title="{{ $i }} star(s)">
                                                        <i class="bx {{ $i <= $selectedRating ? 'bxs' : 'bx' }}-star"></i>
                                                    </label>
                                                @endfor
                                                <span class="ms-2 text-muted">(Click to rate)</span>
                                            </div>
                                            @error('rating')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="comment" class="form-label fw-medium">Your Note</label>
                                            <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="4"
                                                placeholder="Share your experience with this product..." required>{{ old('comment') }}</textarea>
                                            @error('comment')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary px-4">
                                                <i class="bx bx-send me-1"></i> Post Your Notes
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        @else
                            <div class="border-top px-4 py-4 text-center">
                                <p class="mb-0">Please <a href="{{ route('login') }}"
                                        class="text-primary fw-medium">login</a> to submit a note.</p>
                            </div>
                        @endauth

                        <!-- Reviews List -->
                        <div>
                            <div class="d-flex p-3 border-bottom">
                                <h5 class="main-content-label mb-0 mt-2">
                                    {{ $totalReviews }} Review(s) for {{ $product->wine_name }}
                                    @if ($totalReviews > 0)
                                        <span class="ms-2">
                                            <i class="bx bxs-star"></i> {{ number_format($averageRating, 1) }}
                                        </span>
                                    @endif
                                </h5>
                                @if ($totalReviews > 0)
                                    <div class="ms-auto">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle"
                                                data-bs-toggle="dropdown">
                                                Sort by
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Newest</a></li>
                                                <li><a class="dropdown-item" href="#">Highest Rating</a></li>
                                                <li><a class="dropdown-item" href="#">Lowest Rating</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if ($totalReviews > 0)
                                <!-- Rating Distribution -->
                                <div class="px-4 py-3 border-bottom">
                                    @foreach ($ratingDistribution as $stars => $count)
                                        @if ($count > 0)
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="text-nowrap me-2" style="width: 80px;">
                                                    <i class="bx bxs-star"></i> {{ $stars }}
                                                </div>
                                                <div class="progress flex-grow-1" style="height: 10px;">
                                                    @php
                                                        $percentage = ($count / $totalReviews) * 100;
                                                    @endphp
                                                    <div class="progress-bar bg-warning" role="progressbar"
                                                        style="width: {{ $percentage }}%"
                                                        aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <div class="ms-2 text-muted small" style="width: 40px;">
                                                    {{ $count }}
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <!-- Reviews -->
                                @foreach ($reviews as $review)
                                    <div class="media p-4 border-bottom">
                                        <div class="d-flex me-3">
                                            <div
                                                class="avatar avatar-md rounded-circle bg-light text-primary d-flex align-items-center justify-content-center">
                                                {{ substr($review->user->first_name, 0, 1) }}{{ substr($review->user->last_name, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <h5 class="mt-0 mb-1 fw-medium fs-16">
                                                    {{ $review->user->first_name }} {{ $review->user->last_name }}
                                                    @if ($review->user->id === $product->user_id)
                                                        <span class="badge bg-primary ms-2">Owner</span>
                                                    @endif
                                                </h5>
                                                <span class="badge bg-light text-dark"><i class="bx bxs-star"></i>{{ $review->rating }}</span>
                                            </div>
                                            <span class="text-muted fs-13">{{ $review->created_at->format('D, d M Y') }}</span>

                                            <p class="mb-2 mt-2">{{ $review->comment }}</p>

                                            <div class="d-flex align-items-center">
                                                <button class="btn btn-sm btn-outline-primary me-2" type="button">
                                                    <i class="bx bx-like me-1"></i> Helpful
                                                    <span
                                                        class="badge bg-light text-dark ms-1">{{ $review->helpful_count ?? 0 }}</span>
                                                </button>
                                                @auth
                                                    @if (auth()->id() === $review->user_id)
                                                        <form action="{{ route('user.reviews.destroy', $review->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('Are you sure you want to delete this review?')">
                                                                <i class="bx bx-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Pagination -->
                                @if ($reviews->hasPages())
                                    <div class="px-4 py-3 d-flex justify-content-center">
                                        {{ $reviews->links() }}
                                    </div>
                                @endif
                            @else
                                <div class="p-4 text-center">
                                    <p class="text-muted mb-0">No reviews yet. Be the first to review this product!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- End Reviews Section -->

                <!-- Related Products -->
                <div class="col-xl-12 mt-4">
                    <div class="card">
                        <div class="d-flex p-3 border-bottom">
                            <h5 class="main-content-label mb-0 mt-2">Related Products</h5>
                        </div>
                        <div class="p-4">
                            <div class="row row-sm">
                                @foreach ($relatedProducts as $product)
                                    <div class="col-xl-4 wine-card-container"
                                        data-type="{{ strtolower($product->type) }}"
                                        data-vintage-year="{{ $product->vintage_year }}"
                                        data-winery="{{ $product->winery }}"
                                        data-retail-price="{{ $product->retail_price }}"
                                        data-country="{{ $product->country }}">
                                        <div class="card custom-card wine-card">
                                            <!-- Image -->
                                            <div class="image-wrapper" style="position: relative;">
                                                <img src="{{ asset('storage/' . $product->image1) }}"
                                                    class="card-img-top rounded-0" alt="{{ $product->wine_name }}">

                                                @if ($product->is_featured == 1)
                                                    <span class="featured-badge">Featured</span>
                                                @endif
                                            </div>

                                            <!-- Product Info -->
                                            <div class="card-body">
                                                <h5 class="card-title fw-semibold">{{ $product->wine_name }}</h5>
                                                @php
                                                    $type = strtolower($product->type);
                                                    $emoji = match ($type) {
                                                        'red' => '🍷',
                                                        'white' => '🥂',
                                                        'sparkling' => '✨',
                                                        default => '',
                                                    };
                                                @endphp
                                                <p>
                                                    <strong>Type:</strong> {{ ucfirst($type) }}
                                                    @if ($emoji)
                                                        <span style="font-size: 1.5em;">{{ $emoji }}</span>
                                                    @endif
                                                </p>

                                                <p><strong>Vintage Year: <small>[ Please check for recent editions with our store manager ]</small></strong> {{ $product->vintage_year }}</p>
                                                <a href="{{ route('user.productdetails', $product->id) }}"
                                                    class="btn btn-dark mt-2 rounded-0">
                                                    Tell Me More !!
                                                </a>
                                                <button
                                                    class="btn mt-2 rounded-0 buy-now-btn {{ collect($cart ?? [])->pluck('id')->contains($product->id) ? 'btn-dark' : 'btn-light' }}"
                                                    data-product-id="{{ $product->id }}"
                                                    data-product-name="{{ $product->wine_name }}"
                                                    data-product-price="{{ $product->retail_price }}">

                                                    {{ collect($cart ?? [])->pluck('id')->contains($product->id) ? 'Remove from Cart' : 'Buy Now' }}

                                                </button>

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
@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const buttons = document.querySelectorAll('.buy-now-btn');
        buttons.forEach(button => {
            button.addEventListener('click', function () {

            const productId = this.getAttribute('data-product-id');
            const productName = this.getAttribute('data-product-name');
            const productPrice = this.getAttribute('data-product-price');

            const isInCart = this.classList.contains('btn-dark');

            const url = isInCart
                ? '{{ route("user.cart.remove") }}'
                : '{{ route("user.cart.add") }}';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    product_id: productId,
                    product_name: productName,
                    product_price: productPrice
                })
            })
            .then(response => response.json())
            .then(data => {

                if (!data.success) return;
                const cartCountElement = document.getElementById('cart-count');
                    if (cartCountElement) 
                    {
                        let currentCount = parseInt(cartCountElement.textContent) || 0;
                        if (isInCart) {
                            currentCount = Math.max(0, currentCount - 1);
                        } else {
                            currentCount += 1;
                        }
                        cartCountElement.textContent = currentCount;
                    }

                    if (isInCart) {
                        this.classList.remove('btn-dark');
                        this.classList.add('btn-light');
                        this.textContent = 'Buy Now';
                        toastr.warning('Product removed from cart!', 'Removed', {
                            closeButton: true,
                            progressBar: true,
                            positionClass: 'toast-top-right',
                            timeOut: 3000
                        });

                        } else {

                        this.classList.remove('btn-light');
                        this.classList.add('btn-dark');
                        this.textContent = 'Remove from Cart';

                        toastr.success('Product added to cart!', 'Added', {
                            closeButton: true,
                            progressBar: true,
                            positionClass: 'toast-top-right',
                            timeOut: 3000
                        });
                    }
            });
            });
        });
    });
</script>

@endpush