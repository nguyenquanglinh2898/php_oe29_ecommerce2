<div class="section-header">
    <h2 class="section-title">{{ trans('customer.cart') }}
    @if (isset($cart))
        <span class="count_item_pr">( {{ $cart->totalQty }} {{ trans('customer.product') }})</span>
    @endif
    </h2>
</div>
<div class="section-content">
    @if(!isset($cart))
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="cart-empty">
                    <img src="{{ asset(config('config.empty_cart')) }}" alt="{{ trans('customer.empty_cart') }}">
                    <div class="btn-cart-empty">
                        <a href="{{ route('home.index') }}" title="{{ trans('customer.continue_shopping') }}">{{ trans('customer.continue_shopping') }}</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-8">
                <div class="cart-items">
                    @foreach ($cart->items as $key => $item)
                        <div class="item product-{{ $key }}">
                            <div class="image-product">
                                <a href="{{ route('home.show', $item['id']) }}" target="_blank" title="{{ $item['product']['name'] . ' - ' . str_replace('"', " ", $item['list_attributes']) }}">
                                    <img src="{{ asset(config('config.images_folder') . $item['product']['thumbnail']) }}">
                                </a>
                            </div>
                            <div class="info-product">
                                <div class="name"><a href="{{ route('home.show', $item['id']) }}" target="_blank" title="{{ $item['product']['name'] . ' - ' . str_replace(['{', '}', '"'], " ", $item['list_attributes']) }}">{{ $item['product']['name'] }}</a></div>
                                <div class="name"><a href="{{ route('home.show', $item['id']) }}" target="_blank" title="{{ $item['product']['name'] . ' - ' . str_replace(['{', '}', '"'], " ", $item['list_attributes']) }}">{{ str_replace(['{', '}', '"'], " ", $item['list_attributes']) }}</a></div>
                                <div class="price total-item-price-{{ $key }}">{{ number_format($item['price'], config('config.default'), ',', '.') }} {{ config('config.vnd2') }}</div>
                                <div >
                                    <form id= "quantity_form" class="quantity-block">
                                        @csrf
                                        <div class="input-group-btn">
                                            <input class="variantID" type="hidden" name="id" value="{{ $key }}">
                                            <button  class="reduced_pop items-count btn-minus btn btn-default bootstrap-touchspin-down" type="button" data-url="{{ route('cart.update') }}">–</button>
                                            <input type="text" maxlength="12" min="1" max="{{ $item['remaining'] }}" readonly="" class="form-control quantity-r2 quantity js-quantity-product input-text number-sidebar input_pop input_pop qtyItem{{ $key }}" name="qty" size="4" value="{{$item['qty']}}" id="qty">
                                            <button class="increase_pop items-count btn-plus btn btn-default bootstrap-touchspin-up" type="button" data-url="{{ route('cart.update') }}">+</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="remove-item">
                                    <form class="remove_form">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $key }}" >
                                        <input type="hidden" name="remove" value="{{ $key }}" >
                                        <a href="javascript:;"  class="btn btn-link btn-item-delete remove-item-cart" data-url="{{ route('cart.remove') }}" ><i class="fas fa-times"></i></a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <div class="total-price">
                    <div class="box-price-top">
                        <div class="title">{{ trans('provisional') }}</div>
                        <div class="price totalPrice">{{ number_format($cart->totalPrice, config('config.default'), ',', '.') }}{{ config('config.vnd2') }}</div>
                    </div>
                    <div class="box-price-up">
                        <div class="title">{{ trans('customer.into_money') }}</div>
                        <div class="price totalPrice">{{ number_format($cart->totalPrice, config('config.default'), ',', '.') }}{{ config('config.vnd2') }}</div>
                    </div>
                    <div class="btn-action">
                        <a href="{{ route('checkout') }}" class="btn btn-danger">{{ trans('customer.pay_now') }}</a>
                        <a href="{{ route('home.index') }}" class="btn-btn-default" title="{{ trans('customer.continue_shopping') }}">{{ trans('customer.continue_shopping') }}</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
