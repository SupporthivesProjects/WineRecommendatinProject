@if($products->count() > 0)
    @foreach($products as $product)

        <div class="col-md-6 col-xl-4 wine-card-container" 
             data-type="{{ strtolower($product->type) }}"
             data-vintage-year="{{ $product->vintage_year }}" 
             data-winery="{{ $product->winery }}"
             data-retail-price="{{ $product->retail_price }}"
             data-country="{{ $product->country }}"
             data-featured="{{ $product->admin_featured_product ? 'true' : 'false' }}">
            <!-- <div class="card custom-card wine-card">
                <div class="image-wrapper product-card-media">
                    <img loading="lazy" src="{{ asset('storage/' . $product->image1)  }}"
                         class="card-img-top rounded-0" alt="{{ $product->wine_name }}">

                    @if($product->admin_featured_product)
                        <span class="featured-badge">
                            <i class="fas fa-star"></i> Featured
                        </span>
                    @endif
                </div>

                <div class="card-body">
                    <h5 class="card-title fw-semibold">{{ $product->wine_name }}</h5>
                    @php
                        $type = strtolower($product->type);
                        $emoji = match ($type) {
                            'red' => '🍷',
                            'white' => '<i class="fas fa-wine-glass text-warning" title="White Wine"></i>', 
                            'sparkling' => '✨',
                            'ros' => '🌸',
                            'dessert' => '🍯',
                            'bordeaux' => '🏰',
                            default => '🍾',
                        };
                    @endphp
                    <p>
                        <strong>Type:</strong> {{ ucfirst($type) }}
                        <span style="font-size: 1.5em;">{!! $emoji !!}</span>
                    </p>
    
                    <a href="{{ route('user.productdetails', $product->id) }}" 
                       class="btn btn-dark mt-2 rounded-0">
                        I want to try Now !!
                    </a>
                </div>
            </div> -->
            <div class="card custom-card wine-card position-relative">
                <div class="image-wrapper product-card-media">
                    <img loading="lazy" src="{{ asset('storage/' . $product->image1) }}"
                        class="card-img-top rounded-0" alt="{{ $product->wine_name }}" onerror="this.src='{{ asset('images/default.jpg') }}'">

                    @if($product->admin_featured_product)
                        <span class="featured-badge">
                            <i class="fas fa-crown"></i>
                        </span>
                    @endif
                </div>

                <div class="card-body">
                    <h5 class="card-title fw-semibold">{{ $product->wine_name }}</h5>
                    <p>
                        <strong>Type:</strong> {{ ucfirst($type) }}
                        <span style="font-size: 1.5em;">{!! $emoji !!}</span>
                    </p>
                </div>

                <!-- HOVER OVERLAY -->
                <div class="hover-overlay">
                    <a href="{{ route('user.productdetails', $product->id) }}" 
                    class="btn btn-dark rounded-0 overlay-btn">
                    Tell me more !!
                    </a>
                </div>
            </div>



        </div>
    @endforeach
@else
    <div class="col-12 text-center py-5">
        <p class="text-muted">No products found.</p>
    </div>
@endif