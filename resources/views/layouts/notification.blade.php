<div class="support-notification mini-cart">
    <a class="btn-support-cart" href="">
        <span class="fa fa-bell"><span class="num">{{ count($notifications) }}</span></span>{{ trans('customer.notification') }}
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
                    <div class="">
                        <div class="alert-icon">
                            <i class="material-icons">{{ $notification->data['icon'] }}</i>
                            <b class="b">{{ $notification->data['created_at'] }}</b>
                            <i class="fas fa-times close" data-url="{{ route('home.notification', $notification->id) }}" data-dismiss="alert" aria-label="Close" ></i>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" data-url="{{ route('home.notification', $notification->id) }}">
                            <span aria-hidden="true"><i class="fa fa-remove"></i></span>
                        </button>
                        @if ($notification->data['order_id'] == null)
                            <a href="{{ route('home.order') }}" class="link-notification" ><b>{{ $notification->data['status'] }}</b> {{ $notification->data['message'] }} </a>
                        @else
                            <a href="{{ route('home.order_detail', $notification->data['order_id']) }}" class="link-notification" ><b>{{ $notification->data['status'] }}</b> {{ $notification->data['message'] }} </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </ul>
    </div>
</div>
<div id="menu-overlay"></div>
<script src="{{ asset('bower_components/bootstrap-theme-js/index.js') }}" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/demo-bower/font.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/customer/pages/notification.css') }}">
