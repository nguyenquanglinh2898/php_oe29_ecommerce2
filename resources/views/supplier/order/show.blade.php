@extends('supplier.layouts.master')
@section('title')
    {{ trans('supplier.manage_order') }}
@endsection
@section('title_content')
    /{{ trans('supplier.order') }}.#{{ $order->id }}
@endsection
@section('embed-css')
    <link rel="stylesheet" href="{{ asset('css/supplier/order/show.css') }}">
@endsection
@section('custom-css')
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('supplier.products.index') }}"><i class="fa fa-dashboard"></i> {{ trans('supplier.home') }}</a></li>
        <li><a href="{{ route('orders.index', config('config.order_status_pending')) }}"><i class="fa fa-list-alt" aria-hidden="true"></i> {{ trans('supplier.manage_order') }}</a></li>
        <li class="active">{{ trans('supplier.order') }}#.{{ $order->id }}</li>
    </ol>
@endsection
@section('content')
    <section class="invoice show-invoice">
        <div id="print-invoice">
            <div class="order-detail">
                <div class="invoice-info">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h4>{{ trans('supplier.account_information') }}</h4>
                            <address>
                                <b>{{ trans('customer.name') }}:</b>&emsp;<i>{{ $order->user->name }}</i><br>
                                <b>{{ trans('customer.phone') }}:</b>&emsp;<i>{{ $order->user->phone }}</i><br>
                                <b>{{ trans('customer.email') }}:</b>&emsp;<i>{{ $order->user->email }}</i><br>
                                <b>{{ trans('customer.address') }}:</b>&emsp;<i>{{ $order->address }}</i>
                            </address>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h4>{{ trans('supplier.order_information') }}</h4>
                            <address>
                                <b>{{ trans('supplier.order') }}:</b>&emsp;<i>#{{ $order->id }}</i><br>
                                <b>{{ trans('supplier.created_at') }}:</b>&emsp;<i>{{ date_format($order->created_at, config('config.format')) }}</i><br>
                                <b>{{ trans('sentences.transporter') }}:</b>&emsp;<i>{{ $order->transporter->name }}</i><br>
                                @if ($order->voucher)
                                    <b>{{ trans('sentences.voucher') }}:</b>&emsp;<i>{{ $order->voucher->name }}</i><br>
                                @else
                                    <b>{{ trans('sentences.voucher') }}:</b>&emsp;<i></i><br>
                                @endif
                                <b>{{ trans('sentences.status') }}:</b>&emsp;
                                @if (config('config.order_status_refuse') == $order->status)
                                    <i class="status-label label label-{{ config('config.order_status_refuse_class') }}">
                                        {{ config('config.order_status_refuse_name') }}
                                    </i>
                                @endif
                                @if (config('config.order_status_cancel') == $order->status)
                                    <i class="status-label label label-{{ config('config.order_status_cancel_class') }}">
                                        {{ config('config.order_status_cancel_name') }}
                                    </i>
                                @endif
                                @if (config('config.order_status_pending') == $order->status)
                                    <i class="status-label label label-{{ config('config.order_status_pending_class') }}">
                                        {{ config('config.order_status_pending_name') }}
                                    </i>
                                @endif
                                @if (config('config.order_status_accept') == $order->status)
                                    <i class="status-label label label-{{ config('config.order_status_accept_class') }}">
                                        {{ config('config.order_status_accept_name') }}
                                    </i>
                                @endif
                                @if (config('config.order_status_finish') == $order->status)
                                    <i class="status-label label label-{{ config('config.order_status_finish_class') }}">
                                        {{ config('config.order_status_finish_name') }}
                                    </i>
                                @endif
                            </address>
                        </div>
                    </div>
                </div>

                <div class="order-items row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center show-th">{{ trans('supplier.stt') }}</th>
                                    <th class="text-center">{{ trans('supplier.product_image') }}</th>
                                    <th class="text-center">{{ trans('supplier.product_name') }}</th>
                                    <th class="text-center">{{ trans('sentences.classification_attributes') }}</th>
                                    <th class="text-center show-th">{{ trans('supplier.quantity') }}</th>
                                    <th class="text-center">{{ trans('supplier.sale_price') }}</th>
                                    <th class="text-center">{{ trans('supplier.total_price') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $key => $item)
                                    <tr>
                                        <td class="show-th">{{ $key + 1 }}</td>
                                        <td class="text-center">
                                            <img src="{{asset(config('setting.image_folder') . $item->productDeltail->product->thumbnail) }}" class="show-td-img">
                                        </td>
                                        <td>{{ $item->productDeltail->product->name }}</td>
                                        <td>{{ str_replace(['{', '}', '"'], " ", $item->productDeltail->list_attributes) }}</td>
                                        <td class="show-th">{{ $item->quantity }}</td>
                                        <td class="text-right"><span class="show-color">{{ number_format($item->sale_price) }}</span></td>
                                        <td class="text-right"><span class="show-color">{{ number_format($item->sale_price * $item->quantity) }} {{ config('setting.currency_unit') }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="payment-information row">
                    <div class="col-xs-6">
                        <p class="lead">{{ trans('supplier.payment_method') }}:</p>
                        @if ($order->paymentMethod->id == config('config.payment_method'))
                            <div class="show-led">
                                <img class="show-lead-img" src="{{ asset(config('config.nganluong')) }}">
                            </div>
                        @else
                            <div class="show-led-1" style="">
                                <img class="show-lead-img" src="{{ asset(config('config.cod')) }}" >
                            </div>
                        @endif
                        <p class="text-muted well well-sm no-shadow show-p" >
                            <b>{{ $order->paymentMethod->name }}</b><br>
                        </p>
                    </div>
                    <div class="col-xs-6">
                        <p class="lead">{{ trans('supplier.payment_detail') }}</p>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>{{ trans('sentences.temporary_price') }}:</th>
                                    <td class="text-right">
                                        <span class="show-color">{{ number_format($order->total - $order->transport_fee + $order->voucher_discount) }} {{ config('setting.currency_unit') }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('sentences.transport_fee') }}:</th>
                                    <td class="text-right">
                                        <span class="show-color">{{ number_format($order->transport_fee) }} {{ config('setting.currency_unit') }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('sentences.voucher') }}:</th>
                                    <td class="text-right">
                                        <span class="show-color">-{{ number_format($order->voucher_discount) }} {{ config('setting.currency_unit') }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('sentences.final_total') }}:</th>
                                    <td class="text-right">
                                        <span class="show-color final-total-price">{{ number_format($order->total) }} {{ config('setting.currency_unit') }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row no-print">
            <div class="col-xs-12">
                @if ($order->status == config('config.order_status_pending'))
                    <a href="{{ route('orders.change_status', ['id' => $order->id, 'status' => config('config.order_status_accept') ]) }}">
                        <button class="btn btn-primary btn-print pull-right">
                            <i class="fa fa-print"></i> {{ trans('supplier.accept') }}
                        </button>
                    </a>
                    <form class="cancel-form" action="{{ route('order.refuse') }}" method="post">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <input type="hidden" name="order_status" value="{{ config('config.order_status_refuse') }}">
                        <button type="submit" class="btn btn-danger btn-print pull-right">
                            <i class="fa fa-print"></i> {{ trans('supplier.refuse') }}
                        </button>
                    </form>
                @elseif ($order->status == config('config.order_status_accept'))
                    <a href="{{ route('orders.change_status', ['id' => $order->id, 'status' => config('config.order_status_finish') ]) }}">
                        <button class="btn btn-success btn-print pull-right">
                            <i class="fa fa-print"></i>{{ trans('supplier.finish') }}
                        </button>
                    </a>
                @endif
            </div>
        </div>
    </section>
@endsection
@section('embed-js')
    <script src="{{ asset('bower_components/print.min/index.js') }}"></script>
@endsection
