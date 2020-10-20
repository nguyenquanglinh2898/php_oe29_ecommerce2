<div class="support-cart mini-cart">
    <a class="btn-support-cart" href="{{ route('cart.show') }}">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 435.104 435.104" xml:space="preserve" width="30px" height="30px">
            <g>
                <circle cx="154.112" cy="377.684" r="52.736" data-original="#000000" class="active-path" data-old_color="#Ffffff" fill="#FFFFFF"></circle>
                <path d="M323.072,324.436L323.072,324.436c-29.267-2.88-55.327,18.51-58.207,47.777c-2.88,29.267,18.51,55.327,47.777,58.207     c3.468,0.341,6.962,0.341,10.43,0c29.267-2.88,50.657-28.94,47.777-58.207C368.361,346.928,348.356,326.924,323.072,324.436z" data-original="#000000" class="active-path" data-old_color="#F8F8F8" fill="#FFFFFF"></path>
                <path d="M431.616,123.732c-2.62-3.923-7.059-6.239-11.776-6.144h-58.368v-1.024C361.476,54.637,311.278,4.432,249.351,4.428     C187.425,4.424,137.22,54.622,137.216,116.549c0,0.005,0,0.01,0,0.015v1.024h-43.52L78.848,50.004     C77.199,43.129,71.07,38.268,64,38.228H0v30.72h51.712l47.616,218.624c1.257,7.188,7.552,12.397,14.848,12.288h267.776     c7.07-0.041,13.198-4.901,14.848-11.776l37.888-151.552C435.799,132.019,434.654,127.248,431.616,123.732z M249.344,197.972     c-44.96,0-81.408-36.448-81.408-81.408s36.448-81.408,81.408-81.408s81.408,36.448,81.408,81.408     C330.473,161.408,294.188,197.692,249.344,197.972z" data-original="#000000" class="active-path" data-old_color="#F8F8F8" fill="#FFFFFF"></path>
                <path d="M237.056,118.1l-28.16-28.672l-22.016,21.504l38.912,39.424c2.836,2.894,6.7,4.55,10.752,4.608     c3.999,0.196,7.897-1.289,10.752-4.096l64.512-60.928l-20.992-22.528L237.056,118.1z" data-original="#000000" class="active-path" data-old_color="#F8F8F8" fill="#FFFFFF"></path>
            </g>
        </svg>
        <div class="animated infinite zoomIn kenit-alo-circle"></div>
        <div class="animated infinite pulse kenit-alo-circle-fill"></div>
        <span class="cnt crl-bg count_item_pr">
            @if (Session::has('cart'))
                {{ Session::get('cart')->totalQty }}
            @else
                {{ config('config.default') }}
            @endif
        </span>
    </a>
    <div class="top-cart-content">
        <ul id="cart-sidebar" class="mini-products-list count_li">
            @if (Session::has('cart'))
                <ul class="list-item-cart">
                    @foreach (Session::get('cart')->items as $key => $item)
                        <li class="item productid-{{ $key }}">
                            <a class="product-image" href="" >
                                <img alt="" src="{{ asset($item['product']['thumbnail']) }}" width="80">
                            </a>
                            <div class="detail-item">
                                <div class="product-details">
                                    <form class="remove_form">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $key }}" >
                                        <a href="javascript:;" data-id="{{ $key }}" class="remove-item-cart fa fa-remove" data-url="{{ route('cart.remove') }}" data-url2 = "{{ route('cart.show') }}" >
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </form>
                                    <p class="product-name">
                                        <a href="" title="{{ $item['product']['name'] . ' - ' . str_replace('"', " ", $item['list_attributes']) }}">{{ $item['product']['name']}}
                                        </a>
                                    </p>
                                    <p class="product-name">
                                        <a href="" title="{{ $item['product']['name'] . ' - ' . str_replace('"', " ", $item['list_attributes']) }}">{{ str_replace('"', " ", $item['list_attributes']) }}
                                        </a>
                                    </p>
                                </div>
                                <div class="product-details-bottom">
                                    <span class="price pricechange">{{ number_format($item['price'], config('config.default'), ',', '.') }} {{ config('config.vnd2') }}</span>
                                    <span>{{ trans('customer.total') }}</span>
                                    <span class="price pricechange total-item-price-{{ $key }}">{{ number_format($item['price'] * $item['qty'], config('config.default'), ',', '.') }} {{ config('config.vnd2') }}</span>
                                    <div class="quantity-select" >
                                        <form id= "quantity_form" id="{{ $key }}">
                                            @csrf
                                            <input class="variantID" type="hidden" name="id" value="{{ $key }}">
                                            <button id="minus" class="reduced items-count btn-minus" type="button" data-url="{{ route('cart.update') }}">–</button>
                                            <input type="text" maxlength="3" min="1" max="{{ $item['remaining'] }}"  class="input-text number-sidebar " name="qty" size="4" value="{{ $item['qty'] }}" id="qty" readonly="" >
                                            <button id="maxus" class="increase items-count btn-plus" type="button" data-url="{{ route('cart.update') }}">+</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div>
                    @if (Session::has('cart'))
                        <div class="top-subtotal">{{ trans('customer.total') }}: <span class="price totalPrice">{{ number_format(Session::get('cart')->totalPrice, config('config.default'), ',', '.') }} {{ config('config.vnd2') }}</span></div>
                    @endif
                </div>
                <div>
                    <div class="actions clearfix">
                        <a href="" class="btn btn-gray btn-checkout" data-url="">
                            <span >{{ trans('customer.pay') }}</span>
                        </a>
                        <a href="" class="view-cart btn btn-white margin-left-5" title="Giỏ hàng">
                            <span>{{ trans('customer.cart') }}</span>
                        </a>
                    </div>
                </div>
            @else
                <div class="no-item"><p>{{ trans('customer.no_item_cart') }}</p></div>
            @endif
        </ul>
    </div>
</div>
<div id="menu-overlay"></div>

<script src="{{ asset('js/customer/pages/minicart.js') }}"></script>
