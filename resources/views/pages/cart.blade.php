@extends('layouts.master')
@section('title', trans('customer.cart'))
@section('content')
<section class="bread-crumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">{{ trans('customer.home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ trans('customer.cart') }}</li>
        </ol>
    </nav>
</section>
<div class="site-cart">
    <section class="section-cart">
        @include('layouts.cart_detail')
    </section>
</div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/customer/pages/cart.css') }}">
@endsection
@section('js')
    <script src="{{ asset('js/customer/pages/cart.js') }}"></script>
@endsection
