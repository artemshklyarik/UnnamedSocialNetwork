@extends('layout.app')
@section('content')
    <div class="content center">
        <div class="col-md-3 left-panel">
            <p>
                <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                <a href="/" id="my-page">My page
                    @if(count($newQuestions))
                        <span class="badge">{!! count($newQuestions) !!}</span>
                    @endif
                </a>
                <a href="/edit_profile" id="edit-profile">edit profile</a>
            </p>
            <p>
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                <a href="/friends" id="my-friends">My friends

                    @if(isset($friends['requests']) && count($friends['requests']))
                        <span class="badge">{!! count($friends['requests']) !!}</span>
                    @endif
                </a>
            </p>
        </div>

        <div class="col-md-9 friends-list left">
            @if(count($friends["requests"]))
                <h5>New requests</h5>
                <div class="row nm requests">
                    <div class="col-xs-12 np">
                        @foreach($friends["requests"] as $friend)
                            <div class="row nm friend">
                                <div class="col-md-2 photo np">
                                    <a href="user/{!! $friend->user_id !!}" class="thumbnail">
                                        <img src="{!! $friend->userInfo["avatarLinkSmall"] !!}"/>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-offset-1 ">
                                    <div class="row nm">
                                        <a href="user/{!! $friend->user_id !!}">
                                            <h4>{!! $friend->userName !!}</h4>
                                        </a>
                                    </div>
                                    <div class="row nm">
                                        @if($owner)
                                            {!! csrf_field() !!}
                                            <button type="button" class="btn btn-primary" id="accept_request_friend"
                                                    data-friend-accept="{!! $friend->user_id !!}">Add to friends
                                            </button>
                                            <button type="button" class="btn btn-danger" id="reject_request_friend"
                                                    data-friend-reject="{!! $friend->user_id !!}">Reject
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(count($friends["all"]))
                <h5>Friends</h5>
                <div class="row nm friends">
                    <div class="col-xs-12">
                        @foreach($friends["all"] as $friend)
                            <div class="row nm friend">
                                <div class="col-md-2 photo np">
                                    <a href="user/{!! $friend->user_id !!}" class="thumbnail">
                                        <img src="{!! $friend->userInfo["avatarLinkSmall"] !!}"/>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-offset-1 ">
                                    <div class="row nm">
                                        <a href="user/{!! $friend->user_id !!}">
                                            <h4>{!! $friend->userName !!}</h4>
                                        </a>
                                    </div>
                                    <div class="row nm">
                                        @if($owner)
                                            {!! csrf_field() !!}
                                            <button type="button" class="btn btn-danger" id="removefriend"
                                                    data-friend-remove="{!! $friend->user_id !!}">Remove friend
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <h5>You haven't friends</h5>
            @endif
        </div>
    </div>
@endsection
