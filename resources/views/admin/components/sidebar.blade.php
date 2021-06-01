<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ env('ADMIN_PATH_PREFIX') }}/dashboard"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-building fa-fw"></i> Schools<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ env('ADMIN_PATH_PREFIX') }}/schools">List of Schools</a>
                    </li>
                    <li>
                        <a href="{{ env('ADMIN_PATH_PREFIX') }}/school/create">+ New School</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ env('ADMIN_PATH_PREFIX') }}/users"><i class="fa fa-user fa-fw"></i> Users</a>
            </li>
        </ul>
    </div>
</div>