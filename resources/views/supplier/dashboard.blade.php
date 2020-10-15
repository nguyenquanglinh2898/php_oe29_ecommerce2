@extends('supplier.layouts.master')

@section('title')
    {{ trans('sentences.dashboard') }}
@endsection

@section('embed-css')
    <!-- embed-css -->
@endsection

@section('custom-css')
    <!-- custom-css -->
@endsection

@section('breadcrumb')
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- content -->
@endsection

@section('embed-js')
    @include('sweetalert::alert')
@endsection

@section('custom-js')
    <!-- custom-js -->
@endsection
