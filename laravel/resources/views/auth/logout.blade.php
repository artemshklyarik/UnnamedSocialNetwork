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
                <div class="row center">
                    <a class="btn btn-default" href="auth/logout" role="button">LOG OUT</a>
                </div>
            </div>
        </div>
    </div>
@endsection
