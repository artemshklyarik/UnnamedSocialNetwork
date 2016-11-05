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
                            <div id="thumbnail-header-small">
                                <img alt="thumbnail" src="{!! $authUserInfo['avatarLinkSmall'] !!}"/>
                                <input type="hidden" id="sizeX" name="sizeX" value="{!! $authUserInfo['thumbnail']['sizeX'] !!}"/>
                                <input type="hidden" id="sizeY" name="sizeY" value="{!! $authUserInfo['thumbnail']['sizeY'] !!}"/>
                                <input type="hidden" id="offsetX" name="offsetX" value="{!! $authUserInfo['thumbnail']['offsetX'] !!}"/>
                                <input type="hidden" id="offsetY" name="offsetY" value="{!! $authUserInfo['thumbnail']['offsetY'] !!}"/>
                            </div>
                            <span class="hidden-xs">{!! $authUserInfo['name'] !!} {!! $authUserInfo['second_name'] !!}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <div id="thumbnail-header-big">
                                    <img alt="thumbnail" src="{!! $authUserInfo['avatarLinkSmall'] !!}"/>
                                    <input type="hidden" id="sizeX" name="sizeX" value="{!! $authUserInfo['thumbnail']['sizeX'] !!}"/>
                                    <input type="hidden" id="sizeY" name="sizeY" value="{!! $authUserInfo['thumbnail']['sizeY'] !!}"/>
                                    <input type="hidden" id="offsetX" name="offsetX" value="{!! $authUserInfo['thumbnail']['offsetX'] !!}"/>
                                    <input type="hidden" id="offsetY" name="offsetY" value="{!! $authUserInfo['thumbnail']['offsetY'] !!}"/>
                                </div>
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