@extends('admin.layouts.master')
@section('title', trans('admin.manage_supplier'))
@section('embed-css')
    <link rel="stylesheet" href="{{ asset('bower_components/AdminLTE/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection
    <link rel="stylesheet" href="{{ asset('css/admin/supplier/index.css') }}">
@section('custom-css')
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> {{ trans('admin.home') }}</a></li>
        <li class="active">{{ trans('admin.manage_supplier') }}</li>
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
                            <input type="text" class="form-control" placeholder="{{ trans('admin.search') }}">
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-6 col-xs-6">
                        <div class="btn-group pull-right">
                            <a href="{{ route('suppliers.register') }}" class="btn btn-flat btn-warning index-btn"  >
                                <i class="fa fa-refresh"></i><span class="hidden-xs"> {{ trans('admin.register_supplier') }}</span>
                            </a>
                            <a href="{{ route('suppliers.index') }}" class="btn btn-success btn-flat" data-toggle="modal" >
                                <i class="fa fa-user-plus" aria-hidden="true"></i><span class="hidden-xs"> {{ trans('admin.all_supplier') }}</span>
                            </a>
                            <a href="{{ route('suppliers.block') }}" class="btn btn-danger btn-flat" data-toggle="modal" >
                                <i class="fa fa-user-plus" aria-hidden="true"></i><span class="hidden-xs"> {{ trans('admin.block_supplier') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <table id="user-table" class="table table-hover index-user-table" >
                    <thead>
                        <tr>
                            <th data-width="10px">STT</th>
                            <th data-orderable="false" data-width="60px">{{ trans('admin.images') }}</th>
                            <th data-orderable="false" data-width="100px">{{ trans('admin.name') }}</th>
                            <th data-orderable="false">{{ trans('admin.email') }}</th>
                            <th data-orderable="false" data-width="85px">{{ trans('admin.phone') }}</th>
                            <th data-orderable="false">{{ trans('admin.address') }}</th>
                            <th data-width="60px" data-type="date-euro">{{ trans('admin.created_at') }}</th>
                            <th data-width="66px">{{ trans('admin.status') }}</th>
                            <th data-orderable="false" data-width="70px">{{ trans('admin.acction') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $key => $supplier)
                            <tr>
                                <td class="text-center">
                                    {{ $key + 1 }}
                                </td>
                                <td>
                                    <img src="{{ asset($supplier->avatar) }}" class="img-responsive">
                                </td>
                                <td>
                                    <a class="text-left" href="" title="{{ $supplier->name }}">{{ $supplier->name }}</a>
                                </td>
                                <td> {{ $supplier->email }} </td>
                                <td> {{ $supplier->phone }} </td>
                                <td> {{ $supplier->address }} </td>
                                <td> {{ \Carbon\Carbon::parse($supplier->created_at)->format('d/m/Y')}}</td>
                                <td>
                                    @if (config('config.status_block') == $supplier->status)
                                        <p class="text-center"><span class="label label-{{ config('config.status_block_class') }} status-label">{{ config('config.status_block_name') }}</span></p>
                                    @elseif (config('config.status_not_active') == $supplier->status)
                                        <p class="text-center"><span class="label label-{{ config('config.status_not_active_class') }} status-label">{{ config('config.status_not_active_name') }}</span></p>
                                    @else
                                        <p class="text-center"><span class="label label-{{ config('config.status_active_class') }} status-label" >{{ config('config.status_active_name') }}</span></p>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-icon btn-sm btn-primary tip" >
                                        <i class="fa fa-eye"></i>
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
    <script src="{{ asset('bower_componentsAdminLTE/fastclick/lib/fastclick.js') }}"></script>
    <script src="{{ asset('bower_components/date-euro/index.js') }}"></script>
@endsection
@section('custom-js')
    <script src="{{ asset('js/admin/supplier/index.js') }}"></script>
@endsection
