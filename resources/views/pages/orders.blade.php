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
    <div class="site-orders">
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
        <section class="section-orders">
            <div class="section-header">
                <h2 class="section-title">{{ trans('customer.order') }} <span>({{ $orders->count() }} {{ trans('customer.order') }})</span></h2>
            </div>
            <div class="section-content">
                <div class="row">
                    <div class="col-md-9">
                        <div class="orders-table">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th class="text-center">{{ trans('customer.payment') }}<br>{{ trans('customer.method') }}</th>
                                            <th class="text-center">{{ trans('customer.quantity_product') }}</th>
                                            <th class="text-center">{{ trans('customer.voucher') }}</th>
                                            <th class="text-center">{{ trans('customer.total') }}</th>
                                            <th class="text-center">{{ trans('customer.status') }}</th>
                                            <th class="text-center">{{ trans('customer.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $key => $order)
                                            <tr>
                                                <td class="text-center"><a href="{{ route('home.order_detail', $order->id) }}" title="{{ trans('customer.order_detail') }}">{{ $key + 1 }}</a></td>
                                                <td class="text-center">{{ $order->paymentMethod->name }}</td>
                                                <td class="text-center">{{ $order->orderItems->sum('quantity') }}</td>
                                                <td class="text-center">
                                                    @if (isset($order->voucher))
                                                        {{ $order->voucher->name }}
                                                    @else
                                                        <i class="label label-warning">{{ trans('sentences.none') }}</i>
                                                    @endif
                                                </td>
                                                <td class="text-center search-strong">{{ number_format($order->total, config('config.default'), ',', '.') }}{{ config('config.vnd2') }}</td>
                                                @if (config('config.order_status_refuse') == $order->status)
                                                    <td class="text-center"><a href="{{ route('home.order_detail', $order->id) }}"><span class="label label-{{ config('config.order_status_refuse_class') }}">{{ config('config.order_status_refuse_name') }}</span></a></td>
                                                @endif
                                                @if (config('config.order_status_cancel') == $order->status)
                                                    <td class="text-center"><a href="{{ route('home.order_detail', $order->id) }}"><span class="label label-{{ config('config.order_status_cancel_class') }}">{{ config('config.order_status_cancel_name') }}</span></a></td>
                                                @endif
                                                @if (config('config.order_status_pending') == $order->status)
                                                    <td class="text-center"><a href="{{ route('home.order_detail', $order->id) }}"><span class="label label-{{ config('config.order_status_pending_class') }}">{{ config('config.order_status_pending_name') }}</span></a></td>
                                                @endif
                                                @if (config('config.order_status_accept') == $order->status)
                                                    <td class="text-center"><a href="{{ route('home.order_detail', $order->id) }}"><span class="label label-{{ config('config.order_status_accept_class') }}">{{ config('config.order_status_accept_name') }}</span></a></td>
                                                @endif
                                                @if (config('config.order_status_finish') == $order->status)
                                                    <td class="text-center"><a href="{{ route('home.order_detail', $order->id) }}"><span class="label label-{{ config('config.order_status_finish_class') }}">{{ config('config.order_status_finish_name') }}</span></a></td>
                                                @endif
                                                <td>
                                                    <a href="{{ route('home.order_detail', $order->id) }}" class="btn btn-icon btn-sm btn-primary tip" title="{{ trans('customer.view_order') }}">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                    @if (config('config.order_status_pending') == $order->status)
                                                        <form class="cancel-form" >
                                                            @csrf
                                                            <input type="" name="id" value="{{ $order->id }}" hidden="">
                                                            <button type="button" class="btn btn-icon btn-sm btn-primary tip cancel-order" title="{{ trans('customer.cancel_order') }}" data-url="{{ route('home.order_cancel') }}" data-url2="{{ route('home.order') }}">
                                                                <i class="fa fa-ban" aria-hidden="true"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="online_support">
                            <h2 class="title">{{ trans('customer.ready') }}<br>{{ trans('customer.help_you') }}</h2>
                            <img src="{{ asset(config('config.support_online')) }}">
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
    <script src="{{ asset('js/customer/pages/cancel_order.js') }}"></script>
@endsection
