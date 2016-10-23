@extends('layout.app')
@section('content')
    <div class="overlay">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
    <div class="row nm">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                {!! csrf_field() !!}
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#friends" data-toggle="tab">Friends <span class="pull-right badge bg-aqua">{!! count($friends['all']) !!}</span></a></li>
                    @if (!$owner)
                        <li><a href="#mutual" data-toggle="tab">mutual friends <span class="pull-right badge bg-aqua">{!! count($friends['mutual']) !!}</span></a></li>
                    @else
                        <li><a href="#requests" data-toggle="tab">Requests to friends <span class="pull-right badge bg-aqua">{!! count($friends['requests']) !!}</span></a></li>
                    @endif
                </ul>

                <div class="tab-content">
                    <div class="active tab-pane" id="friends">
                        <div class="row nm">
                            @foreach($friends['all'] as $friend)
                                <div class="col-md-3">
                                    <!-- Widget: user widget style 1 -->
                                    <div class="box box-widget widget-user-2">
                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                        <a href="/user/{!! $friend->userInfo['id'] !!}">
                                            @if ($friend->userInfo['gender'] == 'male')
                                                <div class="widget-user-header bg-aqua">
                                            @elseif ($friend->userInfo['gender'] == 'female')
                                                <div class="widget-user-header bg-fuchsia">
                                            @else
                                                <div class="widget-user-header bg-yellow">
                                            @endif
                                                <div class="widget-user-image">
                                                    <img class="img-circle" src="{!! $friend->userInfo['avatarLinkSmall'] !!}" alt="User Avatar">
                                                </div>
                                                <!-- /.widget-user-image -->
                                                <h3 class="widget-user-username">{!! $friend->userInfo['name'] !!}</h3>
                                                <h5 class="widget-user-desc">{!! $friend->userInfo['status'] !!}</h5>
                                            </div>
                                        </a>
                                        <div class="box-footer no-padding">
                                            <ul class="nav nav-stacked">
                                                <li><a href="/user/{!! $friend->userInfo['id'] !!}">Test information</a></li>
                                                @if ($owner)
                                                    <a href="http://dev/friends/remove_friend" class="ajax-friends-list btn btn-danger btn-block" data-friend="{!! $friend->userInfo['id'] !!}">
                                                        <b>Remove from friends</b>
                                                    </a>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- /.widget-user -->
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @if ($owner)
                        <div class="tab-pane" id="requests">
                            <div class="row nm">
                                @foreach($friends['requests'] as $friend)
                                    <div class="col-md-3">
                                        <!-- Widget: user widget style 1 -->
                                        <div class="box box-widget widget-user-2">
                                            <!-- Add the bg color to the header using any of the bg-* classes -->
                                            <a href="/user/{!! $friend->userInfo['id'] !!}">
                                                @if ($friend->userInfo['gender'] == 'male')
                                                    <div class="widget-user-header bg-aqua">
                                                @elseif ($friend->userInfo['gender'] == 'female')
                                                    <div class="widget-user-header bg-fuchsia">
                                                @else
                                                    <div class="widget-user-header bg-yellow">
                                                @endif
                                                    <div class="widget-user-image">
                                                        <img class="img-circle" src="{!! $friend->userInfo['avatarLinkSmall'] !!}" alt="User Avatar">
                                                    </div>
                                                    <!-- /.widget-user-image -->
                                                    <h3 class="widget-user-username">{!! $friend->userInfo['name'] !!}</h3>
                                                    <h5 class="widget-user-desc">{!! $friend->userInfo['status'] !!}</h5>
                                                </div>
                                            </a>
                                            <div class="box-footer no-padding">
                                                <ul class="nav nav-stacked">
                                                    <li><a href="/user/{!! $friend->userInfo['id'] !!}">Test information</a></li>
                                                    <a href="{!! route('accept_request_friend') !!}" class="ajax-friends-list btn btn-primary btn-block" data-friend="{!! $friend->userInfo['id'] !!}">
                                                        <b>Add to friends</b>
                                                    </a>
                                                    <a href="http://dev/friends/remove_friend" class="ajax-friends-list btn btn-danger btn-block" data-friend="{!! $friend->userInfo['id'] !!}">
                                                        <b>Reject</b>
                                                    </a>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- /.widget-user -->
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if(!$owner)
                        <div class="tab-pane" id="mutual">
                            <div class="row nm">
                                @foreach($friends['mutual'] as $friend)
                                    <div class="col-md-3">
                                        <!-- Widget: user widget style 1 -->
                                        <div class="box box-widget widget-user-2">
                                            <!-- Add the bg color to the header using any of the bg-* classes -->
                                            <a href="/user/{!! $friend->userInfo['id'] !!}">
                                                @if ($friend->userInfo['gender'] == 'male')
                                                    <div class="widget-user-header bg-aqua">
                                                @elseif ($friend->userInfo['gender'] == 'female')
                                                    <div class="widget-user-header bg-fuchsia">
                                                @else
                                                    <div class="widget-user-header bg-yellow">
                                                @endif
                                                <div class="widget-user-image">
                                                    <img class="img-circle" src="{!! $friend->userInfo['avatarLinkSmall'] !!}" alt="User Avatar">
                                                </div>
                                                    <!-- /.widget-user-image -->
                                                    <h3 class="widget-user-username">{!! $friend->userInfo['name'] !!}</h3>
                                                    <h5 class="widget-user-desc">{!! $friend->userInfo['status'] !!}</h5>
                                                </div>
                                            </a>
                                            <div class="box-footer no-padding">
                                                <ul class="nav nav-stacked">
                                                    <li><a href="/user/{!! $friend->userInfo['id'] !!}">Test information</a></li>
                                                    @if ($owner)
                                                        <a href="http://dev/friends/remove_friend" class="ajax-friends-list btn btn-danger btn-block" data-friend="{!! $friend->userInfo['id'] !!}">
                                                            <b>Remove from friends</b>
                                                        </a>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- /.widget-user -->
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
