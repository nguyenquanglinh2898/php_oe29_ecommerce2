@extends('layouts.master')
@section('title', trans('customer.change_information'))
@section('content')
<section class="bread-crumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">{{ trans('customer.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('home.user') }}">{{ trans('customer.account') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ trans('customer.change_information') }}</li>
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
                <div class="col-md-9">
                    <div class="user">
                        <form class="form-user" action="{{ route('home.save_user') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <div class="row">
                                <div class="col-md-3 col-sm-4 col-xs-4">
                                    <div class="upload-avatar">
                                        <div class="avatar-preview" data-image="{{ Auth::user()->avatar }}"></div>
                                        <label for="upload" ><i class="fas fa-folder-open"></i>{{ trans('customer.upload_avatar') }}</label>
                                        <input type="file" accept="image/*" id="upload" class="input-upload" name="avatar_image">
                                    </div>
                                </div>
                                <div class="col-md-9 col-sm-8 col-xs-8">
                                    <div class="user-info">
                                        <div class="info">
                                            <div class="info-label">{{ trans('customer.name') }}</div>
                                            <div class="info-content">
                                                <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" placeholder="{{ trans('customer.name') }}" value="{{ old('name') ?: Auth::user()->name }}" required autocomplete="name" autofocus>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="info">
                                            <div class="info-label">{{ trans('customer.email') }}</div>
                                            <div class="info-content">
                                                <input type="email" name="email" placeholder="Email" value="{{ Auth::user()->email }}" disabled="true">
                                            </div>
                                        </div>
                                        <div class="info">
                                            <div class="info-label">{{ trans('customer.phone') }}</div>
                                            <div class="info-content">
                                                <input id="phone" type="tel" class="@error('phone') is-invalid @enderror" name="phone" placeholder="{{ trans('customer.phone') }}" value="{{ old('phone') ?: Auth::user()->phone }}" required autocomplete="phone">
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="info">
                                            <div class="info-label">{{ trans('customer.address') }}</div>
                                            <div class="info-content">
                                                <textarea name="address" class="@error('address') is-invalid @enderror" rows="3" required>{{ old('address') ?: Auth::user()->address }}</textarea>
                                                @error('address')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="action-edit">
                                        <button type="submit" class="btn btn-default" title="{{ trans('customer.save_change') }}">{{ trans('customer.save_change') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-3">
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
    <script src="{{ asset('js/customer/pages/user.js') }}"></script>
@endsection
