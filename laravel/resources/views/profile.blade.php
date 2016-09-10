@extends('layout.app')
@section('content')
    <div class="content center">
        <div class="row header">
            <div class="col-sm-8 left logo">
                <h4>
                    <a href="/">Unnamed Social Network</a>
                </h4>
            </div>
            <div class="col-sm-4 right">
                <a class="btn btn-default" href="{!! route('logout') !!}" role="button">LOG OUT</a>
            </div>
        </div>
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
            <div class="row" id="question">
                @if(isset($id))
                    <form action="ask/{!! $id !!}" method="post">
                        {!! csrf_field() !!}
                        <h5>Ask your question</h5>
                        <textarea class="form-control" rows="3" name="question"></textarea>
                        <div class="row">
                            <div class="col-md-12 right">
                                <button type="submit" class="btn btn-default">Ask question</button>
                            </div>
                        </div>
                    </form>
                @else
                    @if(count($newQuestions))
                        <h5>New questions</h5>
                    @else
                        <h5>You have not new question</h5>
                    @endif
                    @foreach($newQuestions as $question)
                        <form action="user/answer/{!! $question['id'] !!}" method="post">
                            {!! csrf_field() !!}

                            <h5 class="left">{!! $question['question'] !!} <span class="label label-default">New</span></h5>

                            <textarea class="form-control" rows="3" name="answer"></textarea>
                            <div class="row">
                                <div class="col-md-12 right">
                                    <button type="submit" class="btn btn-default">Answer this question</button>
                                </div>
                            </div>
                        </form>

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
                                    from:
                                    <a href="/user/{!! $users[$question['question_man'] - 1]->id !!}">
                                        {!! $users[$question['question_man'] - 1]->name !!}
                                    </a>
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
