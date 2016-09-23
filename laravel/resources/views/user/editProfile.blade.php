@extends('layout.app')
@section('content')
    <div class="content edit_profile">
        <div class="row nm center toplink">
            <a href="/">Back to my profile</a>
        </div>
        <div class="row nm">
            <div class="col-md-6 photo center">
                <h4>Current photo</h4>
                <img src="{!! $userInfo['avatarLink'] !!}" alt="avatar"/>
                {{--{{ HTML::image($userInfo['avatarLink']) }}--}}
                <div class="row nm new_photo center">
                    <div class="col-md-12">
                        {!! Form::open(['route' => 'edit_profile', 'files' => true]) !!}
                            {!! csrf_field() !!}

                            <div class="status">
                                <p class="success">{!! Session::get('success') !!}</p>
                                <p class="error">{!!$errors->first('image')!!}</p>
                                <p class="error">{!! Session::get('error') !!}</p>
                            </div>
                            <div class="form-group">
                                {!! Form::label('exampleInputFile', 'Upload new photo') !!}
                                {!! Form::file('photo', ['id' => 'exampleInputFile']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::submit('Upload photo', ['class' => 'btn btn-default']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-info">
                {!! Form::open(['route' => 'edit_user_info']) !!}
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-4 title">Gender:</div>
                            <div class="col-lg-6 field">
                                @if ($userInfo['gender'] == 'male')
                                    <p>{!! Form::radio('gender', 'male', true) !!} Male </p>
                                    <p>{!! Form::radio('gender', 'female') !!} Female </p>
                                    <p>{!! Form::radio('gender', 'hide') !!} Unknown </p>
                                @elseif ($userInfo['gender'] == 'female')
                                    <p>{!! Form::radio('gender', 'male') !!} Male </p>
                                    <p>{!! Form::radio('gender', 'female', true) !!} Female </p>
                                    <p>{!! Form::radio('gender', 'hide') !!} Unknown </p>
                                @else
                                    <p>{!! Form::radio('gender', 'male') !!} Male </p>
                                    <p>{!! Form::radio('gender', 'female') !!} Female </p>
                                    <p>{!! Form::radio('gender', 'hide', true) !!} Unknown </p>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 title">Date of birthday:</div>
                            <div class="col-lg-6 field">
                                {!!  Form::date('date_of_birthday', $userInfo['date_of_birthday']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 title">Status:</div>
                            <div class="col-lg-6 field">
                                {!! Form::textarea('status', $userInfo['status']) !!}
                            </div>
                        </div>
                        <div class="row center">
                            <div class="col-md-12">
                                {!! Form::submit('Save information', ['class' => 'btn btn-default']) !!}
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
