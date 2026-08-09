<style>
    @media (max-width: 720px) 
    {
        #questionnaire-modal-jeets {
            height: 40vh !important;
        }
    }
</style>
<div class="modal-product-wrapper">
    <div class="container-fluid p-4">
        <div class="row">
            {{-- LEFT SIDE IMAGE --}}
            <div class="col-lg-5">
                <div
                    id="questionnaire-modal-jeets"
                    style="
                        position: sticky;
                        top: 20px;
                        height: 85vh;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                    "
                >
                    <img
                        src="{{ asset('storage/' . $product->image1) }}"
                        alt="{{ $product->wine_name }}"
                        class="img-fluid"
                        style="
                            max-height:80vh;
                            width:auto;
                            object-fit:contain;
                        "
                    >
                </div>
            </div>

            {{-- RIGHT SIDE CONTENT --}}
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
                    'alcohol_vol' => '<i class="fas fa-flask text-danger"></i>',
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
            <div class="col-lg-7">
                <h2 class="fw-bold mb-2">
                    {{ $product->wine_name }}
                </h2>
                <p class="text-warning fw-semibold mb-2">
                    {!! $typeIcons[$type] ?? $defaultIcon !!} {{ ucfirst($product->type) ?? 'N/A' }}
                </p>
                <p class="mb-1">
                    <strong>Method:</strong>
                    {!! $methodIcons[$method] ?? $defaultIcon !!} {{ ucfirst($product->method) ?? 'N/A' }}
                </p>
                <p class="mb-1">
                    <strong>Grape Variety:</strong>
                    {{ $product->grape_variety ?? 'N/A' }}
                </p>
                <p class="mb-2">
                    <strong>Region:</strong>
                    {{ $product->wine_sub_region ?? 'N/A' }}
                </p>
                @if($totalReviews > 0)
                    <p class="text-muted mb-3">
                        {{ number_format($averageRating, 1) }}/5
                        ({{ $totalReviews }} Reviews)
                    </p>
                @endif
                <h4 class="fw-bold mb-4">
                    ₹{{ number_format($product->retail_price, 2) }}
                </h4>
                {{-- TASTING NOTES --}}
                @if(!empty($product->tasting_notes))
                    <div class="mb-4">

                        <h5 class="fw-bold mb-2">
                            Tasting Notes
                        </h5>

                        <p class="text-muted">
                            {{ $product->tasting_notes }}
                        </p>

                    </div>
                @endif
                {{-- BUY NOW BUTTON --}}
                @php
                    $isInCart = in_array($product->id, $cart ?? []);
                @endphp
                <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
                    <button
                        type="button"
                        class="btn btn-outline-dark qty-minus-btn"
                    >
                        -
                    </button>
                    <input
                        type="text"
                        value="{{ max($quantity, 1) }}"
                        class="form-control text-center"
                        id="modal-product-qty"
                        style="
                            width:80px;
                            font-weight:bold;
                        "
                        readonly
                    >
                    <button
                        type="button"
                        class="btn btn-outline-dark qty-plus-btn"
                    >
                        +
                    </button>
                </div>
                <div class="mb-4">
                    <button
                        class="btn w-100 buy-now-btn {{ $isInCart ? 'btn-dark' : 'btn-light' }}"
                        data-product-id="{{ $product->id }}"
                        data-product-name="{{ $product->wine_name }}"
                        data-product-price="{{ $product->retail_price }}"
                    >
                        {{ $isInCart ? 'Remove from Cart' : 'Buy Now' }}
                    </button>
                </div>
                <hr>
                {{-- SPECIFICATIONS --}}
                <h4 class="fw-bold mb-3">
                    Specifications
                </h4>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <tbody>
                            <tr>
                                <th width="35%">Type</th>
                                <td>{!! $typeIcons[$type] ?? $defaultIcon !!} {{ ucfirst($product->type) ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Method</th>
                                <td>{!! $methodIcons[$method] ?? $defaultIcon !!} {{ ucfirst($product->method) ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>SP Mentions</th>
                                <td>{!! $extraIcons['sp_mentions'] ?? $defaultIcon !!} {{ $product->sp_mentions ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Vintage</th>
                                <td>{!! $extraIcons['vintage_year'] ?? $defaultIcon !!} {{ $product->vintage_year ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Alcohol Volume</th>
                                <td>{!! $extraIcons['alcohol_vol'] ?? $defaultIcon !!} {{ $product->alcohol_vol }}</td>
                            </tr>
                            <tr>
                                <th>Nature</th>
                                <td>{!! $extraIcons['nature'] ?? $defaultIcon !!} {{ $product->nature }}</td>
                            </tr>
                            <tr>
                                <th>Body</th>
                                <td>{!! $extraIcons['body'] ?? $defaultIcon !!} {{ $product->body }}</td>
                            </tr>
                            <tr>
                                <th>Time spent in Aging</th>
                                <td>{!! $extraIcons['time_spent_aging'] ?? $defaultIcon !!} {{ $product->time_spent_aging }}</td>
                            </tr>
                            <tr>
                                <th>Closure Type</th>
                                <td>{!! $extraIcons['closure_type'] ?? $defaultIcon !!} {{ $product->closure_type }}</td>
                            </tr>
                            <tr>
                                <th>Serving Temperature</th>
                                <td>{!! $extraIcons['serving_temperature'] ?? $defaultIcon !!} {{ $product->serving_temperature }}</td>
                            </tr>
                            <tr>
                                <th>Aging Potential</th>
                                <td>{!! $extraIcons['ageging_potential'] ?? $defaultIcon !!} {{ $product->ageing_potential ?? 'N/A' }}
                            </tr>
                            <tr>
                                <th>Cheese Pairing</th>
                                <td style="white-space: normal; word-wrap: break-word;">
                                                    {!! $extraIcons['cheese_pairing'] ?? $defaultIcon !!} {{ $product->cheese_pairing ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Importer</th>
                                <td style="white-space: normal; word-wrap: break-word;">
                                                    {!! $extraIcons['importer_info'] ?? $defaultIcon !!} {{ $product->importer_info ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                {{-- RELATED PRODUCTS COMING NEXT --}}
                <div id="related-products-section">
                <hr class="mt-5">
                    <h4 class="fw-bold mb-4">
                        Related Products
                    </h4>
                    <div class="row">
                        @foreach($relatedProducts as $related)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img
                                        src="{{ asset('storage/' . $related->image1) }}"
                                        class="card-img-top"
                                        style="
                                            height:220px;
                                            object-fit:contain;
                                            padding:10px;
                                        "
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