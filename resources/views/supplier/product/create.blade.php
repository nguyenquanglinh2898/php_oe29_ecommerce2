@extends('supplier.layouts.master')

@section('title')
    {{ trans('sentences.create_new_product') }}
@endsection

@section('embed-css')
    <link href="{{ asset('bower_components/bootstrap-fileinput/index.css') }}" rel="stylesheet">
    <link href="{{ asset('bower_components/bootstrap-theme/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bower_components/AdminLTE/bootstrap-daterangepicker/daterangepicker.css') }}">
@endsection

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/supplier/product/create.scss') }}">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('supplier.dashboard') }}">
                <i class="fa fa-dashboard"></i> {{ trans('sentences.home') }}
            </a>
        </li>
        <li>
            <a href="{{ route('supplier.products.index') }}">
                <i class="fa fa-product-hunt" aria-hidden="true"></i> {{ trans('sentences.manage_products') }}
            </a>
        </li>
        <li class="active">{{ trans('sentences.create_new_product') }}</li>
    </ol>
@endsection

@section('content')
    <form id="productForm" action="{{ route('supplier.products.store') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
        @csrf
        <!-- Product Infomation area -->
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ trans('sentences.product_info') }}</h3>
                <div class="box-tools">
                    <!-- button to collapse the box when clicked -->
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="title">{{ trans('sentences.thumbnail') }} <span class="text-red">*</span></label>
                        <div class="upload-image text-center">
                            <!-- Image will display in this area after user choose-->
                            <div class="image-preview">
                                <img src="{{ asset(config('setting.default_image')) }}" id="imagePreview">
                            </div>
                            <label for="upload" class="btn btn-primary btn-sm"><i class="fa fa-folder-open"></i>{{ trans('sentences.choose_picture') }}</label>
                            <input type="file" accept="image/*" id="upload" name="thumbnail">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">{{ trans('sentences.product_name') }} <span class="text-red">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="{{ trans('sentences.product_name') }}" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="weight">{{ trans('sentences.weight') }} ({{ config('setting.weight_unit') }})<span class="text-red">*</span></label>
                                    <input type="text" name="weight" class="form-control" id="sku_code" placeholder="{{ trans('sentences.weight') }}" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="brand">{{ trans('sentences.brand') }} <span class="text-red">*</span></label>
                                    <input type="text" name="brand" class="form-control" id="monitor" placeholder="{{ trans('sentences.brand') }}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group category">
                                    <label>{{ trans('sentences.category') }} <span class="text-red">*</span></label>
                                    <div class="list-category">
                                        <select size="4" id="rootCategory" required>
                                            @foreach ($rootCategories as $rootCategory)
                                                <option class="category-item" value="{{ $rootCategory->id }}">
                                                    {{ $rootCategory->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group category childCategory">
                                    <div class="list-category">
                                        <select size="4" id="childCategory" required>
                                            <!-- child categories of a root category -->
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="category" id="category">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Product Infomation area -->
        <!-- Pictures area -->
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ trans('sentences.pictures') }}</h3>
                <div class="box-tools">
                    <!-- button to collapse the box when clicked -->
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="title">{{ trans('sentences.detail_pictures') }} <span class="text-red">*</span></label>
                            <input type="file" name="product_details[images][]" class="product-detail-images" multiple>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Pictures area -->
        <!-- Classification attribute area -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('sentences.classification_attributes') }}</h3>
                <div class="box-tools">
                    <!-- button to collapse the box when clicked -->
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div id="product-details"></div>
            </div>
            <div class="text-center box-footer">
                <button class="add btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('sentences.add_classification_attribute') }}</button>
            </div>
        </div><!-- Classification attribute area -->
        <!-- Detail infomation and Description area -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#product-information" data-toggle="tab">{{ trans('sentences.product_detail_info') }}</a></li>
                <li><a href="#product-introduction" data-toggle="tab">{{ trans('sentences.product_description') }}</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="product-information">
                    <textarea name="detail_info" rows="20"></textarea>
                </div>
                <div class="tab-pane" id="product-introduction">
                    <textarea name="description" rows="20"></textarea>
                </div>
            </div>
        </div><!-- Detail infomation and Description area -->
        <!-- Button Save and Cancel area -->
        <div class="box box-solid">
            <div class="box-body">
                <div class="form-group">
                    <a href="{{ route('supplier.products.index') }}" class="btn btn-danger btn-flat pull-right">
                        <i class="fa fa-ban" aria-hidden="true"></i> {{ trans('sentences.cancel') }}
                    </a>
                    <button type="submit" class="btn btn-success btn-flat pull-right" id="saveBtn">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> {{ trans('sentences.save') }}
                    </button>
                </div>
            </div>
        </div><!-- Button Save and Cancel area -->
    </form>

    <!-- Classification hidden template area -->
    <div type="text/template" id="product-detail">
        <div class="field-group">
            <div class="box box-solid box-default">
                <div class="box-header">
                    <h3 class="box-title"><span class="name"></span><span class="color"></span></h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool delete"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="key">{{ trans('sentences.classification_key') }} </label>
                                <input type="text" name="product_details[key]" class="form-control key" id="key" placeholder="{{ trans('sentences.color') }}, {{ trans('sentences.size') }},..." autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="value">{{ trans('sentences.classification_value') }} </label>
                                <input type="text" name="product_details[value]" class="form-control value" id="value" placeholder="{{ trans('sentences.white')  }}, {{ config('setting.l_size') }},..." autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="quantity">{{ trans('sentences.quantity') }} </label>
                                <input type="number" min="1" name="product_details[quantity]" class="form-control" id="quantity" placeholder="{{ trans('sentences.quantity') }}" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sale_price">{{ trans('sentences.sale_price') }} </label>
                                <input type="text" name="product_details[sale_price]" class="form-control currency" id="sale_price" placeholder="{{ trans('sentences.sale_price') }}" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Classification hidden template area -->

    <!-- input linked value parse to javascript -->
    <div class="hidden">
        <input id="getChildCategoriesUrl" value="{{ config('setting.get_child_categories_url') }}">
    </div>
@endsection

@section('embed-js')
    <script src="{{ asset('bower_components/AdminLTE/jquery.repeatable.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap-fileinput-js/index.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap-theme-js/index.js') }}"></script>
    <script src="{{ asset('bower_components/AdminLTE/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('bower_components/AdminLTE/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('bower_components/AdminLTE/autoNumeric.js') }}"></script>
    <script src="{{ asset('bower_components/AdminLTE/jquery-validate/jquery.validate.js') }}"></script>
@endsection

@section('custom-js')
    <script src="{{ asset('js/tinymce/tinymce.js') }}"></script>
    <script src="{{ asset('js/supplier/product/create.js') }}"></script>
@endsection
