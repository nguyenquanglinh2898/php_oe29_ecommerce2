<div class="support-cart support-search mini-cart">
    <div class="top-cart-content top-search-content">
        <ul id="cart-sidebar" class="mini-products-list count_li">
            @if (isset($products) && $products->isNotEmpty())
                <ul class="list-item-cart">
                    @foreach ($products as $product)
                        <li class="item productid-1">
                            <a class="product-image" href="{{ route('home.show', $product->id) }}" >
                                <img alt="" src="{{ asset(config('config.images_folder') . $product->thumbnail) }}" width="80" height="80">
                            </a>
                            <div class="detail-item">
                                <div class="product-details">
                                    <p class="product-name">
                                        <a href="{{ route('home.show', $product->id) }}" title="{{ $product->name }}">{{ $product->name }}
                                        </a>
                                    </p>
                                </div>
                                <div class="product-details-bottom">
                                    <span class="price pricechange">{{ $product->price_range }} {{ config('config.vnd2') }}</span>
                                    <div class="start-vote">
                                        @for ($i = 1; $i <= config('config.star_vote'); $i++)
                                            @if ($product->rate > $i )
                                                <i class="fas fa-star"></i>
                                            @elseif ($product->rate = $i + 1 && $product->rate - (int) $product->rate > 0)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="no-item"><p>{{ trans('customer.product_not_found') }}</p></div>
            @endif
        </ul>
    </div>
</div>
<div id="menu-overlay"></div>
