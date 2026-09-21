<style>
    .qr-product-modal-wrapper {
        width: 100%;
        overflow-x: hidden;
    }

    .qr-product-modal-wrapper .product-image-wrapper {
        width: 100%;
        height: 75vh;
        min-height: 350px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: sticky;
        top: 20px;
    }

    .qr-product-modal-wrapper .product-main-image {
        max-width: 100%;
        max-height: 70vh;
        width: auto;
        height: auto;
        object-fit: contain;
    }

    .qr-product-modal-wrapper .product-title {
        font-size: 2rem;
        line-height: 1.2;
        word-break: break-word;
    }

    .qr-product-modal-wrapper .product-meta {
        font-size: 15px;
        line-height: 1.6;
    }

    .qr-product-modal-wrapper .tasting-notes {
        line-height: 1.7;
    }

    .qr-product-modal-wrapper .specifications-table {
        width: 100%;
    }

    .qr-product-modal-wrapper .specifications-table th {
        width: 35%;
        white-space: normal;
    }

    .qr-product-modal-wrapper .specifications-table td {
        white-space: normal;
        word-break: break-word;
    }

    .qr-product-modal-wrapper .related-product-card {
        height: 100%;
    }

    .qr-product-modal-wrapper .related-product-image {
        width: 100%;
        height: 220px;
        object-fit: contain;
        padding: 10px;
    }

    @media (max-width: 991.98px) {

        .qr-product-modal-wrapper .product-image-wrapper {
            position: relative;
            top: auto;
            height: 45vh;
            min-height: 280px;
            margin-bottom: 20px;
        }

        .qr-product-modal-wrapper .product-main-image {
            max-height: 40vh;
        }

        .qr-product-modal-wrapper .product-title {
            font-size: 1.6rem;
        }
    }

    @media (max-width: 575.98px) {

        .qr-product-modal-wrapper .container-fluid {
            padding: 15px !important;
        }

        .qr-product-modal-wrapper .product-image-wrapper {
            height: 35vh;
            min-height: 230px;
            margin-bottom: 15px;
        }

        .qr-product-modal-wrapper .product-main-image {
            max-height: 32vh;
        }

        .qr-product-modal-wrapper .product-title {
            font-size: 1.4rem;
        }

        .qr-product-modal-wrapper .product-meta {
            font-size: 14px;
        }

        .qr-product-modal-wrapper h4 {
            font-size: 1.2rem;
        }

        .qr-product-modal-wrapper h5 {
            font-size: 1.05rem;
        }

        .qr-product-modal-wrapper .specifications-table {
            font-size: 13px;
        }

        .qr-product-modal-wrapper .specifications-table th {
            width: 40%;
        }

        .qr-product-modal-wrapper .related-product-image {
            height: 180px;
        }
    }
</style>


