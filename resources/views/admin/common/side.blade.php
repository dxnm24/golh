<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li><a href="{{ route('admin.game.index') }}"><i class="fa fa-gamepad"></i> <span>Danh sách Games</span></a></li>
            <li><a href="{{ route('admin.game.create') }}"><i class="fa fa-plus"></i> <span>Thêm game</span></a></li>
            <li><a href="{{ route('admin.gametype.index') }}"><i class="fa fa-list"></i> <span>Danh sách thể loại games</span></a></li>
            <li><a href="{{ route('admin.gametype.create') }}"><i class="fa fa-plus"></i> <span>Thêm thể loại games</span></a></li>
            <li><a href="{{ route('admin.gametag.index') }}"><i class="fa fa-tags"></i> <span>Danh sách tags games</span></a></li>
            <li><a href="{{ route('admin.gametag.create') }}"><i class="fa fa-plus"></i> <span>Thêm tags games</span></a></li>
            <li><a href="{{ route('admin.ad.index') }}"><i class="fa fa-picture-o"></i> <span>Danh sách quảng cáo</span></a></li>
            <li><a href="{{ route('admin.ad.create') }}"><i class="fa fa-plus"></i> <span>Thêm quảng cáo</span></a></li>
            <li class="header">CONFIG</li>
            <li><a href="{{ route('admin.menu.index') }}"><i class="fa fa-list"></i> <span>Quản lý menu</span></a></li>
            <li><a href="{{ route('admin.config.edit', 1) }}"><i class="fa fa-list"></i> <span>SEO meta</span></a></li>
            <li><a href="{{ route('admin.account.index') }}"><i class="fa fa-users"></i> <span>Quản lý tài khoản</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>