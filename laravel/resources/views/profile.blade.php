@extends('layout.app')
@section('content')
    <div class="content center">
        <h2>Hello, {{ Auth::user()->name }}!</h2>
        <div class="row">
            <div class="col-md-3">
                <a href="/">My page</a>

                <h5>Users</h5>
                <ul>
                    @foreach($users as $user)
                        @if($user->id != Auth::user()->id)
                            <li><a href="/user/{!! $user->id !!}">{!! $user->name !!}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6">
                <a class="btn btn-default" href="auth/logout" role="button">LOG OUT</a>
            </div>

        </div>
    </div>
@endsection
