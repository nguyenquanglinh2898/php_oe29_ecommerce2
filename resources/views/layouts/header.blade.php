<header id="header" class="header">
    <div class="container">
        <div class="row display-flex">
            <div class="col-md-2 margin-auto trigger-menu">
                <button type="button" class="navbar-toggle collapsed visible-xs" id="trigger-mobile">
                <span class="sr-only">{{ trans('toggle_navigation') }}</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <div class="logo">
                    <a class="logo-wrapper" href="{{ route('home.index') }}" ><img src="{{ asset(config('setting.logo')) }}" alt="{{ config('config.name') }}"></a>
                </div>
            </div>
            <div class="col-md-3 margin-auto">
                <div class="search">
                    <form class="search-bar" action="{{ route('home.search_detail') }}" method="POST" accept-charset="utf-8">
                        @csrf
                        <input class="input-search" id="search-box" type="search"  placeholder="{{ trans('customer.search') }}" data-url="{{ route('home.search') }}" name="name" autocomplete="off">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>

                </div>
                <div class="search-data"></div>
            </div>
            <div class="col-md-7 hd-bg-white main-menu-responsive">
                <div class="main-menu">
                    <div class="nav">
                        <ul>
                            <li class="nav-item "><a href="{{ route('home.index') }}" ><span class="fas fa-home"></span>{{ trans('customer.home') }}</a></li>
                            <li class="nav-item"><a href=""><span class="fas fa-info"></span>{{ trans('customer.about') }}</a></li>
                            <li class="nav-item dropdown ">
                                <a href="#"><span class="fas fa-tshirt"></span>{{ trans('sentences.category') }}</a>
                                <div class="dropdown-menu">
                                    <ul class="dropdown-menu-item">
                                        <li>
                                            <h4>{{ trans('customer.category') }}</h4>
                                            <ul class="dropdown-menu-subitem">
                                                @foreach ($categories as $category)
                                                    <div class="col-sm-6">
                                                        <li>
                                                            <a href="{{ route('home.category', $category->id) }}" title="{{ $category->name }}">{{ $category->name }}</a>
                                                        </li>
                                                    </div>
                                                @endforeach
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item"><a href=""><span class="far fa-newspaper"></span>{{ trans('customer.voucher') }}</a></li>
                            <li class="nav-item "><a href=""><span class="fas fa-id-card"></span>{{ trans('customer.contact') }}</a></li>
                            @if (Auth::check() && Auth::user()->role_id == config('config.role_user'))
                                <li class="nav-item">@include('layouts.notification')</li>
                            @endif
                        </ul>
                    </div>
                    <div class="accout-menu">
                        @if (Auth::guest())
                            <div class="not-logged-menu">
                                <ul>
                                    <li class="menu-item ">
                                        <a href="{{ route('login') }}" >
                                            <span class="fas fa-user"></span>{{ trans('customer.login') }}
                                        </a>
                                    </li>
                                    <li class="menu-item ">
                                        <a href="{{ route('register') }}">
                                            <span class="fas fa-key"></span>{{ trans('customer.register') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <div class="logged-menu">
                                <ul>
                                    <li class="menu-item dropdown ">
                                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" title="{{ Auth::user()->name }}">
                                            <div class="avatar" >
                                                <img src="{{ asset(Auth::user()->avatar) }}" class="img-responsive img-circle avatar">
                                            </div>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @if (Auth::user()->role_id == config('config.role_admin'))
                                                <li>
                                                    <a href="{{ route('admin.products.index') }}"><i class="fas fa-tachometer-alt"></i> {{ trans('customer.manage_website') }}
                                                    </a>
                                                </li>
                                            @elseif (Auth::user()->role_id == config('setting.supplier_id'))
                                                <li>
                                                    <a href="{{ route('supplier.products.index') }}"><i class="fas fa-tachometer-alt"></i> {{ trans('customer.manage_website') }}
                                                    </a>
                                                </li>
                                            @else
                                                <li class="">
                                                    <a href="{{ route('home.order') }}"><i class="fas fa-clipboard-list"></i> {{ trans('customer.manage_order') }}
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="{{ route('home.user') }}"><i class="fas fa-user-cog"></i> {{ trans('customer.manage_account') }}
                                                    </a>
                                                </li>
                                            @endif
                                            <li>
                                                <a href="#">
                                                    <form action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                        <button type="submit" id="logoutBtn">
                                                            <i class="fas fa-power-off"></i>
                                                            {{ trans('sentences.logout') }}
                                                        </button>
                                                    </form>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
