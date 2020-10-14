@extends('supplier.layouts.master')
@section('title')
{{ trans('supplier.Manage_Order') }}
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
    <li class="active">{{ trans('supplier.Manage_Order') }}</li>
</ol>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="row">
                    <div class="col-md-5 col-sm-6 col-xs-6">
                        <div id="search-input" class="input-group">
                            <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" placeholder="{{ trans('supplier.search') }}">
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-6 col-xs-6">
                        <div class="btn-group pull-right">
                            <a href="" class="btn btn-flat btn-primary" >
                                <i class="fa fa-refresh"></i><span class="hidden-xs"> {{ trans('supplier.refresh') }}</span>
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
