<header class="main-header">
    <a href="{{ route('home.index') }}" class="logo">
        <span class="logo-mini"><b>{{ trans('supplier.a') }}</b>{{ trans('supplier.ps') }}</span>
        <span class="logo-lg"><b>{{ trans('supplier.supplier') }}</b> {{ config('config.name') }}</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="javascript:void(0);" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">{{ trans('supplier.toggle_navigation') }}</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">{{ config('config.number') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">{{ trans('supplier.you_have_messages', ['messages' =>  config('config.number')]) }}</li>
                        <li>
                            <ul class="menu">
                            </ul>
                        </li>
                        <li class="footer"><a href="#">{{ trans('supplier.see_all_messages') }}</a></li>
                    </ul>
                </li>
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning" id="unreadnoti-counting">{{ count(Auth::user()->unreadNotifications) }}</span>
                    </a>
                    <ul class="dropdown-menu notification" id="notifications">
                        @foreach (Auth::user()->notifications as $notification)
                            @if ($notification->read_at)
                                <a href="{{ route('supplier.notifications.show', [$notification->id]) }}"
                                   class="header notification-items">
                                    <span class="thumbnail">
                                        <img src="{{ config('setting.image_folder') . $notification->data['products'][0]['product']['thumbnail'] }}" alt="">
                                    </span>
                                    <span class="info">
                                        <h5 class="notification-message">{{ $notification->data['message'] }}</h5>
                                        <h6 class="product-name">{{ $notification->data['products'][0]['product']['name'] }}</h6>
                                        <p class="address">{{ trans('sentences.to') }}: <i>{{ $notification->data['address'] }}</i></p>
                                    </span>
                                </a>
                            @else
                                <a href="{{ route('supplier.notifications.show', [$notification->id]) }}"
                                   class="header notification-items unread-notification">
                                    <span class="thumbnail">
                                        <img src="{{ config('setting.image_folder') . $notification->data['products'][0]['product']['thumbnail'] }}" alt="">
                                    </span>
                                        <span class="info">
                                        <h5 class="notification-message">{{ $notification->data['message'] }}</h5>
                                        <h6 class="product-name">{{ $notification->data['products'][0]['product']['name'] }}</h6>
                                        <p class="address"><i>{{ $notification->data['address'] }}</i></p>
                                    </span>
                                </a>
                            @endif
                        @endforeach
                    </ul>
                </li>
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-language"></i>
                        <span class="label label-warning">{{ trans('supplier.lang') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="footer"><a href="{{ route('change_language', ['en']) }}">{{ trans('supplier.english') }}</a></li>
                        <li class="footer"><a href="{{ route('change_language', ['vi']) }}">{{ trans('supplier.vietnam') }}</a></li>
                    </ul>
                </li>
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ Auth::user()->avatar }}" class="user-image" alt="{{ trans('sentences.profile_image') }}">
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header text-center"><b>{{ trans('sentences.hello') }} {{ Auth::user()->username }}</b></li>
                        <li class="footer text-center">
                            <form action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                                <button type="submit" id="logoutBtn">{{ trans('sentences.logout') }}</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
