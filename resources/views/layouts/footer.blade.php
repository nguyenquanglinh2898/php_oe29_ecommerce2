<footer class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-4 col-xs-6 col-ssm">
                    <div class="footer-widget">
                        <div class="widget-title">
                            <h3>{{ trans('customer.about') }}</h3>
                        </div>
                        <div class="widget-content">
                            <p><b><i class="fas fa-mobile-alt"></i> {{ trans('customer.hotline') }}:</b><a href="">{{ config('config.phone') }}</a></p>
                            <p><b><i class="fas fa-envelope"></i> {{ trans('customer.email') }}:</b><a href="" rel="nofollow">{{ config('config.email') }}</a></p>
                            <p><b><i class="fas fa-store-alt"></i> {{ trans('customer.address') }}:</b> {{ config('config.address_detail') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 hidden-sm hidden-xs">
                    <div class="footer-widget">
                        <div class="widget-title">
                            <h3>{{ trans('customer.support') }}</h3>
                        </div>
                        <div class="widget-content">
                            <ul>
                                <li><a href="#" >{{ trans('customer.administrative_policy') }}</a></li>
                                <li><a href="#" >{{ trans('customer.shipping_policy') }}</a></li>
                                <li><a href="#" >{{ trans('customer.return_policy') }}</a></li>
                                <li><a href="#" >{{ trans('customer.payment_guide') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6 col-ssm">
                    <div class="footer-widget">
                        <div class="widget-title">
                            <h3>{{ trans('customer.payment') }}</h3>
                        </div>
                        <div class="widget-content">
                            <ul>
                                <li class="clearfix">
                                    <div class="col-md-3 col-sm-3 col-xs-3 padding-lr5" >
                                        <div class="payment visa">
                                            <img src="{{ asset(config('setting.visa')) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3 padding-lr5" >
                                        <div class="payment">
                                            <img src="{{ asset(config('setting.mastercard')) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3 padding-lr5" >
                                        <div class="payment">
                                            <img src="{{ asset(config('setting.jcb')) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3 padding-lr5" >
                                        <div class="payment">
                                            <img src="{{ asset(config('setting.cod')) }}">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 hidden-xs">
                    <div class="footer-widget">
                        <div class="widget-title">
                            <h3>{{ trans('customer.follow_us') }}</h3>
                        </div>
                        <div class="widget-content">
                            <ul class="social-media">
                                <li>
                                    <a href="{{ config('setting.facebook_link') }}">
                                        <img src="{{ asset(config('setting.facebook_logo')) }}">
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ config('setting.youtube_link') }}">
                                        <img src="{{ asset(config('setting.youtube_logo')) }}">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
