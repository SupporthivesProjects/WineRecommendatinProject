<style>
    /* Guest product details (loaded into #qrProductModal on the homepage).
       Wine, gold and cream like the rest of the site; brand.css is not loaded here,
       so the colours are set below. */
    .qr-product-modal-wrapper {
        --qr-wine-900: #3b0f1a;
        --qr-wine-700: #7b1e3a;
        --qr-gold-500: #de9313;
        --qr-gold-600: #a8730f;
        --qr-gold-200: #e0c58b;
        --qr-cream: #f8f5f2;
        --qr-line: #eee4d6;
        width: 100%;
        overflow-x: hidden;
        background: #fffdf9;
        color: #2f2a2b;
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
        padding: 24px;
        border: 1px solid rgba(224, 197, 139, 0.55);
        border-radius: 14px;
        background: radial-gradient(circle at 50% 40%, #ffffff 0%, var(--qr-cream) 70%);
    }

    .qr-product-modal-wrapper .product-main-image {
        max-width: 100%;
        max-height: 66vh;
        width: auto;
        height: auto;
        object-fit: contain;
        filter: drop-shadow(0 18px 22px rgba(59, 15, 26, 0.18));
    }

    .qr-product-modal-wrapper .product-title {
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 2rem;
        font-weight: 700;
        line-height: 1.2;
        color: var(--qr-wine-900);
        word-break: break-word;
    }

    .qr-product-modal-wrapper .qr-type-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border: 1px solid rgba(123, 30, 58, 0.25);
        border-radius: 999px;
        background: rgba(123, 30, 58, 0.07);
        color: var(--qr-wine-700);
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.03em;
    }

    /* Key facts as label/value tiles */
    .qr-product-modal-wrapper .qr-facts {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
        margin: 18px 0 8px;
    }

    .qr-product-modal-wrapper .qr-fact {
        padding: 10px 14px;
        border: 1px solid var(--qr-line);
        border-radius: 10px;
        background: #fff;
    }

    .qr-product-modal-wrapper .qr-fact-label {
        display: block;
        margin-bottom: 2px;
        color: var(--qr-gold-600);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .qr-product-modal-wrapper .product-meta {
        font-size: 15px;
        line-height: 1.5;
        color: #2f2a2b;
        word-break: break-word;
    }

    .qr-product-modal-wrapper .qr-rating {
        color: var(--qr-gold-600);
        font-size: 14px;
    }

    /* Section headings with a short gold rule */
    .qr-product-modal-wrapper .qr-section-title {
        position: relative;
        margin: 24px 0 14px;
        padding-bottom: 8px;
        color: var(--qr-wine-900);
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .qr-product-modal-wrapper .qr-section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 44px;
        height: 2px;
        background: var(--qr-gold-500);
    }

    .qr-product-modal-wrapper .tasting-notes {
        margin: 0;
        padding: 14px 18px;
        border-left: 3px solid var(--qr-gold-500);
        border-radius: 0 10px 10px 0;
        background: var(--qr-cream);
        color: #4a3b3f;
        line-height: 1.7;
    }

    /* Specifications */
    .qr-product-modal-wrapper .specifications-table {
        width: 100%;
        margin-bottom: 0;
        border: 1px solid var(--qr-line);
        border-radius: 10px;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
    }

    .qr-product-modal-wrapper .specifications-table th,
    .qr-product-modal-wrapper .specifications-table td {
        padding: 10px 14px;
        border: 0;
        border-bottom: 1px solid var(--qr-line);
        white-space: normal;
        word-break: break-word;
    }

    .qr-product-modal-wrapper .specifications-table tr:last-child th,
    .qr-product-modal-wrapper .specifications-table tr:last-child td {
        border-bottom: 0;
    }

    .qr-product-modal-wrapper .specifications-table th {
        width: 35%;
        background: #fbf6ef;
        color: var(--qr-wine-700);
        font-weight: 600;
    }

    .qr-product-modal-wrapper .specifications-table td {
        background: #fff;
        color: #2f2a2b;
    }

    /* One calm colour for every icon instead of the mixed theme colours */
    .qr-product-modal-wrapper .specifications-table td i,
    .qr-product-modal-wrapper .qr-type-pill i {
        width: 18px;
        margin-right: 4px;
        color: var(--qr-gold-500) !important;
        text-align: center;
    }

    .qr-product-modal-wrapper .qr-type-pill i {
        color: var(--qr-wine-700) !important;
    }

    /* Similar products */
    .qr-product-modal-wrapper .related-product-card {
        height: 100%;
        border: 1px solid var(--qr-line);
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    .qr-product-modal-wrapper .related-product-card:hover {
        border-color: var(--qr-gold-200);
        box-shadow: 0 10px 24px rgba(59, 15, 26, 0.12);
        transform: translateY(-3px);
    }

    .qr-product-modal-wrapper .related-product-card .card-body {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .qr-product-modal-wrapper .related-product-card h6 {
        color: var(--qr-wine-900);
    }

    .qr-product-modal-wrapper .related-product-card .related-product-btn {
        margin-top: auto;
        border: 1px solid var(--qr-wine-700);
        border-radius: 999px;
        background: transparent;
        color: var(--qr-wine-700);
        font-weight: 500;
    }

    .qr-product-modal-wrapper .related-product-card .related-product-btn:hover,
    .qr-product-modal-wrapper .related-product-card .related-product-btn:focus-visible {
        background: var(--qr-wine-700);
        color: #fff;
    }

    .qr-product-modal-wrapper .related-product-image {
        width: 100%;
        height: 220px;
        object-fit: contain;
        padding: 14px;
        background: var(--qr-cream);
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
            max-height: 38vh;
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
            padding: 16px;
        }

        .qr-product-modal-wrapper .product-main-image {
            max-height: 30vh;
        }

        .qr-product-modal-wrapper .product-title {
            font-size: 1.4rem;
        }

        .qr-product-modal-wrapper .qr-facts {
            grid-template-columns: minmax(0, 1fr);
        }

        .qr-product-modal-wrapper .product-meta {
            font-size: 14px;
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

                <span class="qr-type-pill">

                    {!! $typeIcons[$type] ?? $defaultIcon !!}

                    {{ ucfirst($product->type) ?: 'N/A' }}

                </span>


                {{-- KEY FACTS --}}

                <div class="qr-facts">

                    <div class="qr-fact">
                        <span class="qr-fact-label">Method</span>
                        <span class="product-meta">{{ ucfirst($product->method) ?: 'N/A' }}</span>
                    </div>

                    <div class="qr-fact">
                        <span class="qr-fact-label">Grape Variety</span>
                        <span class="product-meta">{{ $product->grape_variety ?? 'N/A' }}</span>
                    </div>

                    <div class="qr-fact">
                        <span class="qr-fact-label">Region</span>
                        <span class="product-meta">{{ $product->wine_sub_region ?? 'N/A' }}</span>
                    </div>

                    <div class="qr-fact">
                        <span class="qr-fact-label">Country</span>
                        <span class="product-meta">{{ $product->country ?? 'N/A' }}</span>
                    </div>

                </div>


                {{-- REVIEWS --}}

                @if($totalReviews > 0)

                    <p class="qr-rating mb-3">

                        <i class="fas fa-star"></i>
                        {{ number_format($averageRating, 1) }}/5

                        ({{ $totalReviews }} Reviews)

                    </p>

                @endif


                {{-- PRICE 

                <h4 class="fw-bold mb-4">

                    ₹{{ number_format($product->retail_price, 2) }}

                </h4>--}}


                {{-- ========================================= --}}
                {{-- TASTING NOTES --}}
                {{-- ========================================= --}}

                @if(!empty($product->tasting_notes))

                    <div class="mb-2">

                        <h5 class="qr-section-title">
                            Tasting Notes
                        </h5>

                        <p class="tasting-notes">
                            {{ $product->tasting_notes }}
                        </p>

                    </div>

                @endif


                {{-- ========================================= --}}
                {{-- SPECIFICATIONS --}}
                {{-- ========================================= --}}

                <h4 class="qr-section-title">
                    Specifications
                </h4>


                <div class="table-responsive">

                    <table class="table align-middle specifications-table">

                        <tbody>

                            <tr>
                                <th>Type</th>

                                <td>
                                    {!! $typeIcons[$type] ?? $defaultIcon !!}
                                    {{ ucfirst($product->type) ?: 'N/A' }}
                                </td>
                            </tr>


                            <tr>
                                <th>Method</th>

                                <td>
                                    {!! $methodIcons[$method] ?? $defaultIcon !!}
                                    {{ ucfirst($product->method) ?: 'N/A' }}
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

                    <h4 class="qr-section-title mt-5">
                        Similar Products
                    </h4>


                    <div class="row">

                        @foreach($relatedProducts as $related)

                            <div class="col-md-4 col-sm-6 mb-4">

                                <div class="card related-product-card">

                                    <img loading="lazy"
                                        src="{{ asset('storage/' . $related->image1) }}"
                                        class="card-img-top related-product-image"
                                        alt="{{ $related->wine_name }}"
                                    >


                                    <div class="card-body">

                                        <h6 class="fw-bold">
                                            {{ $related->wine_name }}
                                        </h6>


                                        <p class="qr-fact-label mb-3">
                                            {{ ucfirst($related->type) }}
                                        </p>


                                        {{--<p class="fw-bold">
                                            ₹{{ number_format($related->retail_price, 2) }}
                                        </p>--}}


                                        <button
                                            type="button"
                                            class="btn w-100 related-product-btn"
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
