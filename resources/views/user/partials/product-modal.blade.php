<div class="modal-product-wrapper">

    <div class="container-fluid p-4">

        <div class="row">

            {{-- LEFT SIDE IMAGE --}}
            <div class="col-lg-5">

                <div
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
            <div class="col-lg-7">

                <h2 class="fw-bold mb-2">
                    {{ $product->wine_name }}
                </h2>

                <p class="text-warning fw-semibold mb-2">
                    {{ ucfirst($product->type) }}
                </p>

                <p class="mb-1">
                    <strong>Method:</strong>
                    {{ $product->method ?? 'N/A' }}
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
                                <td>{{ ucfirst($product->type) ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Method</th>
                                <td>{{ ucfirst($product->method) ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>SP Mentions</th>
                                <td>{{ $product->sp_mentions ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Vintage</th>
                                <td>{{ $product->vintage_year ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Alcohol Volume</th>
                                <td>{{ $product->alcohol_vol ?? 'N/A' }}%</td>
                            </tr>

                            <tr>
                                <th>Nature</th>
                                <td>{{ $product->nature ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Body</th>
                                <td>{{ $product->body ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Time spent in Aging</th>
                                <td>{{ $product->time_spent_aging ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Closure Type</th>
                                <td>{{ $product->closure_type ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Serving Temperature</th>
                                <td>{{ $product->serving_temperature ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Aging Potential</th>
                                <td>{{ $product->ageing_potential ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Cheese Pairing</th>
                                <td>{{ $product->cheese_pairing ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Importer</th>
                                <td>{{ $product->importer_info ?? 'N/A' }}</td>
                            </tr>

                        </tbody>

                    </table>

                </div>

                {{-- RELATED PRODUCTS COMING NEXT --}}
                <div id="related-products-section"></div>

            </div>

        </div>

    </div>

</div>