<div class="qr-product-modal-wrapper">

    <div class="container-fluid p-4">

        <div class="row">

            {{-- ========================================= --}}
            {{-- PRODUCT IMAGE --}}
            {{-- ========================================= --}}

            <div class="col-lg-5">

                <div class="product-image-wrapper">

                    <img
                        src="{{ asset('storage/' . $product->image1) }}"
                        alt="{{ $product->wine_name }}"
                        class="img-fluid product-main-image"
                    >

                </div>

            </div>


            {{-- ========================================= --}}
            {{-- PRODUCT INFORMATION --}}
            {{-- ========================================= --}}

            @php

                // Type icons
                $typeIcons = [
                    'red' => '<i class="fas fa-wine-glass text-danger"></i>',
                    'white' => '<i class="fas fa-wine-glass text-warning"></i>',
                    'sparkling' => '<i class="fas fa-champagne-glasses text-info"></i>',
                    'ros' => '<i class="fas fa-wine-glass text-pink"></i>',
                    'dessert' => '<i class="fas fa-ice-cream text-warning"></i>',
                    'bordeaux' => '<i class="fas fa-wine-bottle text-purple"></i>',
                ];

                // Method icons
                $methodIcons = [
                    'still' => '<i class="fas fa-tint text-primary"></i>',
                    'semi sparkling' => '<i class="fas fa-bubbles text-info"></i>',
                    'sparkling' => '<i class="fas fa-champagne-glasses text-warning"></i>',
                    'fortified' => '<i class="fas fa-wine-bottle text-danger"></i>',
                ];

                // Default icon
                $defaultIcon = '<i class="fas fa-tag text-secondary"></i>';

                // Extra field icons
                $extraIcons = [
                    'sp_mentions' => '<i class="fas fa-comment-alt text-muted"></i>',
                    'vintage_year' => '<i class="fas fa-calendar-alt text-secondary"></i>',
                    'alcohol_vol' => '<i class="fas fa-flask text-danger"></i>',
                    'nature' => '<i class="fas fa-leaf text-success"></i>',
                    'body' => '<i class="fas fa-balance-scale text-info"></i>',
                    'time_spent_aging' => '<i class="fas fa-hourglass-half text-warning"></i>',
                    'closure_type' => '<i class="fas fa-wine-bottle text-secondary"></i>',
                    'serving_temperature' => '<i class="fas fa-thermometer-half text-primary"></i>',
                    'ageging_potential' => '<i class="fas fa-clock text-secondary"></i>',
                    'cheese_pairing' => '<i class="fas fa-cheese text-warning"></i>',
                    'importer_info' => '<i class="fas fa-truck text-secondary"></i>',
                ];

                $type = strtolower($product->type ?? 'n/a');
                $method = strtolower($product->method ?? 'n/a');

            @endphp


            <div class="col-lg-7">

                {{-- PRODUCT NAME --}}

                <h2 class="fw-bold mb-2 product-title">
                    {{ $product->wine_name }}
                </h2>


                {{-- TYPE --}}

                <p class="text-warning fw-semibold mb-2 product-meta">

                    {!! $typeIcons[$type] ?? $defaultIcon !!}

                    {{ ucfirst($product->type) ?? 'N/A' }}

                </p>


                {{-- METHOD --}}

                <p class="mb-1 product-meta">

                    <strong>Method:</strong>

                    {!! $methodIcons[$method] ?? $defaultIcon !!}

                    {{ ucfirst($product->method) ?? 'N/A' }}

                </p>


                {{-- GRAPE VARIETY --}}

                <p class="mb-1 product-meta">

                    <strong>Grape Variety:</strong>

                    {{ $product->grape_variety ?? 'N/A' }}

                </p>


                {{-- REGION --}}

                <p class="mb-2 product-meta">

                    <strong>Region:</strong>

                    {{ $product->wine_sub_region ?? 'N/A' }}

                </p>


                {{-- REVIEWS --}}

                @if($totalReviews > 0)

                    <p class="text-muted mb-3">

                        {{ number_format($averageRating, 1) }}/5

                        ({{ $totalReviews }} Reviews)

                    </p>

                @endif


                {{-- PRICE --}}

                <h4 class="fw-bold mb-4">

                    ₹{{ number_format($product->retail_price, 2) }}

                </h4>


                {{-- ========================================= --}}
                {{-- TASTING NOTES --}}
                {{-- ========================================= --}}

                @if(!empty($product->tasting_notes))

                    <div class="mb-4">

                        <h5 class="fw-bold mb-2">
                            Tasting Notes
                        </h5>

                        <p class="text-muted tasting-notes">
                            {{ $product->tasting_notes }}
                        </p>

                    </div>

                @endif


                <hr>


                {{-- ========================================= --}}
                {{-- SPECIFICATIONS --}}
                {{-- ========================================= --}}

                <h4 class="fw-bold mb-3">
                    Specifications
                </h4>


                <div class="table-responsive">

                    <table class="table table-bordered align-middle specifications-table">

                        <tbody>

                            <tr>
                                <th>Type</th>

                                <td>
                                    {!! $typeIcons[$type] ?? $defaultIcon !!}
                                    {{ ucfirst($product->type) ?? 'N/A' }}
                                </td>
                            </tr>


                            <tr>
                                <th>Method</th>

                                <td>
                                    {!! $methodIcons[$method] ?? $defaultIcon !!}
                                    {{ ucfirst($product->method) ?? 'N/A' }}
                                </td>
                            </tr>


                            <tr>
                                <th>SP Mentions</th>

                                <td>
                                    {!! $extraIcons['sp_mentions'] ?? $defaultIcon !!}
                                    {{ $product->sp_mentions ?? 'N/A' }}
                                </td>
                            </tr>


                            <tr>
                                <th>Vintage</th>

                                <td>
                                    {!! $extraIcons['vintage_year'] ?? $defaultIcon !!}
                                    {{ $product->vintage_year ?? 'N/A' }}
                                </td>
                            </tr>


                            <tr>
                                <th>Alcohol Volume</th>

                                <td>
                                    {!! $extraIcons['alcohol_vol'] ?? $defaultIcon !!}
                                    {{ $product->alcohol_vol ?? 'N/A' }}
                                </td>
                            </tr>


                            <tr>
                                <th>Nature</th>

                                <td>
                                    {!! $extraIcons['nature'] ?? $defaultIcon !!}
                                    {{ $product->nature ?? 'N/A' }}
                                </td>
                            </tr>


                            <tr>
                                <th>Body</th>

                                <td>
                                    {!! $extraIcons['body'] ?? $defaultIcon !!}
                                    {{ $product->body ?? 'N/A' }}
                                </td>
                            </tr>


                            <tr>
                                <th>Time spent in Aging</th>

                                <td>
                                    {!! $extraIcons['time_spent_aging'] ?? $defaultIcon !!}
                                    {{ $product->time_spent_aging ?? 'N/A' }}
                                </td>
                            </tr>


                            <tr>
                                <th>Closure Type</th>

                                <td>
                                    {!! $extraIcons['closure_type'] ?? $defaultIcon !!}
                                    {{ $product->closure_type ?? 'N/A' }}
                                </td>
                            </tr>


                            <tr>
                                <th>Serving Temperature</th>

                                <td>
                                    {!! $extraIcons['serving_temperature'] ?? $defaultIcon !!}
                                    {{ $product->serving_temperature ?? 'N/A' }}
                                </td>
                            </tr>


                            <tr>
                                <th>Aging Potential</th>

                                <td>
                                    {!! $extraIcons['ageging_potential'] ?? $defaultIcon !!}
                                    {{ $product->ageing_potential ?? 'N/A' }}
                                </td>
                            </tr>


                            <tr>
                                <th>Cheese Pairing</th>

                                <td>
                                    {!! $extraIcons['cheese_pairing'] ?? $defaultIcon !!}
                                    {{ $product->cheese_pairing ?? 'N/A' }}
                                </td>
                            </tr>


                            <tr>
                                <th>Importer</th>

                                <td>
                                    {!! $extraIcons['importer_info'] ?? $defaultIcon !!}
                                    {{ $product->importer_info ?? 'N/A' }}
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>


                {{-- ========================================= --}}
                {{-- RELATED PRODUCTS --}}
                {{-- ========================================= --}}

                <div id="qr-related-products-section">

                    <hr class="mt-5">

                    <h4 class="fw-bold mb-4">
                        Related Products
                    </h4>


                    <div class="row">

                        @foreach($relatedProducts as $related)

                            <div class="col-md-4 col-sm-6 mb-4">

                                <div class="card related-product-card">

                                    <img
                                        src="{{ asset('storage/' . $related->image1) }}"
                                        class="card-img-top related-product-image"
                                        alt="{{ $related->wine_name }}"
                                    >


                                    <div class="card-body">

                                        <h6 class="fw-bold">
                                            {{ $related->wine_name }}
                                        </h6>


                                        <p class="text-muted mb-2">
                                            {{ ucfirst($related->type) }}
                                        </p>


                                        <p class="fw-bold">
                                            ₹{{ number_format($related->retail_price, 2) }}
                                        </p>


                                        <button
                                            type="button"
                                            class="btn btn-outline-dark w-100 related-product-btn"
                                            data-product-id="{{ $related->id }}"
                                        >
                                            Tell Me More
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

</div>