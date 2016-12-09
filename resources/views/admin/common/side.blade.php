<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li><a href="{{ route('admin.game.index') }}"><i class="fa fa-gamepad"></i> <span>Games</span></a></li>
            <li><a href="{{ route('admin.game.create') }}"><i class="fa fa-plus"></i> <span>Thêm game</span></a></li>
            <li><a href="{{ route('admin.gametype.index') }}"><i class="fa fa-list"></i> <span>Games Types</span></a></li>
            <li><a href="{{ route('admin.gametag.index') }}"><i class="fa fa-tags"></i> <span>Games Tags</span></a></li>
            <li><a href="{{ route('admin.page.index') }}"><i class="fa fa-list"></i> <span>Pages</span></a></li>
            <li><a href="{{ route('admin.ad.index') }}"><i class="fa fa-picture-o"></i> <span>Ads</span></a></li>
            <li><a href="{{ route('admin.contact.index') }}"><i class="fa fa-list"></i> <span>Contacts</span></a></li>
            <li class="header">CONFIG</li>
            <li><a href="{{ route('admin.menu.index') }}"><i class="fa fa-list"></i> <span>Menus</span></a></li>
            <li><a href="{{ route('admin.config.edit', 1) }}"><i class="fa fa-cogs"></i> <span>SEO meta</span></a></li>
            <li><a href="{{ route('admin.account.index') }}"><i class="fa fa-users"></i> <span>Accounts</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>