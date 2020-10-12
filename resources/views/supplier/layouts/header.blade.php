<header class="main-header">
    <a href="#" class="logo">
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
                <li class="dropdown user user-menu">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset(config('config.avatar')) }}" class="user-image" alt="User Image">
                        <span class="hidden-xs"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{{ asset(config('config.avatar')) }}" class="img-circle" alt="User Image">
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">{{ trans('supplier.profile') }}</a>
                            </div>
                            <div class="pull-right">
                                <a id="logout" href="#" class="btn btn-default btn-flat">{{ trans('supplier.sign_out') }}</a>
                            </div>
                        </li>
                        <form id="logout-form" action="" method="POST">
                            @csrf
                        </form>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
