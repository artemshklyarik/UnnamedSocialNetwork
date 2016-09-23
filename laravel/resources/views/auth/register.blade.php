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
                        <button class="btn btn-default" type="submit">Register</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
