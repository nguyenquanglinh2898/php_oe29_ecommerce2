@extends('admin.layouts.master')
@section('title', trans('sentences.detail'))
@section('embed-css')
@endsection
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/admin/supplier/show.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/product/index.scss') }}">
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.products.index') }}"><i class="fa fa-dashboard"></i> {{ trans('admin.home') }}</a></li>
        <li><a href=""><i class="fa fa-users"></i> {{ trans('admin.manage_account') }}</a></li>
        <li class="active">{{ $supplier->name }}</li>
    </ol>
@endsection
@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="{{ $supplier->avatar }}" >
                <h3 class="profile-username text-center">{{ $supplier->name }}</h3>
                @if (config('config.status_block') == $supplier->status)
                    <p class="text-center"><span class="label label-{{ config('config.status_block_class') }}">{{ config('config.status_block_name') }}</span></p>
                @elseif (config('config.status_not_active') == $supplier->status)
                    <p class="text-center"><span class="label label-{{ config('config.status_not_active_class') }}">{{ config('config.status_not_active_name') }}</span></p>
                @else
                    <p class="text-center"><span class="label label-{{ config('config.status_active_class') }}">{{ config('config.status_active_name') }}</span></p>
                @endif
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>{{ trans('customer.email') }}</b>
                        <p class="pull-right">{{ $supplier->email }}</p>
                    </li>
                    <li class="list-group-item">
                        <b>{{ trans('admin.phone') }}</b>
                        <p class="pull-right">{{ $supplier->phone }}</p>
                    </li>
                    <li class="list-group-item">
                        <b>{{ trans('admin.created_at') }}</b>
                        <p class="pull-right">{{ date_format($supplier->created_at, config('config.format')) }}</p>
                    </li>
                    <li class="list-group-item">
                        <b>{{ trans('admin.address') }}</b>
                        <p class="pull-right">{{ $supplier->address }}</p>
                    </li>
                </ul>
                @if ($supplier->status == config('config.status_active'))
                    <a href="{{ route('supplier.change_status',['id' => $supplier->id, 'status' => config('config.status_block') ]) }}" class="btn btn-danger btn-block"><b>{{ trans('admin.block_account') }}</b></a>
                @elseif ($supplier->status == config('config.status_block'))
                    <a href="{{ route('supplier.change_status',['id' => $supplier->id, 'status' => config('config.status_active') ]) }}" class="btn btn-success btn-block"><b>{{ trans('admin.unblock_account') }}</b></a>
                @else
                    <a href="{{ route('supplier.change_status',['id' => $supplier->id, 'status' => config('config.status_active') ]) }}" class="btn btn-warning btn-block"><b>{{ trans('admin.active_account') }}</b></a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#comment-timeline" data-toggle="tab">{{ trans('admin.post_product_history') }}</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="comment-timeline">
                    @if ($postProducts->isNotEmpty())
                        <ul class="timeline timeline-inverse">
                            @foreach ($postProducts as $key => $postProduct)
                                <li class="time-label">
                                    <span class="bg-yellow">
                                        <i class="fa fa-clock-o"></i> {{ $postProduct->created_at }}
                                    </span>
                                </li>
                                <li>
                                    <i class="fa fa-check bg-green" aria-hidden="true"></i>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header"><a>{{ $supplier->name }}</a></h3>
                                        <div class="timeline-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped show-table" >
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center show-middle" ></th>
                                                            <th class="text-center show-middle" >{{ trans('admin.images') }}</th>
                                                            <th class="text-center show-middle" >{{ trans('admin.name') }} {{ trans('admin.product') }}</th>
                                                            <th class="text-center show-middle" >{{ trans('admin.brand') }}</th>
                                                            <th class="text-center show-middle" >{{ trans('admin.category') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center show-middle" >{{ $key + 1 }}</td>
                                                            <td class="text-center show-middle" ><img class="profile-user-img img-responsive " src="{{ config('setting.image_folder') . $postProduct->thumbnail }}" ></td>
                                                            <td class="text-center show-middle" >{{ $postProduct->name }}</td>
                                                            <td class="text-center show-middle" >{{ $postProduct->brand }}</td>
                                                            <td class="text-center show-middle" >{{ $postProduct->category->name }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-show btn-icon btn-sm btn-primary tip" title="{{ trans('sentences.detail') }}" data-toggle="modal" data-url="{{ route('admin.products.show', [$postProduct->id]) }}" data-target="#showModal">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            <div class="paginate">
                                {{ $postProducts->links() }}
                            </div>
                            <li>
                                <i class="fa fa-clock-o bg-gray"></i>
                            </li>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    @else
                        <div class="show-div-3">
                            <div class="show-div-2" >{{ trans('admin.post_product_history_blank') }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('embed-js')
@endsection
@section('custom-js')
    <script src="{{ asset('js/admin/product/index.js') }}"></script>
@endsection
