@extends('layout.app')
@section('content')
    <section class="content-header">
        <h1>
            User Profile
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="{!! $userInfo['avatarLink'] !!}" alt="User profile picture">

                        <h3 class="profile-username text-center">{!! $userInfo['name'] !!}  {!! $userInfo['second_name'] !!}</h3>

                        <p class="text-muted text-center">{!! $userInfo['status'] !!}</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                @if (!isset($id))
                                    <b>Friends</b> <a href="/friends" class="pull-right">{!! count($friends['all']) !!}</a>
                                @else
                                    <b>Friends</b> <a href="/friends?id={!! $id !!}" class="pull-right">{!! count($friends['all']) !!}</a>
                                @endif

                            </li>
                        </ul>

                        @if(isset($id))
                            {!! csrf_field() !!}

                            @if($isfriend === 'send request')
                                <div class="callout callout-info">
                                    <h4>Request has sent</h4>

                                    <p>The user has received your offer of friendship. Wait for his answer.</p>
                                </div>
                            @elseif($isfriend === 'get request')
                                <div class="callout callout-info">
                                    <h4> {!! $userInfo['name'] !!} has sent request to you</h4>

                                    <p>You may to accept or reject this request</p>
                                </div>
                                <a href="{!! route('accept_request_friend') !!}" class="btn btn-primary btn-block" data-friend="{!! $id !!}">
                                    <b>Add to friends</b>
                                </a>
                                <a href="{!! route('reject_request_friend') !!}" class="btn btn-danger btn-block" data-friend="{!! $id !!}">
                                    <b>Remove from friends</b>
                                </a>
                            @elseif($isfriend == true)
                                {{--Do not remove this. Need for js--}}
                                <div class="callout callout-info" style="display: none;">
                                    <h4></h4>
                                    <p></p>
                                </div>
                                <a href="{!! route('remove_friend') !!}" class="btn btn-danger btn-block" data-friend="{!! $id !!}">
                                    <b>Remove from friends</b>
                                </a>
                            @else
                                {{--Do not remove this. Need for js--}}
                                <div class="callout callout-info" style="display: none;">
                                    <h4></h4>
                                    <p></p>
                                </div>
                                <a href="{!! route('add_friend') !!}" class="btn btn-primary btn-block" data-friend="{!! $id !!}">
                                    <b>Add to friends</b>
                                </a>
                            @endif

                        @endif
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>
            <!-- /.col -->

            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#questions" data-toggle="tab">Questions</a></li>
                        @if(!isset($id))
                            <li><a href="#newquestions" data-toggle="tab">New questions</a></li>
                            <li><a href="#settings" data-toggle="tab">Settings</a></li>
                        @else
                            <li><a href="#ask" data-toggle="tab">Ask new question</a></li>
                        @endif
                    </ul>

                    <div class="tab-content">
                        <div class="active tab-pane" id="questions">
                            @if (count($questions))
                                @foreach ($questions as $question)
                                    <div class="box box-info box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{!! $question->question !!}</h3>

                                            <div class="box-tools pull-right">
                                                from:
                                                @if ($question->anonimous)
                                                    Anomimous
                                                @else
                                                    <a href="/user/{!! $question->question_man !!}">{!! $question->name !!} {!! $question->second_name !!}</a>
                                                @endif
                                                @if(!isset($id))
                                                    <button type="button" href="user/question/remove" class="btn btn-box-tool remove-question" data-id="{!! $question->id !!}" data-widget="remove"><i class="fa fa-times"></i></button>
                                                @endif
                                            </div>
                                            <!-- /.box-tools -->
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            {!! $question->answer !!}
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                @endforeach

                                <button type="button" class="btn btn-block btn-info" id="showMoreAnswers">Show more answers</button>

                            @else
                                This user has not answered the questions
                            @endif
                        </div>
                        <div class="tab-pane" id="newquestions">
                            @foreach ($newQuestions as $question)
                                <div class="row nm">
                                    <form role="form" action="user/answer/{!! $question->id !!}" method="post">
                                        {!! csrf_field() !!}
                                        <div class="box-body">
                                            <div class="form-group">
                                                <div class="col-xs-6 left np">
                                                    <label>{!! $question->question !!}</label>
                                                </div>
                                                <div class="col-xs-6 right np">
                                                    From:
                                                    @if ($question->anonimous)
                                                        Anonimous
                                                    @else
                                                        <a href="/user/{!! $question->question_man !!}">
                                                            {!! $question->name !!} {!! $question->second_name !!}
                                                        </a>
                                                    @endif
                                                </div>

                                                <textarea name="answer" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->

                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Answer</button>
                                            <hr />
                                        </div>

                                    </form>
                                </div>
                            @endforeach
                            <button type="button" class="btn btn-block btn-info" id="showMoreQuestions" style="display: inline-block;">Show more questions</button>

                        </div>
                        @if(isset($id))
                            <div class="tab-pane" id="ask">
                                {!! Form::open(['route' => ['ask_question', $id]]) !!}
                                {!! csrf_field() !!}

                                <div class="box-body">
                                        <div class="form-group">
                                            <div class="col-xs-12 left np">
                                                <label>Ask your question</label>
                                            </div>
                                            <textarea name="question" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="row nm">
                                        <div class="col-xs-6">
                                            {!! Form::checkbox('anonimous', true) !!} Anonimous question
                                        </div>

                                        <div class="col-xs-6 right">
                                            {!! Form::submit('Ask question', ['class' => 'btn btn-primary']) !!}
                                        </div>
                                    </div>

                                {!! Form::close() !!}

                            </div>
                        @endif

                        <div class="tab-pane" id="settings">
                            333
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- /.content -->
@endsection