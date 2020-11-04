@extends('admin.layouts.master')
@section('title', trans('supplier.add_new_voucher'))
@section('embed-css')
@endsection
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/supplier/voucher/index.css') }}">
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> {{ trans('supplier.home') }}</a></li>
        <li><a href=""><i class="fa fa-sliders" aria-hidden="true"></i> {{ trans('supplier.manage_voucher') }}</a></li>
        <li class="active">{{ trans('supplier.add_new_voucher') }}</li>
    </ol>
@endsection
@section('content')
    <form method="POST" accept-charset="utf-8" class="voucher-form">
        @csrf
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="title" class="code"><span class="text-red message-name"></span></label>
                        <div class="form-group">
                            <div class="upload-image text-center">
                                <label for="title" class="code">{{ trans('supplier.code') }} <span class="text-red ">*</span></label>
                                <input type="text" id="upload"  name="name" value="{{ $voucher->name }}" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" name="user_id"  value="{{ Auth::id() }}"  hidden="">
                            <input type="text" name="voucher_id"  value="{{ $voucher->id }}"  hidden="">
                        </div>
                        <div class="form-group">
                            <label for="reservation">{{ trans('supplier.start_date') }}<span class="text-red message-start_date">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="date" class="form-control pull-right" type="date" id="start" name="start_date" value="{{ date(config('config.format_year'),strtotime($voucher->start_date)) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="reservation">{{ trans('supplier.end_date') }}<span class="text-red message-end_date">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="date" class="form-control pull-right" type="date" id="start" name="end_date" value="{{ date(config('config.format_year'),strtotime($voucher->end_date)) }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="title">{{ trans('supplier.description') }} <span class="text-red message-description">*</span></label>
                            <input type="text" name="description" class="form-control" id="title" placeholder="{{ trans('supplier.description') }}" value="{{ $voucher->description }}" autocomplete="off" required="">
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>{{ trans('supplier.quantity') }}<span class="text-red message-quantity">*</span></label>
                                    <input type="number" name="quantity" class="form-control" id="title" placeholder="{{ trans('supplier.quantity') }}" value="{{ $voucher->quantity }}" autocomplete="off" required="">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label>{{ trans('supplier.min_value') }}<span class="text-red message-min_value">*</span></label>
                                    <input type="number" name="min_value" class="form-control" id="title" placeholder="{{ trans('supplier.min_value') }}" value="{{ $voucher->min_value }}" autocomplete="off" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row apply-for">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>{{ trans('supplier.apply_for') }}<span class="text-red">*</span></label>
                                    <select class="form-control select-apply-for" name="">
                                        <option value="{{ config('config.default') }}" @if ($voucher->discount == config("config.default"))
                                            selected=""
                                        @endif>{{ trans('supplier.freeship') }}</option>
                                        <option value="{{ config('config.default_one') }}" @if ($voucher->freeship == null)
                                            selected=""
                                        @endif>{{ trans('supplier.discount') }}</option>
                                        <option value="{{ config('config.default_two') }}" @if ($voucher->discount != config("config.default") && $voucher->freeship != null)
                                            selected=""
                                        @endif>{{ trans('supplier.discount_freeship') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-7 discount" >
                                <div class="form-group">
                                    <label>{{ trans('supplier.discount') }} <span class="text-red message-discount">*</span></label>
                                    <input type="number" name="discount" class="form-control discount-input" id="title" placeholder="{{ trans('supplier.discount') }}" value="{{ $voucher->discount }}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 freeship" >
                            <div class="form-group">
                                <label>{{ trans('supplier.freeship') }} <span class="text-red">*</span></label>
                                <input type="text" name="freeship" class="form-control freeship-input" id="title" placeholder="{{ trans('supplier.freeship') }}" value="{{ config('config.default_one') }}" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-success btn-flat pull-right voucher-btn" data-url="{{ route('voucher.update') }}" data-url2="{{ route('voucher.index') }}"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{ trans('supplier.save') }}</button>
                    <a href="" class="btn btn-danger btn-flat pull-right" ><i class="fa fa-ban" aria-hidden="true"></i> {{ trans('supplier.cancel') }}</a>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('embed-js')
    <script src="{{ asset('bower_components/AdminLTE/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('bower_components/AdminLTE/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
@endsection
@section('custom-js')
    <script src="{{ asset('js/supplier/voucher/new.js') }}"></script>
@endsection
