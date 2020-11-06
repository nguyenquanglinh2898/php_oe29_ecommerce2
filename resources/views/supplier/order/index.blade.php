@extends('supplier.layouts.master')
@section('title')
    {{ trans('supplier.manage_order') }}
    @switch($status)
        @case (config('config.order_status_refuse'))
            <span>{{ trans('supplier.status') }}   :</span><span class="label label-{{ config('config.order_status_refuse_class') }}">{{ config('config.order_status_refuse_name') }}</span>
            @break
        @case (config('config.order_status_cancel'))
            <span>{{ trans('supplier.status') }}   :</span><span class="label label-{{ config('config.order_status_cancel_class') }}">{{ config('config.order_status_cancel_name') }}</span>
            @break
        @case (config('config.order_status_pending'))
            <span>{{ trans('supplier.status') }}   :</span><span class="label label-{{ config('config.order_status_pending_class') }}">{{ config('config.order_status_pending_name') }}</span>
            @break
        @case (config('config.order_status_accept'))
            <span>{{ trans('supplier.status') }}   :</span><span class="label label-{{ config('config.order_status_accept_class') }}">{{ config('config.order_status_accept_name') }}</span>
            @break
        @case (config('config.order_status_finish'))
            <span>{{ trans('supplier.status') }}   :</span><span class="label label-{{ config('config.order_status_finish_class') }}">{{ config('config.order_status_finish_name') }}</span>
            @break
    @endswitch

@endsection
@section('title_content')
    /{{ trans('supplier.new_order') }}
@endsection
@section('embed-css')
    <link rel="stylesheet" href="{{ asset('bower_components/AdminLTE/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/supplier/order/index.css') }}">
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> {{ trans('supplier.home') }}</a></li>
        <li class="active">{{ trans('supplier.manage_order') }}</li>
    </ol>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div id="search-input" class="input-group">
                            <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" placeholder="{{ trans('supplier.search') }}">
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <div class="btn-group pull-right">
                            <a href="{{ route('orders.index', config('config.order_status_pending')) }}" class="btn btn-flat btn-warning index-btn"  >
                                <i class="fa fa-refresh"></i><span class="hidden-xs"> {{ trans('supplier.order_pending') }}</span>
                            </a>
                            <a href="{{ route('orders.index', config('config.order_status_accept')) }}" class="btn btn-primary btn-flat" data-toggle="modal" >
                                <i class="fa fa-refresh" aria-hidden="true"></i><span class="hidden-xs"> {{ trans('supplier.order_accepted') }}</span>
                            </a>
                             <a href="{{ route('orders.index', config('config.order_status_finish')) }}" class="btn btn-success btn-flat" data-toggle="modal" >
                                <i class="fa fa-refresh" aria-hidden="true"></i><span class="hidden-xs"> {{ trans('supplier.order_finished') }}</span>
                            </a>
                            <a href="{{ route('orders.index', config('config.order_status_refuse')) }}" class="btn btn-danger btn-flat" data-toggle="modal" >
                                <i class="fa fa-refresh" aria-hidden="true"></i><span class="hidden-xs"> {{ trans('supplier.order_resfused') }}</span>
                            </a>
                            <a href="{{ route('orders.index', config('config.order_status_cancel')) }}" class="btn btn-default btn-flat" data-toggle="modal" >
                                <i class="fa fa-refresh" aria-hidden="true"></i><span class="hidden-xs"> {{ trans('supplier.order_canceled') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <table id="order-table" class="table table-hover index-order-table">
                    <thead>
                        <tr>
                            <th data-width="10px">STT</th>
                            <th data-orderable="false" data-width="150px">{{ trans('supplier.account') }}</th>
                            <th data-orderable="false" data-width="150px">{{ trans('supplier.customer_name') }}</th>
                            <th data-orderable="false">{{ trans('supplier.email') }}</th>
                            <th data-orderable="false" data-width="150px">{{ trans('supplier.phone') }}</th>
                            <th data-orderable="false">{{ trans('supplier.payment_method') }}</th>
                            <th data-width="150px" data-type="date-euro">{{ trans('supplier.created_at') }}</th>
                            <th data-orderable="false" data-width="60px">{{ trans('supplier.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $key => $order)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>
                                    <a href="" class="text-left" title="{{ $order->user->username }}">{{ $order->user->username }}</a>
                                </td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->user->email }}</td>
                                <td>{{ $order->user->phone }}</td>
                                <td>{{ $order->paymentMethod->name }}</td>
                                <td> {{ \Carbon\Carbon::parse($order->created_at)->format(config('config.format'))}}</td>
                                <td>
                                    <a href="{{ route('orders.show', $order->id ) }}" class="btn btn-icon btn-sm btn-primary tip" title="">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('embed-js')
    <script src="{{ asset('bower_components/AdminLTE/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/AdminLTE/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('bower_components/AdminLTE/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('bower_components/AdminLTE/fastclick/lib/fastclick.js') }}"></script>
    <script src="{{ asset('js/supplier/order/index.js') }}"></script>
    <script src="{{ asset('bower_components/date-euro/index.js') }}"></script>
@endsection
    @section('custom-js')
@endsection
