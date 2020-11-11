<div class ="notification">
    @foreach ($notifications as $notification)
        <a href="{{ route('comment.show', ['id' => $notification->data['comment_id'], 'productId' => $notification->data['product_id']]) }}">
            <div class="alert alert-{{ $notification->data['class'] }}">
                <div class="alert-icon">
                    <i class="material-icons">{{ $notification->data['icon'] }}</i>
                    <b class="b">{{ $notification->data['created_at'] }}</b>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" data-url="{{ route('home.notification', $notification->id) }}">
                <span aria-hidden="true"><i class="material-icons">{{ config('config.delete_icon') }}</i></span>
                </button>
                <b>{{ $notification->data['status'] }}</b> {{ $notification->data['message'] }}
            </div>
        </a>
    @endforeach
</div>

<link rel="stylesheet" href="{{ asset('bower_components/demo-bower/material.css') }}">
<link href="{{ asset('bower_components/font-awesome.min/index.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/demo-bower/material2.css') }}">
<link rel="stylesheet" src="{{ asset('bower_components/bootstrap-material-design/index.css') }}" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/supplier/notification/notification.css') }}">
