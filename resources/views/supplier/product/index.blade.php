@extends('supplier.layouts.master')

@section('title')
    {{ trans('sentences.manage_products') }}
@endsection

@section('embed-css')
    <link rel="stylesheet" href="{{ asset('bower_components/AdminLTE/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/supplier/product/index.scss') }}">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('supplier.dashboard') }}">
                <i class="fa fa-dashboard"></i> {{ trans('sentences.home') }}
            </a>
        </li>
        <li class="active">{{ trans('sentences.manage_products') }}</li>
    </ol>
@endsection

@section('content')
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-5 col-sm-6 col-xs-6">
                            <div id="search-input" class="input-group">
                                <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" placeholder="{{ trans('sentences.search') }}...">
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-6 col-xs-6">
                            <div class="btn-group pull-right">
                                <a href="{{ route('supplier.products.index') }}" class="btn btn-flat btn-primary" id="refresh-btn">
                                    <i class="fa fa-refresh"></i><span class="hidden-xs"> {{ trans('sentences.refresh') }}</span>
                                </a>
                                <a href="{{ route('supplier.products.create') }}" class="btn btn-success btn-flat">
                                    <i class="fa fa-plus" aria-hidden="true"></i><span class="hidden-xs"> {{ trans('sentences.create_new_product') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <table id="product-table" class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('sentences.profile_image') }}</th>
                            <th>{{ trans('sentences.product_name') }}</th>
                            <th>{{ trans('sentences.rating') }}</th>
                            <th>{{ trans('sentences.category') }}</th>
                            <th>{{ trans('sentences.created_at') }}</th>
                            <th>{{ trans('sentences.remaining') }}</th>
                            <th>{{ trans('sentences.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td class="thumbnail-col">
                                        <img src="{{ $product->thumbnail }}" alt="thumbnail">
                                    </td>
                                    <td>
                                        <a class="text-left" href="" title="{{ $product->name }}">{{ $product->name }}</a>
                                    </td>
                                    <td>{{ $product->rate }}/{{ config('setting.max_rating') }}</td>
                                    <td>
                                        <a class="text-left" href="" title="{{ $product->name }}">{{ $product->category->name }}</a>
                                    </td>
                                    <td> {{ $product->created_at }}</td>
                                    <td> {{ $product->remaining }}</td>
                                    <td>
                                        <a class="btn btn-show btn-icon btn-sm btn-primary tip" title="{{ trans('sentences.detail') }}" data-toggle="modal" data-url="{{ route('supplier.products.show', [$product->id]) }}" data-target="#showModal">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('supplier.products.edit', [$product->id]) }}" class="btn btn-icon btn-sm btn-primary tip" title="{{ trans('sentences.edit') }}">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        <a class="btn btn-icon btn-sm btn-danger deleteDialog tip" data-toggle="modal" data-target="#delete-{{ $product->id }}" title="{{ trans('sentences.delete') }}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <div class="modal fade" id="delete-{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{ trans('sentences.comfirm_delete') }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="POST" action="{{ route('supplier.products.destroy', [$product->id]) }}">
                                                            @csrf
                                                            <input type="submit" class="btn btn-danger" value="{{ trans('sentences.yes') }}">
                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('sentences.no') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title"><b>{{ trans('sentences.product_details') }}</b></span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('sentences.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="showModalBody">
                    <!-- Detail information of a product -->
                </div>
            </div>
        </div>
    </div>

    <!-- localization words parsed to javascript file throw hidden input-->
    <div class="hidden">
        <input id="noRecord" value="{{ trans('sentences.could_not_find_any_record') }}">
        <input id="displayPage" value="{{ trans('sentences.display_page') }}">
        <input id="of" value="{{ trans('sentences.of') }}">
        <input id="productsWord" value="{{ trans('sentences.products') }}">
        <input id="searchedFrom" value="{{ trans('sentences.searched_from') }}">
        <input id="next" value="{{ trans('sentences.next') }}">
        <input id="previous" value="{{ trans('sentences.previous') }}">
    </div>
    <!-- /localizations words -->
@endsection

@section('embed-js')
    <script src="{{ asset('bower_components/AdminLTE/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/AdminLTE/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('bower_components/AdminLTE/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('bower_components/AdminLTE/fastclick/lib/fastclick.js') }}"></script>
    <script src="{{ asset('bower_components/date-euro/data-table.js') }}"></script>
@endsection

@section('custom-js')
    <script src="{{ asset('js/admin/product/index.js') }}"></script>
@endsection
