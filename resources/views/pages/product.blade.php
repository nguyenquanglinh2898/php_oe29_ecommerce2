@extends('layouts.master')
@section('title', $product->name)
@section('content')
    <section class="bread-crumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">{{ trans('customer.home') }}</a></li>
                <li class="breadcrumb-item"><a href="">{{ trans('customer.product') }}</a></li>
                <li class="breadcrumb-item"><a href="">{{ $product->category->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </section>
    <div class="site-product">
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
        <section class="section-product">
            <div class="section-header">
                <h2 class="section-title">{{ $product->name }}</h2>
                <div class="section-sub-title">
                    <div class="sku-code">{{ trans('customer.category') }}: <i>{{ $product->category->name }}</i></div>
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
                    <div class="rate-link" ><span>{{ trans('customer.vote_product') }}</span></div>
                </div>
            </div>
            <div class="section-content">
                <div class="section-infomation">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="image-product">
                                        <div class="image-gallery-0">
                                            <img src="{{ asset($product->thumbnail) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="price-product">
                                        <div class="product-1" >
                                            <div class="product-1">
                                                <div class="sale-price">
                                                    <span class="price">{{ $activeAttribute['price'] }}</span>
                                                    <span class= 'vnd'>{{ config('config.vnd') }}</span>
                                                </div>
                                                <div class="status">
                                                    {{ trans('customer.remaining') }}:
                                                    <span class="remaining" >{{ $activeAttribute['remaining'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="color-product">
                                        <div class="title">{{ trans('customer.list_atribute') }}:</div>
                                        <div class="select-color">
                                            <div class="row">
                                                <form class = "select_form">
                                                    <input type="text" name="product_id" hidden="" value="{{ $product->id }}">
                                                    @foreach ($groupAtribute as $key => $atributes)
                                                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="" can-buy="" data-qty="">
                                                              <div class="">{{ $key }}</div>
                                                              <div class="">
                                                                <select class = "atribute" name="{{ $key }}" data-url="{{ route('home.show_detail') }}">
                                                                    @foreach ($atributes as $value)
                                                                        <option value="{{ $value }}"
                                                                            @if ($value == $activeAttribute[$key])
                                                                                selected
                                                                            @endif>
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                              </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-payment">
                                        <form action="" method="POST" accept-charset="utf-8" class="product_detail_form">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <button type="submit" class="btn btn-lg btn-gray">
                                                        <i class="far fa-money-bill-alt"></i>
                                                        {{ trans('customer.buy_now') }}
                                                    </button>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <button type="button" data-role="addtocart" class="btn btn-lg btn-gray btn-cart btn_buy add_to_cart"
                                                    data-url="{{ route('cart.add', $activeAttribute['id'] ) }}" data-url2="{{ route('cart.show') }}">
                                                        <span class="txt-main"><i class="fa fa-cart-arrow-down padding-right-10"></i>{{ trans('customer.add_cart') }}</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="online_support">
                                <h2 class="title">{{ trans('customer.ready') }}<br>{{ trans('customer.help_you') }}</h2>
                                <img src="{{ asset(config('config.suport_online')) }}">
                                <h3 class="sub_title">{{ trans('customer.call_to_support') }}</h3>
                                <div class="phone">
                                    <a href="" >{{ config('config.phone') }}</a>
                                </div>
                                <div class="or"><span>{{ trans('customer.or') }}</span></div>
                                <h3 class="title">{{ trans('customer.chat') }}</h3>
                                <h3 class="sub_title">{{ trans('customer.support_247') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-description">
                <div class="row">
                    <div class="col-lg-9 col-md-8">
                        <div class="tab-description">
                            <div class="tab-header">
                                <ul class="nav nav-tabs nav-tab-custom">
                                    <li class="active"><a data-toggle="tab" href="#description">{{ trans('customer.description') }}</a></li>
                                    <li><a data-toggle="tab" href="#vote">{{ trans('customer.vote') }}</a></li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div id="description" class="tab-pane fade in active">
                                    <div class="content-description">
                                        @if ($product->description)
                                            {!! $product->description !!}
                                        @else
                                            <p class="text-center"><strong>{{ trans('customer.updating') }}</strong></p>
                                        @endif
                                    </div>
                                    <div class="loadmore" ><a>{{ trans('customer.readmore') }} <i class="fas fa-angle-down"></i></a></div>
                                    <div class="hidemore" ><a>{{ trans('customer.collapse') }} <i class="fas fa-angle-up"></i></a></div>
                                </div>
                                <div id="vote" class="tab-pane fade">
                                    <div class="content-vote">
                                        @if (Auth::check())
                                            <div class="section-rating">
                                                <div class="rating-title">{{ trans('customer.review_product') }}</div>
                                                <div class="rating-content">
                                                    <div class="rating-product"></div>
                                                    <div class="rating-form">
                                                        <form action="" method="POST" accept-charset="utf-8">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="">
                                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                            <textarea name="content" placeholder="{{ trans('customer.content') }}" rows="3"></textarea>
                                                            <button type="submit" class="btn btn-default">{{ trans('customer.send_vote') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="show-rate">
                                            <div class="show-rate-header">
                                                {{ trans('customer.review_user') }}
                                            </div>
                                            <div class="show-rate-content">
                                                <div class="total-rate">
                                                    <div class="total-rate-left">{{ $product->rate }}</div>
                                                    <div class="total-rate-right">
                                                        <div class="start">
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
                                                        <div class="total-user">{{ count($product->comments->toArray()) }}<i class="fas fa-users"></i></div>
                                                    </div>
                                                </div>
                                                @if ($product->comments->isNotEmpty())
                                                    <div class="vote-inner">
                                                        @foreach ($product->comments as $comment)
                                                            <div class="vote-content">
                                                                <div class="vote-content-left">
                                                                    <img src="{{ asset($comment->user->avatar) }}">
                                                                </div>
                                                                <div class="vote-content-right">
                                                                    <div class="name">
                                                                        {{ $comment->user->name }}
                                                                    </div>
                                                                    <div class="vote-start">
                                                                        <div class="star">
                                                                            @for ($i = 1; $i <= config('config.star_vote'); $i++)
                                                                                @if ($comment->rate > $i )
                                                                                    <i class="fas fa-star"></i>
                                                                                @elseif ($comment->rate = $i + 1 && $comment->rate - (int) $comment->rate > 0)
                                                                                    <i class="fas fa-star-half-alt"></i>
                                                                                @else
                                                                                    <i class="far fa-star"></i>
                                                                                @endif
                                                                            @endfor
                                                                        </div>
                                                                        <div class="date">{{ date_format($comment->created_at, config('config.format')) }}</div>
                                                                    </div>
                                                                    <div class="content">{{ $comment->content }}</div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-center"><strong>{{ trans('customer.no_review') }}</strong></p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="infomation-detail">
                            <div class="infomation-header">
                                <h2 class="title">{{ trans('customer.detail_info') }}</h2>
                            </div>
                            <div class="infomation-content">
                            </div>
                            <div class="more-infomation">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#more-infomation">{{ trans('customer.see_more_detail') }}</button>
                            </div>
                        </div>
                        <div class="suggest-product">
                            <div class="suggest-header">
                                <h2>{{ trans('customer.same') }}</h2>
                            </div>
                            @if ($suggestProducts->isNotEmpty() )
                                <div class="suggest-content">
                                    @foreach ($suggestProducts as $suggestproduct)
                                        @if ($suggestproduct->id != $product->id)
                                            <a href="" title="">
                                                <div class="product-content">
                                                    <div class="image">
                                                        <img src=" {{ asset(config('images_folder') . $product->thumbnail) }}" class="img-fluid" width="225px" >
                                                    </div>
                                                    <div class="content">
                                                        <h3 class="title">{{ $product->name }}</h3>
                                                        <div class="start-vote">
                                                            @for ($i = 1; $i <= config('config.star_vote'); $i++)
                                                                @if ($comment->rate > $i )
                                                                    <i class="fas fa-star"></i>
                                                                @elseif ($comment->rate = $i + 1 && $comment->rate - (int) $comment->rate > 0)
                                                                    <i class="fas fa-star-half-alt"></i>
                                                                @else
                                                                    <i class="far fa-star"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <div class="price">
                                                            {{ trans('customer.category') }}: <strong>{{ $suggestproduct->category->name }}</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div id="more-infomation" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
                    <h4 class="modal-title">{{ trans('customer.detail_info_more') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="content">
                        @if ($product->detail_info)
                            {!! $product->detail_info !!}
                        @else
                            <p class="text-center"><strong>{{ trans('customer.updating') }}</strong></p>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('customer.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link type="text/css" rel="stylesheet" href="{{ asset('bower_components/common/lightGallery/dist/css/lightgallery.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('bower_components/common/lightslider/dist/css/lightslider.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/customer/pages/product.css') }}">
@endsection
@section('js')
    <script src="{{ asset('bower_components/common/Rate/rater.js') }}"></script>
    <script src="{{ asset('bower_components/common/lightGallery/dist/js/lightgallery.js') }}"></script>
    <script src="{{ asset('bower_components/common/lightslider/dist/js/lightslider.js') }}"></script>
    <script src="{{ asset('js/customer/pages/product.js') }}"></script>
@endsection
