@extends('layout.app')
@section('content')
    <div class="overlay">
        <i class="fa fa-refresh fa-spin"></i>
    </div>

    <div class="row nm">
        <div class="col-md-12">
            @if ($owner)
                <h3><a href="user/{!! $authUserInfo['id'] !!}">{!! $authUserInfo['name'] !!} {!! $authUserInfo['second_name'] !!}</a> friends</h3>
            @else
                <h3><a href="user/{!! $userInfo['id'] !!}">{!! $userInfo['name'] !!} {!! $userInfo['second_name'] !!}</a> friends</h3>
            @endif
        </div>
    </div>

    <div class="row nm" id="friends-block">
        <div class="col-md-12" id="friends-block-inner">
            <div class="nav-tabs-custom">
                {!! csrf_field() !!}
                <input type="hidden" name="url" id="url" value="{!! route('user_friends_ajax') !!}" />
                @if ($owner)
                    <input type="hidden" name="id_owner" id="idOwner" value="{!! $authUserInfo['id'] !!}" />
                @else
                    <input type="hidden" name="id_owner" id="idOwner" value="{!! $authUserInfo['id'] !!}" />
                    <input type="hidden" name="id_owner" id="idUser" value="{!! $userInfo['id'] !!}" />
                @endif

                <ul class="nav nav-tabs">
                    <li class="active"><a href="#friends" data-toggle="tab">Friends <span class="pull-right badge bg-aqua">{!! $friendsCount['all'] !!}</span></a></li>
                    @if (!$owner)
                        <li><a href="#mutual" data-toggle="tab">Mutual friends <span class="pull-right badge bg-aqua">{!! $friendsCount['mutual'] !!}</span></a></li>
                    @else
                        <li><a href="#requests" data-toggle="tab">Requests to friends <span class="pull-right badge bg-aqua">{!! $friendsCount['request'] !!}</span></a></li>
                    @endif
                </ul>

                <div class="tab-content">
                    <div class="active tab-pane" id="friends">
                        <div class="row nm filter-block">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" id="name" name="q" value="">
                                </div>
                            </div>
                            <div class="col-md-3 col-md-offset-3">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select id="gender" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                        <option value="" selected="selected">Any</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row nm">
                            <input type="hidden" name="scope" id="scope" value="general" />
                            <div id="all-friends">
                            </div>
                        </div>
                        <button type="button" class="btn btn-block btn-info" id="showMoreFriends">Show more friends</button>
                    </div>
                    @if ($owner)
                        <div class="tab-pane" id="requests">
                            <div class="row nm filter-block">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select id="gender" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option value="" selected="selected">Any</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row nm">
                                <input type="hidden" name="scope" id="scope" value="requests" />
                                <div id="requests-friends">
                                </div>
                            </div>
                            <button type="button" class="btn btn-block btn-info" id="showMoreRequests">Show more friends</button>
                        </div>
                    @endif
                    @if(!$owner)
                        <div class="tab-pane" id="mutual">
                            <div class="row nm filter-block">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select id="gender" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option value="" selected="selected">Any</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row nm">
                                <input type="hidden" name="scope" id="scope" value="mutial" />
                                <div id="mutual-friends">
                                </div>
                            </div>
                            <button type="button" class="btn btn-block btn-info" id="showMoreMutualFriends">Show more friends</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script src="{{ asset('assets/dist/js/people.js') }}"></script>
@stop