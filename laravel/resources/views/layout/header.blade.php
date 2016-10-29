<header class="main-header">
    <a href="/" class="logo">
        <!-- LOGO -->
        USNetwork
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        @if (Auth::check())
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        <!-- Navbar Right Menu -->

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{!! $authUserInfo['avatarLinkSmall'] !!}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{!! $authUserInfo['name'] !!} {!! $authUserInfo['second_name'] !!}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{!! $authUserInfo['avatarLinkSmall'] !!}" class="img-circle" alt="User Image">
                                <p>
                                    {!! $authUserInfo['name'] !!} {!! $authUserInfo['second_name'] !!}
                                    <small>{!! $authUserInfo['date_of_birthday'] !!}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{!! route('edit_profile') !!}" class="btn btn-default btn-flat">Edit profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{route('logout')}}" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        @endif
    </nav>
</header>