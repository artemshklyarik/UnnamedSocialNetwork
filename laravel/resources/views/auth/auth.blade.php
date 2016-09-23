@extends('layout.app')
@section('content')
    <div class="content">
        <div class="col-md-6 info-group">
            <div class="row center">
                <img src="{{ asset('assets/img/author.jpg') }}" alt="artem shklyiarik">
            </div>
            <div class="row">
                Hello, my name is Artem Shklyarik. This is my pet project. It is social network. Unnamed Social Network.
                I haven't decided to whom it will be oriented. And then it can be anything in future.
                No target. There direction. I'll happy for any help.
                <a href="https://vk.com/artem_shklyarik_4" target="_blank"> You can write me</a>.
            </div>
        </div>
        <div class="col-md-6 form-group">
            <div class="auth">
                <form action="/auth/login" method="POST">
                    {!! csrf_field() !!}
                    <div class="row">
                        <p class="error">{!! $errors->first('email') !!}</p>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <span class="input-group-addon" id="login">@</span>
                            <input name="email" type="email" class="form-control" placeholder="Mail" aria-describedby="basic-addon1" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <span class="input-group-addon" id="password">p</span>
                            <input name="password" type="password" id="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 np">
                            <a href="auth/register">Registration</a>
                        </div>
                        <div class="col-md-6 right np">
                            <input type="checkbox" name="remember"> Remember Me
                            <input class="btn btn-default" type="submit" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
