@extends('layout.app')
@section('content')
    <div class="content center">
        <div class="col-md-4 left-panel">
            <a href="/" id="my-page">My page <span class="badge">{!! count($newQuestions) !!}</span></a>
            <a href="/edit_profile" id="edit-profile">edit profile</a>
            <h5>Users</h5>
            <ul>
                @foreach($users as $user)
                    @if($user->id != Auth::user()->id)
                        <li><a href="/user/{!! $user->id !!}">{!! $user->name !!}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="col-md-6 user-page">
            <div class="row">
                <div class="col-md-4 photo">
                    {{--{!! var_dump($userInfo) !!}--}}
                    <a id="avatar" href="{!! $userInfo['avatarLinkOriginal'] !!}">
                        <img src="{!! $userInfo['avatarLinkSmall'] !!}" alt="avatar">
                    </a>
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
                            <h5 class="left">{!! $question['question'] !!} <span class="label label-default">New</span></h5>
                        </div>
                        <div class="col-xs-6 right">
                            @if ($question['anonimous'])
                                from: Anonimous
                            @else
                                from:
                                <a href="href="/user/{!! $users[$question['question_man'] - 1]->id !!}"">
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
                    <div class="panel panel-default">
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
                                        <a href="href="/user/{!! $users[$question['question_man'] - 1]->id !!}"">
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
            </div>
        </div>
    </div>
@endsection
