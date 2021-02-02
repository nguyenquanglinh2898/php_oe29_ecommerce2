<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> {{ trans('sentences.checkout') }} - {{ config('app.name') }} </title>
    <link rel="icon" href="{{ asset('images/my-market-icon.png') }}" type="image/png">

    <!-- Embed CSS -->
    <link rel="stylesheet" href="{{ asset('bower_components/common/css/normalize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/common/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/common/css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/common/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/common/css/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/common/css/sweetalert2.min.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/customer/pages/checkout.css') }}">
</head>
<body>
    <!-- Site Content -->
    <div class="container-fluid">
        <form action="{{ route('cart.pay') }}" method="post">
            @csrf
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="col-header">
                    <h2><a href="{{ route('home.index') }}">{{ config('app.name') }}</a></h2>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="col-title">
                            <h3>{{ trans('sentences.checkout_info') }}</h3>
                        </div>
                        <div class="form-checkout">
                            <div class="form-group">
                                <label for="address">
                                    {{ trans('sentences.address') }}
                                    <span class="text-danger">*</span>
                                </label>
                                @if (isset(Auth::user()->address))
                                    <input name="address" type="text" class="form-control" id="address" placeholder="{{ trans('sentences.address') }}" value="{{ Auth::user()->address }}">
                                @else
                                    <input name="address" type="text" class="form-control" id="address" placeholder="{{ trans('sentences.address') }}">
                                @endif
                                <div class="text-danger">
                                    @error('address')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="row margin-bottom34">
                            <div class="col-title margin-bottom34">
                                <h3>{{ trans('sentences.payment_method') }}</h3>
                            </div>
                            <div class="col-content">
                                <div class="payment-methods">
                                    <ul class="list-content">
                                        @foreach($paymentMethods as $key => $paymentMethod)
                                            @if ($key == 0)
                                                <li class="active">
                                                    <label>
                                                        <input type="radio" value="{{ $paymentMethod->id }}" name="payment_method" checked>
                                                        {{ $paymentMethod->name }}
                                                    </label>
                                                </li>
                                            @else
                                                <li>
                                                    <label>
                                                        <input type="radio" value="{{ $paymentMethod->id }}" name="payment_method">
                                                        {{ $paymentMethod->name }}
                                                    </label>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-title margin-bottom34">
                                <h3>{{ trans('sentences.transporter') }}</h3>
                            </div>
                            <div class="col-content">
                                <div class="transporters">
                                    <ul class="list-content">
                                        @foreach($transporters as $key => $transporter)
                                            @if ($key == 0)
                                                <li class="active">
                                                    <label>
                                                        <input type="radio" value="{{ $transporter->id }}" name="transporter"
                                                               data-url="{{ route('cart.transporter_fee', [$transporter->id]) }}" checked>
                                                        {{ $transporter->name }}
                                                    </label>
                                                </li>
                                            @else
                                                <li>
                                                    <label>
                                                        <input type="radio" value="{{ $transporter->id }}" name="transporter"
                                                               data-url="{{ route('cart.transporter_fee', [$transporter->id]) }}">
                                                        {{ $transporter->name }}
                                                    </label>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="col-order">
                    <div class="col-header">
                        <h2>{{ trans('sentences.your_order') }}
                            <span data-qty="{{ $checkout['totalQuantity'] }}"></span>
                            <span>({{ $checkout['totalQuantity'] }} {{ trans('sentences.products') }})</span>
                        </h2>
                    </div>
                    <div class="col-content">
                        <div class="section-items">

                            @foreach ($checkout['suppliers'] as $supplier)
                                <div class="supplier-items" id="supplierItems{{ $supplier['id'] }}">
                                    <h3 class="supplier-name">{{ $supplier['name'] }}</h3>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('sentences.number') }}</th>
                                                <th>{{ trans('sentences.thumbnail') }}</th>
                                                <th>{{ trans('sentences.product_name') }}</th>
                                                <th>{{ trans('sentences.classification_attributes') }}</th>
                                                <th>{{ trans('sentences.quantity') }}</th>
                                                <th>{{ trans('sentences.price') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($supplier['items'] as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td class="thumbnail-col">
                                                        <a href="{{ route('home.show', $item['product']['id']) }}" class="product-link">
                                                            <img alt="" src="{{ asset(config('config.images_folder') . $item['product']['thumbnail']) }}" >

                                                        </a>
                                                    </td>
                                                    <td><a href="{{ route('home.show', $item['product']['id']) }}" class="product-link">{{ $item['product']['name'] }}</a></td>
                                                    @if (json_decode($item['list_attributes']))
                                                        <td>{{ str_replace(['{', '}', '"'], " ", $item['list_attributes']) }}</td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                    <td>{{ $item['qty'] }}</td>
                                                    <td>{{ number_format($item['price'] * $item['qty']) }}</span>{{ config('setting.currency_unit') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="section-price">
                                        <div class="temp-total-price">
                                            <div class="title">{{ trans('sentences.temporary_price') }}</div>
                                            <div class="price">
                                                <span temp-total-price="{{ $supplier['totalPrice'] }}">{{ number_format($supplier['totalPrice']) }}</span>{{ config('setting.currency_unit') }}
                                            </div>
                                        </div>
                                        <div class="ship-price" weight="{{ $supplier['totalWeight'] }}">
                                            <div class="title">{{ trans('sentences.transport_fee') }}</div>
                                            <div class="price">
                                                <span></span>{{ config('setting.currency_unit') }}
                                                <input type="hidden" name="transport_fee[]" class="transport-fee-input">
                                            </div>
                                        </div>
                                        <div class="voucher-price">
                                            <div class="title">{{ trans('sentences.voucher') }}</div>
                                            <div class="price">
                                                <span></span>{{ config('setting.currency_unit') }}
                                                <input type="hidden" name="voucher_discount[]" class="voucher-discount-input">
                                            </div>
                                        </div>
                                        <div class="total-price">
                                            <div class="title">{{ trans('sentences.total') }}</div>
                                            <div class="price">
                                                <span>{{ number_format($supplier['totalPrice']) }}</span>{{ config('setting.currency_unit') }}
                                                <input type="hidden" name="total[]" class="total-input">
                                            </div>
                                        </div>
                                        <div class="voucher" current-voucher-id="0">
                                            <div class="title">{{ trans('sentences.store_voucher') }}</div>
                                            <div class="select-voucher">
                                                <button type="button" class="select-voucher-btn btn btn-warning" data-toggle="modal"
                                                        data-target="#showVouchers" data-url="{{ route('cart.show_supplier_vouchers') }}"
                                                        data-supplier-id="{{ $supplier['id'] }}">
                                                    {{ trans('sentences.select_a_voucher') }}
                                                </button>
                                            </div>
                                            <input type="hidden" name="voucher_id[]" class="voucher-input">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="section-price">
                            <h3 class="total-header">{{ trans('sentences.final_total') }}</h3>
                            <div class="final-total-price">
                                <div class="title">{{ trans('sentences.total') }}</div>
                                <div class="price">
                                    <span>{{ number_format($checkout['totalPrice']) }}</span>{{ config('setting.currency_unit') }}
                                </div>
                            </div>
                        </div>
                        <div class="btn-order">
                            <button type="submit" class="btn btn-default">{{ trans('sentences.order') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Pop up modal to select vouchers -->
    <div class="modal fade" id="showVouchers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title"><b>{{ trans('sentences.select_a_voucher') }}</b></span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('sentences.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="showModalBody">
                    <!-- Detail information of a product -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success apply-btn" data-dismiss="modal">{{ trans('sentences.apply') }}</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('sentences.close') }}</button>
                </div>
            </div>
        </div>
    </div> <!-- Pop up modal to select vouchers -->

    <div class="hidden">
        <input type="text" id="checkVoucherRoute" value="{{ route('cart.check_voucher') }}">
    </div>

    <!-- Embed Scripts -->
    <script src="{{ asset('bower_components/common/js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('bower_components/common/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bower_components/common/js/sweetalert2.min.js') }}"></script>

    <!-- Custom Scripts -->
    <script src="{{ asset('js/customer/pages/checkout.js') }}"></script>
    <script src="{{ asset('js/customer/pages/show_vouchers.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/customer/pages/search.css') }}">

    <script src="{{ asset('js/customer/pages/search_page.js') }}"></script>
</body>
</html>
