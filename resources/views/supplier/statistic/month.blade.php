@extends('supplier.layouts.master')

@section('title')
    {{ trans('sentences.monthly_revenue_statistics') }}
@endsection

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/supplier/statistic/month.css') }}">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('supplier.dashboard') }}">
                <i class="fa fa-dashboard"></i> {{ trans('sentences.home') }}
            </a>
        </li>
        <li class="active">{{ trans('sentences.monthly_revenue_statistics') }}</li>
    </ol>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <canvas id="line-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hidden">
        <input type="text" id="revenues" value="{{ json_encode($revenues) }}">
        <input type="text" id="months" value="{{ json_encode(trans('sentences.months')) }}">
        <input type="text" id="statistic-sentence" value="{{ trans('sentences.monthly_revenue_statistics') }} ({{ config('config.full_currency_unit') }})">
    </div>
@endsection

@section('embed-js')
    <script src="{{ asset('bower_components/chart.js/dist/Chart.min.js') }}"></script>
@endsection

@section('custom-js')
    <script src="{{ asset('js/supplier/statistic/month.js') }}"></script>
@endsection
