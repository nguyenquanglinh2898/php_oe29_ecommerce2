@extends('layouts.master')
@section('title', trans('customer.order'))
@section('content')
    <section class="bread-crumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">{{ trans('customer.home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ trans('customer.order') }}</li>
            </ol>
        </nav>
    </section>
    <div class="site-order">
        <section class="section-advertise">
            <div class="content-advertise">
                <div id="slide-advertise" class="owl-carousel">
                    @foreach ($slides as $slide)
                        <div class="slide-advertise-inner"  data-dot="<button>{{ $slide->title }}</button>">
                            <img src="{{ asset(config('config.images_folder') . $slide->image) }}" alt="">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="section-order">
            <div class="section-header">
                <div class="section-header-left">
                    <h2 class="section-title">{{ trans('customer.order') }}
                        <span>( {{ $order->orderItems->sum('quantity') }} {{ trans('customer.product') }} )</span>
                        @if (config('config.order_status_refuse') == $order->status)
                            <span class="label label-{{ config('config.order_status_refuse_class') }}">{{ config('config.order_status_refuse_name') }}</span>
                        @endif
                        @if (config('config.order_status_cancel') == $order->status)
                            <span class="label label-{{ config('config.order_status_cancel_class') }}">{{ config('config.order_status_cancel_name') }}</span>
                        @endif
                        @if (config('config.order_status_pending') == $order->status)
                         <span class="label label-{{ config('config.order_status_pending_class') }}">{{ config('config.order_status_pending_name') }}</span>
                        @endif
                        @if (config('config.order_status_accept') == $order->status)
                            <span class="label label-{{ config('config.order_status_accept_class') }}">{{ config('config.order_status_accept_name') }}</span>
                        @endif
                        @if (config('config.order_status_finish') == $order->status)
                           <span class="label label-{{ config('config.order_status_finish_class') }}">{{ config('config.order_status_finish_name') }}</span>
                        @endif
                    </h2>
                </div>
                <div class="section-header-right">
                    {{ trans('customer.created_at') }}: {{ date_format($order->created_at, config('config.format')) }}
                </div>
            </div>
            <div class="section-content">
                <div class="row">
                    <div class="col-md-9">
                        <div class="order-info">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="order-info-left">
                                        <div class="order-info-header">
                                            <h3 class="text-center">{{ trans('customer.account_information') }}</h3>
                                        </div>
                                        <div class="order-info-content">
                                            <div><span>{{ trans('customer.name') }}</span> <span>{{ $order->user->name }}</span></div>
                                            <div><span>{{ trans('customer.email') }}</span> <span>{{ $order->user->email }}</span></div>
                                            <div><span>{{ trans('customer.phone') }}</span> <span>{{ $order->user->phone }}</span></div>
                                            <div><span>{{ trans('customer.address') }}</span> <span>{{ $order->user->address }}</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="order-info-right">
                                        <div class="order-info-header">
                                            <h3 class="text-center">{{ trans('customer.purchase_information') }}</h3>
                                        </div>
                                        <div class="order-info-content">
                                            <div><span>{{ trans('customer.name') }}</span> <span>{{ $order->user->name }}</span></div>
                                            <div><span>{{ trans('customer.email') }}</span> <span>{{ $order->user->email }}</span></div>
                                            <div><span>{{ trans('customer.phone') }}</span> <span>{{ $order->user->phone }}</span></div>
                                            <div><span>{{ trans('customer.address') }}</span> <span>{{ $order->user->address }}</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="order-info-center">
                                        <div class="order-info-header">
                                            <h3 class="text-center">{{ trans('customer.order_information') }}</h3>
                                        </div>
                                        <div class="order-info-content">
                                            <div><span>{{ trans('customer.payment_method') }}</span> <span>{{ $order->paymentMethod->name }}</span></div>
                                            <div><span>{{ trans('customer.quantity') }}</span> <span>{{ $order->orderItems->sum('quantity') }} {{ trans('customer.product') }}</span></div>
                                            <div><span>{{ trans('customer.total') }}</span> <span class="search-strong">{{ number_format($order->total, config('config.default'), ',', '.') }}{{ config('config.vnd2') }}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="order-table">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th class="text-center">{{ trans('customer.image') }}<br>{{ trans('customer.product') }}</th>
                                            <th class="text-center">{{ trans('customer.name') }}<br>{{ trans('customer.product') }}</th>
                                            <th class="text-center">{{ trans('customer.list_attributes') }}</th>
                                            <th class="text-center">{{ trans('quantity') }}</th>
                                            <th class="text-center">{{ trans('customer.total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderItems as $key => $orderItem)
                                            <tr>
                                                <td class="text-center">{{ $key + config('config.default') }}</td>
                                                <td class="text-center"><a href="" ><img src="{{ asset($orderItem->productDeltail->product->thumbnail) }}" alt=""  height="55px"></a></td>
                                                <td class="text-center">{{ $orderItem->productDeltail->product->name }}</td>
                                                <td class="text-center">{{ str_replace(['{', '}', '"'], " ", $orderItem->productDeltail->list_attributes) }}</td>
                                                <td class="text-center">{{ $orderItem->quantity }}</td>
                                                <td class="text-center search-strong">{{ number_format($orderItem->sale_price, config('config.default'), ',', '.') }}{{ config('config.vnd2') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="online_support">
                            <h2 class="title">{{ trans('customer.ready') }}<br>{{ trans('customer.help_you') }}</h2>
                            <img src="{{ asset(config('config.suport_online')) }}">
                            <h3 class="sub_title">{{ trans('customer.call_to_support') }}</h3>
                            <div class="phone">
                                <a href="" >{{ config('config.phone') }}</a>
                            </div>
                            <div class="or"><span>{{ trans('customer.or') }}</span></div>
                            <h3 class="title">{{ trans('customer.chat') }}</h3>
                            <h3 class="sub_title">{{ trans('customer.support_247') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/customer/pages/search.css') }}">
@endsection
@section('js')
    <script src="{{ asset('js/customer/pages/search_page.js') }}"></script>
@endsection
