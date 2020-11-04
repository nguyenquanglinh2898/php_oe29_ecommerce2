@extends('layouts.master')
@section('title', $category->name)
@section('content')
    <section class="bread-crumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">{{ trans('customer.home') }}</a></li>
                <li class="breadcrumb-item"><a href="">{{ trans('customer.product') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
            </ol>
        </nav>
    </section>
    <div class="site-producer">
        <section class="section-advertise">
            <div class="content-advertise">
                <div id="slide-advertise" class="owl-carousel">
                    @foreach ($slides as $slide)
                        <div class="slide-advertise-inner"  data-dot="<button>{{ $slide->title }}</button>">
                            <img src="{{ asset(config('config.images_folder') . $slide->image) }}" alt="">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="section-filter">
            <div class="section-header">
                @if ($category->children->isNotEmpty())
                    <a href="{{ route('home.category', $category->id) }}"><h2 class="section-title">{{ trans('customer.category') }}:{{ $category->name }}</a></h2>
                @else
                    <a href="{{ route('home.category', $category->parent->id) }}"><h2 class="section-title">{{ trans('customer.category') }}:{{ $category->parent->name }}</a></h2>
                @endif
                </h2>
            </div>
            <div class="section-content">
                <form action="{{ route('home.filter') }}" method="GET" accept-charset="utf-8">
                    @csrf
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 col-xs-6">
                                    <input type="text" name="name" placeholder="{{ trans('customer.search') }}" value="{{ Request::input('name') }}">
                                </div>
                                @if ($category->children->isNotEmpty())
                                    <div class="col-md-3 col-sm-6 col-xs-6">
                                        <select name='category_id'>
                                            <option value="{{ $category->id }}" >{{ $category->name }}</option>
                                            @foreach ($category->children as $categoryChidldren)
                                                <option value="{{ $categoryChidldren->id }}" @if ($categoryChidldren->id == Request::input('category_id'))
                                                    selected=""
                                                @endif>{{ $categoryChidldren->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <div class="col-md-3 col-sm-6 col-xs-6">
                                        <select name='category_id'>
                                            <option value="{{ $category->parent->id }}" >{{ $category->parent->name }}</option>
                                            @foreach ($category->parent->children as $categoryChidldren)
                                                <option value="{{ $categoryChidldren->id }}" @if ($categoryChidldren->id == Request::input('category_id'))
                                                    selected=""
                                                @endif>{{ $categoryChidldren->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="col-md-3 col-sm-6 col-xs-6">
                                    <select name='price_range'>
                                        <option value="" selected>
                                            {{ trans('customer.product_price') }}
                                        </option>
                                        <option value='{{ config('config.asc') }}' >
                                            {{ trans('customer.price_low_hight') }}
                                        </option>
                                        <option value='{{ config('config.desc') }}' >
                                            {{ trans('customer.price_hight_low') }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-6">
                                    <select name='type'>
                                        <option value="" selected="">
                                            {{ trans('customer.product_type') }}
                                        </option>
                                        <option value='{{ config('config.rate') }}' >
                                            {{ trans('customer.hight_rate') }}
                                        </option>
                                        <option value='{{ config('config.order') }}' >
                                            {{ trans('customer.hight_order') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-default">{{ trans('customer.filter_products') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <section class="section-products">
            <div class="section-header">
                <div class="section-header-left">
                    <h2 class="section-title">{{ $category->name }}</h2>
                </div>
                <div class="section-header-right">
                    @if ($category->children->isNotEmpty())
                        <ul>
                            @foreach ($category->children as $categoryChidldren)
                            <li><a href="{{ route('home.category', $categoryChidldren->id) }}" title="{{ $categoryChidldren->name }}">{{ $categoryChidldren->name }}</a></li>
                            @endforeach
                        </ul>
                    @else
                        <ul>
                            @foreach ($category->parent->children as $categoryChidldren)
                            <li><a href="{{ route('home.category', $categoryChidldren->id) }}" title="{{ $categoryChidldren->name }}">{{ $categoryChidldren->name }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <div class="section-content">
                @if ($category->products->isEmpty())
                <div class="empty-content">
                    <div class="icon"><i class="fab fa-searchengin"></i></div>
                    <div class="title">{{ trans('customer.ops') }}</div>
                    <div class="content">{{ trans('customer.product_not_found') }}</div>
                </div>
                @else
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-md-2 col-md-20">
                                <div class="item-product">
                                    <a href="" title="{{ $product->name }}">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="image-product" >
                                                    <img src="{{ asset(config('config.images_folder') . $product->thumbnail) }}" class="img-responsive">
                                                </div>
                                                <div class="content-product">
                                                    <h3 class="title">{{ $product->name }}</h3>
                                                    <div class="start-vote">
                                                        @for ($i = 1; $i <= config('config.star_vote'); $i++)
                                                            @if ($product->rate > $i )
                                                                <i class="fas fa-star"></i>
                                                            @elseif ($product->rate = $i + 1 && $product->rate - (int) $product->rate > 0)
                                                                <i class="fas fa-star-half-alt"></i>
                                                            @else
                                                                <i class="far fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <div class="price">
                                                        {{ $product->price_range }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="section-footer text-center">
                {{ $products->appends(Request::except('page'))->render() }}
            </div>
        </section>
    </div>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/customer/pages/search.css') }}">
@endsection
@section('js')
<script src="{{ asset('js/customer/pages/search_page.js') }}"></script>
@endsection
