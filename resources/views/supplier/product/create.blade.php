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
                        <div class="text-center text-red">
                            @error('thumbnail')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">{{ trans('sentences.product_name') }} <span class="text-red">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="{{ trans('sentences.product_name') }}" autocomplete="off">
                                    <div class="text-red">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="weight">{{ trans('sentences.weight') }} ({{ config('setting.weight_unit') }})<span class="text-red">*</span></label>
                                    <input type="number" name="weight" min="0" class="form-control" placeholder="{{ trans('sentences.weight') }}" autocomplete="off">
                                    <div class="text-red">
                                        @error('weight')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="brand">{{ trans('sentences.brand') }}</label>
                                    <input type="text" name="brand" class="form-control" id="monitor" placeholder="{{ trans('sentences.brand') }}" autocomplete="off">
                                    <div class="text-red">
                                        @error('brand')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group category">
                                    <label>{{ trans('sentences.category') }} <span class="text-red">*</span></label>
                                    <div class="list-category">
                                        <select size="4" id="rootCategory">
                                            @foreach ($rootCategories as $rootCategory)
                                                <option class="category-item" value="{{ $rootCategory->id }}">
                                                    {{ $rootCategory->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="text-red">
                                            @error('category_id')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group category childCategory">
                                    <div class="list-category">
                                        <select size="4" id="childCategory">
                                            <!-- child categories of a root category -->
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="category_id" id="category">
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
                            <label for="title">{{ trans('sentences.detail_pictures') }}</label>
                            <input type="file" name="images[]" accept="image/*" class="product-detail-images" multiple>
                        </div>
                        <div class="text-red">
                            @error('images.*')
                                {{ $message }}
                            @enderror
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
                <div id="product-details">
                    <div>
                        <div class="row">
                            <div class="col-md-4" id="remainingArea">
                                <div class="form-group">
                                    <label for="remaining">{{ trans('sentences.remaining') }}<span class="text-red">*</span></label>
                                    <input type="number" name="remaining[]" min="0" class="form-control remaining" placeholder="{{ trans('sentences.remaining') }}" autocomplete="off">
                                    <div class="text-red">
                                        @error('remaining.*')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" id="priceArea">
                                <div class="form-group">
                                    <label for="remaining">{{ trans('sentences.sale_price') }}<span class="text-red">*</span></label>
                                    <input type="number" name="price[]" min="0" class="form-control price" placeholder="{{ trans('sentences.sale_price') }}" autocomplete="off">
                                    <div class="text-red">
                                        @error('price.*')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="attributes"></div>
                        </div>
                        <div class="row text-center col-md-12">
                            <button type="button" id="addAttrBtn" class="btn btn-success">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                {{ trans('sentences.add_classification_attribute') }}
                            </button>
                            <button type="button" id="updateBtn" class="btn btn-primary">{{ trans('sentences.update') }}</button>
                        </div>
                    </div>
                    <div class="text-red">
                        @error('attr.*')
                            {{ $message }}
                        @enderror
                    </div>
                    <table class="table table-bordered" id="productDetailTable">
                        <thead>
                            <tr id="attrTableHeader"></tr>
                        </thead>
                        <tbody id="attrTableBody">
                            <!-- phần supplier nhập thông tin -->
                        </tbody>
                    </table>

                    <input type="hidden" id="numOfRow" name="numOfRow" value="0">

                    <button type="button" id="addRowBtn" class="btn btn-success">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        {{ trans('sentences.add_more_row') }}
                    </button>

                </div>
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
                    <div class="text-red">
                        @error('detail_info')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="tab-pane" id="product-introduction">
                    <textarea name="description" rows="20"></textarea>
                    <div class="text-red">
                        @error('description')
                            {{ $message }}
                        @enderror
                    </div>
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

    <!-- input linked value parse to javascript -->
    <div class="hidden">
        <input id="getChildCategoriesUrl" value="{{ config('setting.get_child_categories_url') }}">

        <input id="remainingCol" value="{{ trans('sentences.remaining') }}">
        <input id="priceCol" value="{{ trans('sentences.sale_price') }}">
        <input id="actionCol" value="{{ trans('sentences.action') }}">
        <input id="attrName" value="{{ trans('sentences.attribute_name') }}">
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
