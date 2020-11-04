@extends('layouts.master')
@section('title', Auth::user()->name)
@section('content')
<section class="bread-crumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">{{ trans('customer.home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ trans('customer.account') }}</li>
        </ol>
    </nav>
</section>
<div class="site-user">
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
    <section class="section-user">
        <div class="section-header">
            <h2 class="section-title">{{ trans('customer.account_information') }}</h2>
        </div>
        <div class="section-content">
            <div class="row">
                <div class="col-lg-9 col-md-8">
                    <div class="user">
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
                                <div class="user-avatar">
                                    <img src="{{ asset(Auth::user()->avatar) }}" title="{{ Auth::user()->name }}">
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-8">
                                <div class="user-info">
                                    <div class="info">
                                        <div class="info-label">{{ trans('customer.name') }}</div>
                                        <div class="info-content">{{ Auth::user()->name }}</div>
                                    </div>
                                    <div class="info">
                                        <div class="info-label">{{ trans('customer.email') }}</div>
                                        <div class="info-content">{{ Auth::user()->email }}</div>
                                    </div>
                                    <div class="info">
                                        <div class="info-label">{{ trans('customer.phone') }}</div>
                                        <div class="info-content">{{ Auth::user()->phone }}</div>
                                    </div>
                                    <div class="info">
                                        <div class="info-label">{{ trans('customer.address') }}</div>
                                        <div class="info-content">{{ Auth::user()->address }}</div>
                                    </div>
                                </div>
                                <div class="action-edit">
                                    <a href="{{ route('home.edit_user') }}" class="btn btn-default" title="{{ trans('customer.change_infomation') }}">{{ trans('customer.change_infomation') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="online_support">
                        <h2 class="title">{{ trans('customer.ready') }}<br>{{ trans('customer.help_you') }}</h2>
                        <img src="{{ asset(config('config.support_online')) }}">
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
    </section>
</div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/customer/pages/search.css') }}">
@endsection
@section('js')
    <script src="{{ asset('js/customer/pages/search_page.js') }}"></script>
@endsection
