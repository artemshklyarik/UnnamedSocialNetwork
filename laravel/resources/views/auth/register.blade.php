@extends('layout.app')
@section('content')
    <div class="content">
        <div class="col-md-6 info-group">
            <div class="row center">
                <img src="{{ asset('assets/img/author.jpg') }}" alt="artem shklyiarik">
            </div>
            <div class="row">
                Hello, my name is Artem Shklyarik.
                Welcome to my pet project.
                It is an unnamed Social Network.
                I have not decided what audience it will be target on and then it can be anything in future.
                I do not persecute any goal, there is only the idea to create something new.
                I will be glad to any help, so you can send me your suggestions to
                <a href="https://twitter.com/tema_johnson" target="_blank">Twitter</a>
                or
                <a href="https://www.linkedin.com/in/artem-shklyarik-bb2b14120" target="_blank">LinkedIn</a>
            </div>
        </div>
        <div class="col-md-6 form-group">
            <div class="auth">
                <form method="POST" action="/auth/register">
                    {!! csrf_field() !!}
                    <div class="row">
                        @if (count($errors))
                            <ul>
                                @foreach($errors->all() as $error)
                                    <p class="error">{{ $error }}</p>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <span class="input-group-addon" id="login">n</span>
                            <input name="name" type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <span class="input-group-addon" id="login">@</span>
                            <input name="email" type="email" class="form-control" placeholder="Email" aria-describedby="basic-addon1" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <span class="input-group-addon" id="login">p</span>
                            <input name="password" type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <span class="input-group-addon" id="login">p</span>
                            <input name="password_confirmation" type="password" class="form-control" placeholder="Password Confirmation" aria-describedby="basic-addon1">
                        </div>
                    </div>

                    <div>
                        <div class="col-md-6">
                            <button class="btn btn-default" type="submit">Register</button>
                        </div>
                        <div class="col-md-6 right">
                            <a href="/">Return to Log In page</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
