@extends('layout.app')
@section('content')
    <div class="content edit_profile">
        <div class="row nm center toplink">
            <a href="/">Back to my profile</a>
        </div>
        <div class="row nm">
            <div class="col-md-6 photo center">
                <h4>Current photo</h4>
                <img src="{!! $avatarLink !!}" alt="avatar"/>

                <div class="row nm new_photo center">
                    <div class="col-md-12">
                        <form enctype="multipart/form-data" name="newPhoto" method="post" action="edit_profile/upload_photo">
                            {!! csrf_field() !!}

                            <div class="status">
                                <p class="success">{!! Session::get('success') !!}</p>
                                <p class="error">{!!$errors->first('image')!!}</p>
                                <p class="error">{!! Session::get('error') !!}</p>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Upload new photo</label>
                                <input type="file" id="exampleInputFile" name="photo">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-default" type="submit">Upload photo</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-info">

            </div>
        </div>
    </div>
@endsection
