@extends('layout.app')
@section('content')
    <h3>Users</h3>
    <ul>
        @foreach($users as $user)
            <li><a href="/user/{!! $user->id !!}">{!! $user->name !!}</a></li>
        @endforeach
    </ul>
@endsection
