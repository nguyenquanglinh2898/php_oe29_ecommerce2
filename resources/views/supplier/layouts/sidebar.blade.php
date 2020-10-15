<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ config('setting.image_folder').Auth::user()->avatar }}" class="img-circle" alt="">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->username }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('supplier.online') }}</a>
            </div>
        </div>
        <form action="#" method="get" class="sidebar-form" id="sidebar-search-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('supplier.search') }}">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">{{ trans('supplier.main_navigation') }}</li>
            <li class="active"><a href=""><i class="fa fa-dashboard"></i> <span>{{ trans('supplier.dashboard') }}</span></a></li>
            <li class=""><a href=""><i class="fa fa-sliders" aria-hidden="true"></i> <span>{{ trans('supplier.manage_slide') }}</span></a></li>
            <li class=""><a href=""><i class="fa fa-users"></i> <span>{{ trans('supplier.manage_account') }}</span></a></li>
            <li class=""><a href=""><i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>{{ trans('supplier.manager_voucher') }}</span></a></li>
            <li class=""><a href=""><i class="fa fa-list-alt" aria-hidden="true"></i> <span>{{ trans('supplier.manage_category') }}</span></a></li>
            <li class=""><a href=""><i class="fa fa-product-hunt" aria-hidden="true"></i> <span>{{ trans('supplier.manage_product') }}</span></a></li>
            <li class=""><a href=""><i class="fa fa-list-alt" aria-hidden="true"></i> <span>{{ trans('supplier.manage_order') }}</span></a></li>
            <li class=""><a href=""><i class="fa fa-line-chart" aria-hidden="true"></i> <span>{{ trans('revenue_statistics') }}</span></a></li>
        </ul>
    </section>
</aside>
