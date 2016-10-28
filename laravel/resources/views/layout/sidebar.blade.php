<div class="main-sidebar">
    <!-- Inner sidebar -->
    <div class="sidebar">
        <!-- user panel (Optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{!! $authUserInfo['avatarLinkSmall'] !!}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{!! $authUserInfo['name'] !!} {!! $authUserInfo['second_name'] !!}</p>
            </div>
        </div><!-- /.user-panel -->

        <!-- Search Form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
            </div>
        </form><!-- /.sidebar-form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">MENU</li>
            <!-- Optionally, you can add icons to the links -->
            <li>
                <a href="{{route('main')}}">
                    <span>My page</span>
                </a>
            </li>

            <li>
                <a href="{{route('user_friends')}}">
                    <span>Friends</span>
                    <span class="pull-right-container">
                        @if(isset($friends['requests']))
                            <small class="label pull-right bg-yellow">{!! count($friends['requests']) !!}</small>
                        @endif
                    </span>
                </a>
            </li>
        </ul><!-- /.sidebar-menu -->

    </div><!-- /.sidebar -->
</div><!-- /.main-sidebar -->