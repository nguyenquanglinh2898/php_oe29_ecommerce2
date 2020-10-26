@extends('admin.layouts.master')
@section('title', 'Quản Lý Quảng Cáo')
@section('embed-css')
    <link rel="stylesheet" href="{{ asset('bower_components/AdminLTE/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection
    <link rel="stylesheet" href="{{ asset('bower_components/AdminLTE/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/supplier/voucher/index.css') }}">
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> {{ trans('supplier.home') }}</a></li>
        <li class="active">{{ trans('supplier.manage_voucher') }}</li>
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
                                <a href="" class="btn btn-flat btn-primary"  >
                                    <i class="fa fa-refresh"></i><span class="hidden-xs"> {{ trans('supplier.refresh') }}</span>
                                </a>
                                <a href="{{ route('voucher.create') }}" class="btn btn-success btn-flat" >
                                    <i class="fa fa-plus" aria-hidden="true"></i><span class="hidden-xs"> {{ trans('supplier.add_new') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    @include('supplier.voucher.table')
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
    <script src="{{ asset('bower_components/date-euro/index.js') }}"></script>
@endsection
@section('custom-js')
    <script src="{{ asset('js/supplier/voucher/index.js') }}"></script>
@endsection
