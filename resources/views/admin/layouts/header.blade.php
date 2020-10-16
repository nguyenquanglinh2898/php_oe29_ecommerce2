<header class="main-header">

    <!-- Logo -->
    <a href="{{ route('admin.dashboard') }}" class="logo">
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>{{ trans('sentences.admin') }}</b> {{ config('app.name') }}</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Notifications Menu -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning"><!-- Total notification number --></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <ul class="menu">
                                <!-- notification -->
                            </ul>
                        </li>
                        <li class="footer"><a href="#">{{ trans('sentences.view_all') }}</a></li>
                    </ul>
                </li>
                <!-- Reports Menu -->
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-info"><!-- Total reports number --></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <ul class="menu">
                                <!-- task item -->
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#">{{ trans('sentences.view_all') }}</a>
                        </li>
                    </ul>
                </li>
                <!-- Language Menu -->
                <li class="dropdown tasks-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-language"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="footer">
                            <a href="{{ route('change_language', ['en']) }}">{{ trans('sentences.english') }}</a>
                            <a href="{{ route('change_language', ['vi']) }}">{{ trans('sentences.vietnamese') }}</a>
                        </li>
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
    <!-- end header -->
</header>
