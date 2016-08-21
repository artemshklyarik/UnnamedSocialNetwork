@extends('layout.app')
@section('content')
    <div class="content center">
        <h2>Hello, {{ Auth::user()->name }}!</h2>
        <div class="row">
            <a class="btn btn-default" href="auth/logout" role="button">LOG OUT</a>
        </div>
    </div>
@endsection
