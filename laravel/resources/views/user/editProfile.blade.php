@extends('layout.app')
@section('custom_css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/imgareaselect/css/imgareaselect-default.css') }}">
@stop
@section('content')
    <div class="row nm">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Avatar</h3>
                </div>
                <div class="box-body">
                    <div class="row nm current-photo">
                        <div class="col-md-6">
                            <h5 class="center">Current photo</h5>
                            <img id="current_avatar" src="{!! $userInfo['avatarLinkSmall'] !!}" alt="avatar"/>
                        </div>
                        <div class="col-md-6" id="thumbnail-block">
                            <h5 class="center">Current thumbnail</h5>
                            <div id="thumbnail">
                                <img alt="thumbnail"/>
                                <input type="hidden" id="sizeX" name="sizeX" value="{!! $userInfo['thumbnail']['sizeX'] !!}"/>
                                <input type="hidden" id="sizeY" name="sizeY" value="{!! $userInfo['thumbnail']['sizeY'] !!}"/>
                                <input type="hidden" id="offsetX" name="offsetX" value="{!! $userInfo['thumbnail']['offsetX'] !!}"/>
                                <input type="hidden" id="offsetY" name="offsetY" value="{!! $userInfo['thumbnail']['offsetY'] !!}"/>
                            </div>
                            <div class="buttons">
                                <button id='change-thumbnail' type="button" class="btn btn-block btn-info">Change thumbnail</button>
                                <button id='submit-thumbnail' type="button" class="btn btn-block btn-info">Save thumbnail</button>
                                <button id='cancel-thumbnail' type="button" class="btn btn-block btn-danger">Cancel</button>
                            </div>

                            {{--{!! Form::open(['url' => 'edit_profile/edit_thumbnail', 'files' => true]) !!}
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
                            {!! Form::close() !!}--}}
                        </div>
                    </div>

                    <div class="row nm new_photo center">
                        <div class="col-md-12">
                            {!! Form::open(['url' => 'edit_profile/upload_photo', 'files' => true]) !!}
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
            </div>
            <!-- /.box -->
        </div>

        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">User information</h3>
                </div>
                <div class="box-body">
                    {!! Form::open(['route' => 'edit_user_info']) !!}
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-4 title"><label>Gender:</label></div>
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
                            <div class="col-lg-4 title"><label>Date of birthday:</label></div>
                            <div class="col-lg-6 field">
                                <div class="form-group">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="date_of_birthday" class="form-control pull-right" id="datepicker" value="{!! $userInfo['date_of_birthday'] !!}">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                {{--{!!  Form::date('date_of_birthday', $userInfo['date_of_birthday']) !!}--}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 title"><label>Status:</label></div>
                            <div class="col-lg-6 field">
                                <div class="form-group">
                                    <textarea name='status' class="form-control" rows="3" placeholder="Enter ...">{!! $userInfo['status'] !!}</textarea>
                                </div>
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
            <!-- /.box -->
        </div>

        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">General user information</h3>
                </div>
                <div class="box-body">
                    {!! Form::open(['route' => 'edit_general_user_info']) !!}
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-4 title"><label>Name:</label></div>
                            <div class="col-lg-6 field">
                                <input type="text" name="name" class="form-control pull-right" value="{!! $userInfo['name'] !!}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-4 title"><label>Second name:</label></div>
                            <div class="col-lg-6 field">
                                <input type="text" name="second_name" class="form-control pull-right" value="{!! $userInfo['second_name'] !!}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row center">
                            <div class="col-md-12">
                                {!! Form::submit('Save information', ['class' => 'btn btn-default']) !!}
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
@section('custom_js')
    <script src="{{ asset('assets/plugins/imgareaselect/scripts/jquery.imgareaselect.pack.js') }}"></script>
    <script src="{{ asset('assets/dist/js/editpage.js') }}"></script>
@stop