<header class="main-header">
    <a href="{{ route('supplier.dashboard') }}" class="logo">
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
                        <span class="label label-warning">{{ config('config.number') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">{{ trans('supplier.you_have_notifications', ['notifications' => config('config.number')]) }}</li>
                        <li>
                            <ul class="menu">
                            </ul>
                        </li>
                        <li class="footer"><a href="#">{{ trans('supplier.view_all') }}</a></li>
                    </ul>
                </li>
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-language"></i>
                        <span class="label label-warning">{{ trans('supplier.lang') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="footer"><a href="{{ route('change_language', ['en']) }}">{{ trans('supplier.english') }}</a></li>
                        <li class="footer"><a href="{{ route('change_language', ['vi']) }}">{{ trans('supplier.vietnam') }}</a></li>
                    </ul>
                </li>
                <!-- User Account Menu -->
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ config('setting.image_folder').Auth::user()->avatar }}" class="user-image" alt="{{ trans('sentences.profile_image') }}">
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
