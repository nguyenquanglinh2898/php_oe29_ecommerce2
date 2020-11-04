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
        <li><a href=""><i class="fa fa-dashboard"></i> {{ trans('supplier.home') }}</a></li>
        <li><a href=""><i class="fa fa-list-alt" aria-hidden="true"></i> {{ trans('supplier.manage_order') }}</a></li>
        <li class="active">{{ trans('supplier.order') }}#.{{ $order->id }}</li>
    </ol>
@endsection
@section('content')
    <section class="invoice show-invoice">
        <div id="print-invoice">
            @if (session('message'))
                <div class="alert alert-success col-sm-3 col-sm-push-4">
                    {{ session('message') }}
                </div>
            @endif
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                    <div class="show-page-header col-xs-3" >
                        @if (config('config.order_status_refuse') == $order->status)
                            <div>{{ trans('supplier.status') }}   :</div><div class="label label-{{ config('config.order_status_refuse_class') }}">{{ config('config.order_status_refuse_name') }}</div>
                        @endif
                        @if (config('config.order_status_cancel') == $order->status)
                            <div>{{ trans('supplier.status') }}   :</div><div class="label label-{{ config('config.order_status_cancel_class') }}">{{ config('config.order_status_cancel_name') }}</div>
                        @endif
                        @if (config('config.order_status_pending') == $order->status)
                            <div>{{ trans('supplier.status') }}   :</div><div class="label label-{{ config('config.order_status_pending_class') }}">{{ config('config.order_status_pending_name') }}</div>
                        @endif
                        @if (config('config.order_status_accept') == $order->status)
                            <div>{{ trans('supplier.status') }}   :</div><div class="label label-{{ config('config.order_status_accept_class') }}">{{ config('config.order_status_accept_name') }}</div>
                        @endif
                        @if (config('config.order_status_finish') == $order->status)
                            <div>{{ trans('supplier.status') }}   :</div><div class="label label-{{ config('config.order_status_finish_class') }}">{{ config('config.order_status_finish_name') }}</div>
                        @endif
                    </div>
                    </h2>
                </div>
            </div>
            <div class="invoice-info">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        {{ trans('supplier.account_information') }}<br>
                        <br>
                        <address>
                            <b>{{ $order->user->name }}</b><br>
                            {{ trans('supplier.phone') }}: {{ $order->user->phone }}<br>
                            {{ trans('supplier.email') }}: {{ $order->user->email }}<br>
                            {{ trans('supplier.address') }}: {{ $order->user->address }}
                        </address>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        {{ trans('supplier.order_information') }}<br>
                        <br>
                        <address>
                            <b>{{ trans('supplier.order') }} #{{ $order->id }}</b><br>
                            <b>{{ trans('supplier.created_at') }}:</b> {{ date_format($order->created_at, config('config.format')) }}<br>
                            <b>{{ trans('supplier.payment_method') }}:</b> {{ $order->paymentMethod->name }}
                        </address>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="show-th">{{ trans('supplier.stt') }}</th>
                                <th>{{ trans('supplier.product_image') }}</th>
                                <th>{{ trans('supplier.product_name') }}</th>
                                <th>{{ trans('supplier.list_atribute') }}</th>
                                <th class="show-th">{{ trans('supplier.quantity') }}</th>
                                <th>{{ trans('supplier.sale_price') }}</th>
                                <th>{{ trans('supplier.total_price') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $price = 0;
                            @endphp
                            @foreach ($orderItems as $key => $item)
                                @php
                                    $price = $price + $item->sale_price * $item->quantity;
                                @endphp
                                <tr>
                                    <td class="show-th">{{ $key + 1 }}</td>
                                    <td>
                                        <img src="{{ asset(config('config.images_folder') . $item->productDeltail->product->thumbnail) }}" class="show-td-img">
                                    </td>
                                    <td>{{ $item->productDeltail->product->name }}</td>
                                    <td>{{ str_replace(['{', '}', '"'], " ", $item->productDeltail->list_attributes ) }}</td>
                                    <td class="show-th">{{ $item->quantity }}</td>
                                    <td><span class="show-color">{{ number_format($item->sale_price, 0, ',', '.') }}</span></td>
                                    <td><span class="show-color">{{ number_format($item->sale_price * $item->quantity, 0, ',', '.') }}</span></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="7" class="text-right"><b>{{ trans('supplier.total') }} = <span class="show-color">{{ number_format($price, 0, ',', '.') }}</span></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
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
                                <th>{{ trans('supplier.total') }}:</th>
                                <td><span class="show-color">{{ number_format($price, 0, ',', '.') }}</span></td>
                            </tr>
                            <tr>
                                <th>{{ trans('supplier.paid') }}:</th>
                                @if ($order->paymentMethod->id == config('config.payment_method'))
                                    <td><span class="show-color">{{ number_format($price, 0, ',', '.') }}</span></td>
                                @else
                                    <td><span class="show-color"></span></td>
                                @endif
                            </tr>
                            <tr>
                                <th>{{ trans('supplier.payment_fee') }}:</th>
                                <td><span class="show-color"></span></td>
                            </tr>
                            <tr>
                                <th>{{ trans('supplier.total_price') }}:</th>
                                @if ($order->paymentMethod->id == config('config.payment_method'))
                                    <td><span class="show-color"></span></td>
                                @else
                                    <td><span class="show-color">{{ number_format($price, 0, ',', '.') }}</span></td>
                                @endif
                            </tr>
                        </table>
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
                    <a href="{{ route('orders.change_status', ['id' => $order->id, 'status' => config('config.order_status_refuse') ]) }}">
                        <button class="btn btn-danger btn-print pull-right">
                            <i class="fa fa-print"></i> {{ trans('supplier.refuse') }}
                        </button>
                    </a>
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
@section('custom-js')
@endsection
