@extends('layout.app')
@section('content')
    <div class="content center">
        <div class="col-md-3 left-panel">
            <div class="row nm menu">
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

            @if(count($friends['all']))
                <div class="row nm sections" id="friends">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            @if(isset($id))
                                <a href="/friends?id={!! $id !!}" id="my-friends">Friends
                                    ({!! count($friends['all']) !!})</a>
                            @else
                                <a href="/friends" id="my-friends">Friends ({!! count($friends['all']) !!})</a>
                            @endif
                        </div>
                        <div class="panel-body">
                            @foreach($friends['all'] as $friend)
                                <a href="/user/{!! $friend->user_id !!}">
                                    <div class="col-md-4 center friend">
                                        <img src="{!! $friend->userInfo["avatarLinkSmall"] !!}"/>
                                        <p>{!! $friend->userName !!}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-6 user-page">
            <div class="row">
                <div class="col-md-4">
                    <div class="row nm">
                        <div class="col-xs-12 photo">
                            <a id="avatar" href="{!! $userInfo['avatarLinkOriginal'] !!}" class="thumbnail">
                                <img src="{!! $userInfo['avatarLinkSmall'] !!}" alt="avatar">
                            </a>
                        </div>
                    </div>
                    <div class="row nm">
                        <div class="col-xs-12 addfriend">
                            @if(isset($id))
                                {!! csrf_field() !!}

                                @if($isfriend === 'send request')
                                    <div class="alert alert-success" role="alert">Request has sent</div>
                                @elseif($isfriend === 'get request')
                                    <button type="button" class="btn btn-primary" id="accept_request_friend"
                                            data-friend-accept="{!! $id !!}">Add to friends
                                    </button>
                                    <button type="button" class="btn btn-danger" id="reject_request_friend"
                                            data-friend-reject="{!! $id !!}">Reject
                                    </button>
                                    <div class="alert alert-info" role="alert">{!! $users[$id - 1]->name !!} has sent
                                        request to you
                                    </div>
                                @elseif($isfriend == true)
                                    <button type="button" class="btn btn-danger" id="removefriend"
                                            data-friend-remove="{!! $id !!}">Remove friend
                                    </button>
                                @else
                                    <button type="button" class="btn btn-primary" id="addfriend"
                                            data-friend-request="{!! $id !!}">Add to friend
                                    </button>
                                @endif

                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-8 info">
                    <div class="row nm name">
                        @if(isset($id))
                            <h3 id="name">
                                {!! $users[$id - 1]->name !!}
                            </h3>
                        @else
                            <h3 id="name">
                                {!! Auth::user()->name !!}
                            </h3>
                            (This is your page!)
                        @endif
                    </div>
                    <div class="information left">
                        <div class="row nm np">
                            <div class="col-xs-12 status center">
                                {!! $userInfo['status'] !!}
                            </div>
                        </div>
                        @if ($userInfo['gender'])
                            <div class="row nm">
                                <div class="col-xs-4 title">
                                    Gender:
                                </div>
                                <div class="col-xs-8">
                                    {!! $userInfo['gender'] !!}
                                </div>
                            </div>
                        @endif
                        @if ($userInfo['date_of_birthday'])
                            <div class="row nm">
                                <div class="col-xs-4 title">
                                    Date of birth:
                                </div>
                                <div class="col-xs-8">
                                    {!! date('d F, Y', strtotime($userInfo['date_of_birthday'])) !!}
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
            <div class="row" id="question">
                @if(isset($id))
                    {!! Form::open(['route' => ['ask_question', $id]]) !!}

                    {!! csrf_field() !!}
                    <h5>Ask your question</h5>

                    <p class="success">{!! Session::get('success') !!}</p>
                    <p class="error">{!! $errors->first('question') !!}</p>

                    {!! Form::textarea('question', null, ['class' => 'form-control']) !!}
                    <div class="row">
                        <div class="col-sm-6 left">
                            {!! Form::checkbox('anonimous', true) !!} Anonimous question
                        </div>
                        <div class="col-sm-6 right">
                            {!! Form::submit('Ask question', ['class' => 'btn btn-default']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                @else
                    @if(count($newQuestions))
                        <h5>New questions</h5>
                    @else
                        <h5>You have not new question</h5>
                    @endif

                    <p class="error">{!! $errors->first('answer') !!}</p>
                    <p class="success">{!! Session::get('success') !!}</p>

                    @foreach($newQuestions as $question)
                        {!! Form::open(['url' => 'user/answer/' . $question['id']]) !!}
                        {!! csrf_field() !!}
                        <div class="col-xs-6">
                            <h5 class="left">{!! $question['question'] !!} <span class="label label-default">New</span>
                            </h5>
                        </div>
                        <div class="col-xs-6 right">
                            @if ($question['anonimous'])
                                from: Anonimous
                            @else
                                from:
                                <a href="/user/{!! $users[$question['question_man'] - 1]->id !!}">
                                {!! $users[$question['question_man'] - 1]->name !!}
                                </a>
                            @endif
                        </div>

                        {!! Form::textarea('answer', null, ['class' => 'form-control']) !!}
                        <div class="row">
                            <div class="col-md-12 right">
                                {!! Form::submit('Answer this question', ['class' => 'btn btn-default']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    @endforeach
                @endif
            </div>
            @if(count($Questions))
                <h4>User questions</h4>
            @else
                <h5>User has not yet answered the questions </h5>
            @endif

            <div class="row nm left">
                @foreach($Questions as $question)
                    <div class="panel panel-info answer">
                        <div class="panel-heading">
                            <div class="row nm">
                                <div class="col-md-8 np">
                                    {!! $question['question'] !!}
                                </div>
                                <div class="col-md-4 np right">
                                    @if ($question['anonimous'])
                                        from: Anonimous
                                    @else
                                        from:
                                        <a href="/user/{!! $users[$question['question_man'] - 1]->id !!}">
                                        {!! $users[$question['question_man'] - 1]->name !!}
                                        </a>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="panel-body">
                            {!! $question['answer'] !!}
                        </div>
                    </div>
                @endforeach

                <div class="row nm center">
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-default" id="show_more">Show more</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
