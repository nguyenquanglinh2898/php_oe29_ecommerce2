@extends('layouts.master')
@section('title', trans('customer.home'))
@section('content')
    <div class="site-home">
        <section class="section-advertise">
            <div class="row">
                <div class="col-md-8">
                    <div class="content-advertise">
                        <div id="slide-advertise" class="owl-carousel">
                            @foreach ($slides as $slide)
                                <img src=" {{ asset(config('config.images_folder') . $slide->image) }}"  height="310px" class="slide-advertise-inner"  data-dot="<button>{{ $slide->title }}</button>">
                            @endforeach
                        </div>
                        <div class="custom-dots-slide-advertises"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="new-posts">
                        <div class="posts-header">
                            <h3 class="posts-title">{{ trans('customer.new_voucher') }}</h3>
                        </div>
                        <div class="posts-content scroll">
                            @foreach ($newVouchers as $voucher)
                                <div class="post-item">
                                    <a href="" title="{{ $voucher->name }}">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-3 col-xs-3 col-xs-responsive text-center">
                                                <img src="{{ asset($voucher->user->avatar) }}" class="img-fluid" height="55px">
                                            </div>
                                            <div class="col-md-8 col-sm-9 col-xs-9 col-xs-responsive">
                                                <div class="post-item-content">
                                                    <h4 class="post-content-title">{{ $voucher->description }}</h4>
                                                    <b class="voucher-item">
                                                        <span>{{ trans('sentences.remaining') }}: </span>
                                                        <span>{{ $voucher->quantity }}</span>
                                                    </b>
                                                    <p class="post-content-date">
                                                        <span>{{ trans('sentences.expire_date') }}: </span>
                                                        <span>{{ $voucher->start_date }} - {{ $voucher->end_date }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-favorite-products">
            <div class="section-header">
                <h2 class="section-title">{{ trans('customer.product_favorites') }}</h2>
            </div>
            <div class="section-content">
                <div id="slide-favorite" class="owl-carousel">
                    @foreach ($favoriteProducts as $product)
                        <div class="item-product">
                            <a href="{{ route('home.show', $product->id) }}" title="{{ $product->name }}">
                                <div class="image-product product-thumbnail" data-url="{{ asset(config('config.images_folder') . $product->thumbnail) }}"></div>
                                <div class="content-product">
                                    <h3 class="title">{{ $product->name }}</h3>
                                    <div class="start-vote">
                                        @for ($i = 1; $i <= config('config.vote_star'); $i++)
                                            @if ($product->rate > $i )
                                                <i class="fas fa-star"></i>
                                            @elseif ($product->rate = $i + 1 && $product->rate - (int) $product->rate > 0)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <div class="price title">
                                        {{ trans('customer.category') }}: <strong>{{ $product->catname }}</strong>
                                    </div>
                                    <div class="price title">
                                        {{ trans('customer.price') }}: <strong>{{ $product->price_range }}</strong>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="section-products">
            <div class="section-header">
                <div class="section-header-left">
                    <h2 class="section-title">{{ trans('customer.product_news') }}</h2>
                </div>
            </div>
            <div class="section-content">
                <div class="row">
                    @foreach ($newProducts as $product)
                        <div class="col-md-2 col-md-20">
                            <div class="item-product">
                                <a href="{{ route('home.show', $product->id) }}" title="{{ $product->name }}">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="image-product product-thumbnail" data-url="{{ asset(config('config.images_folder') . $product->thumbnail) }}"></div>
                                            <div class="content-product">
                                                <h3 class="title">{{ $product->name }}</h3>
                                                <div class="start-vote">
                                                    @for ($i = 1; $i <= config('config.vote_star'); $i++)
                                                        @if ($product->rate > $i )
                                                            <i class="fas fa-star"></i>
                                                        @elseif ($product->rate = $i + 1 && $product->rate - (int) $product->rate > 0)
                                                            <i class="fas fa-star-half-alt"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <div class="price title">
                                                    {{ trans('customer.category') }}: <strong>{{ $product->category->name }}</strong>
                                                </div>
                                                <div class="price title">
                                                    {{ trans('customer.price') }}: <strong>{{ $product->price_range }}</strong>
                                                </div>
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
    </div>
@endsection
@section('css')
@endsection
@section('js')
    @include('sweetalert::alert')
    <script src="{{ asset('js/customer/pages/home.js') }}"></script>
@endsection
