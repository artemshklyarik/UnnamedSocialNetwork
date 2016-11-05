<div class="main-sidebar">
    <!-- Inner sidebar -->
    <div class="sidebar">
        <!-- user panel (Optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <div id="sidebar-thumbnail" >
                    <img alt="thumbnail" src="{!! $authUserInfo['avatarLinkSmall'] !!}"/>
                    <input type="hidden" id="sizeX" name="sizeX" value="{!! $authUserInfo['thumbnail']['sizeX'] !!}"/>
                    <input type="hidden" id="sizeY" name="sizeY" value="{!! $authUserInfo['thumbnail']['sizeY'] !!}"/>
                    <input type="hidden" id="offsetX" name="offsetX" value="{!! $authUserInfo['thumbnail']['offsetX'] !!}"/>
                    <input type="hidden" id="offsetY" name="offsetY" value="{!! $authUserInfo['thumbnail']['offsetY'] !!}"/>
                </div>
            </div>
            <div class="pull-left info">
                <p>{!! $authUserInfo['name'] !!} {!! $authUserInfo['second_name'] !!}</p>
            </div>
        </div><!-- /.user-panel -->

        <!-- Search Form (Optional) -->
        <form action="{!! route('search_people') !!}" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
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

            <li id="friends-sidebar">
                <a href="{{route('user_friends')}}">
                    <span>Friends</span>
                    <span class="pull-right-container">
                        @if(isset($friendsCount['request']))
                            <small class="label pull-right bg-yellow">{!! $friendsCount['request'] !!}</small>
                        @endif
                    </span>
                </a>
            </li>
        </ul><!-- /.sidebar-menu -->

    </div><!-- /.sidebar -->
</div><!-- /.main-sidebar -->