<div class="support-notification mini-cart">
    <a class="btn-support-cart" href="">
        <span class="fa fa-bell"></span>notification
        <span class="num">{{ count($notifications) }}</span>
    </a>
    <div class="top-cart-content noti ">
        <ul id="cart-sidebar" class="mini-products-list count_li">
            <div class="container mt-5">
                <div class="title">
                    @if (count($notifications) != config('config.number'))
                        <h3>{{ trans('customer.notification') }}</h3>
                    @else
                        <h3>{{ trans('customer.no_notification') }}</h3>
                    @endif
                </div>
            </div>
            @foreach ($notifications as $notification)
                <div class="alert alert-{{ $notification->data['class'] }}">
                    <div class="container">
                        <div class="alert-icon">
                            <i class="material-icons">{{ $notification->data['icon'] }}</i>
                            <b class="b">{{ $notification->data['created_at'] }}</b>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" data-url="{{ route('home.notification', $notification->id) }}">
                        <span aria-hidden="true"><i class="material-icons">clear</i></span>
                        </button>
                        <b>{{ $notification->data['status'] }}</b> {{ $notification->data['message'] }}
                    </div>
                </div>
            @endforeach
        </ul>
    </div>
</div>
<div id="menu-overlay"></div>

<script src="{{ asset('bower_components/bootstrap-theme-js/index.js') }}" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-material-design.min/index.css') }}" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/demo-bower/font.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/customer/pages/notification.css') }}">
