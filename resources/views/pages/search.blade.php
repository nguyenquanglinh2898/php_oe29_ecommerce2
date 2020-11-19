@extends('layouts.master')
@section('title', trans('customer.Search'))
@section('content')
    <section class="bread-crumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">{{ trans('customer.home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ trans('customer.Search') }}: {{ Request::get('name') }}</li>
            </ol>
        </nav>
    </section>
    <div class="site-search">
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
        <section class="section-products">
            <div class="section-header">
                <h2 class="section-title">{{ trans('customer.by_product_name') }} <span>( {{ $products->count() }} {{ trans('customer.product') }} )</span></h2>
            </div>
            <div class="section-content">
                @if ($products->isEmpty())
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
                                    <a href="{{ route('home.show', $product->id) }}" title="{{ $product->name }}">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="image-product product-thumbnail" data-url="{{ asset(config('config.images_folder') . $product->thumbnail) }}"></div>
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
                                                        <strong>{{ $product->price_range }} {{ config('config.vnd2') }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 animate">
                                                <div class="product-details">
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
        </section>
        @foreach ($categories as $category)
            @if ($category->products->isNotEmpty())
                <section class="section-products">
                    <div class="section-header">
                        <h2 class="section-title">{{ trans('customer.by_category_name') }} <strong class="search-strong"> {{ $category->name }}</strong> <span>( {{ $category->products->count() }} {{ trans('customer.product') }} )</span></h2>
                    </div>
                    <div class="section-content">
                        <div class="row">
                            @foreach ($category->products as $product)
                                <div class="col-md-2 col-md-20">
                                    <div class="item-product">
                                        <a href="{{ route('home.show', $product->id) }}" title="{{ $product->name }}">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="image-product product-thumbnail" data-url="{{ asset(config('config.images_folder') . $product->thumbnail) }}"></div>
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
                                                            <strong>{{ $product->price_range }} {{ config('config.vnd2') }}</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12 animate">
                                                    <div class="product-details">
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif
        @endforeach
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/customer/pages/search.css') }}">
@endsection
@section('js')
    <script src="{{ asset('js/customer/pages/search_page.js') }}"></script>
@endsection
