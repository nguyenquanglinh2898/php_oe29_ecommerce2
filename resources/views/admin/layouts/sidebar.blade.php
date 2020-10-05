<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src=""<!-- user profile image url --> class="img-circle" alt="">
            </div>
            <div class="pull-left info">
                <p><!-- username --></p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('sentences.online') }}</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form" id="sidebar-search-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('sentences.search') }}...">
                <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
          </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class=""><a href=""><i class="fa fa-dashboard"></i> <span>{{ trans('sentences.dashboard') }}</span></a></li>
            <li class=""><a href=""><i class="fa fa-sliders" aria-hidden="true"></i> <span>{{ trans('sentences.manage_advertises')  }}</span></a></li>
            <li class=""><a href=""><i class="fa fa-users"></i> <span>{{ trans('sentences.manage_accounts') }}</span></a></li>
            <li class=""><a href=""><i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>{{ trans('sentences.manage_posts') }}</span></a></li>
            <li class=""><a href=""><i class="fa fa-product-hunt" aria-hidden="true"></i> <span>{{ trans('sentences.manage_products') }}</span></a></li>
            <li class=""><a href=""><i class="fa fa-list-alt" aria-hidden="true"></i> <span>{{ trans('sentences.manage_suppliers') }}</span></a></li>
            <li class=""><a href=""><i class="fa fa-line-chart" aria-hidden="true"></i> <span>{{ trans('sentences.revenue_statistic') }}</span></a></li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
