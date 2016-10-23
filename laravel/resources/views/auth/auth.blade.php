@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row nm page-form">
            <div class="col-md-6">
                <div class="row text">
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
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Log In</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="/auth/login" method="post" class="form-horizontal">
                        {!! csrf_field() !!}
                        <div class="box-body">
                            <p class="text-red"><span>{!! $errors->first('email') !!}</span></p>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

                                <div class="col-sm-10">
                                    <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Password</label>

                                <div class="col-sm-10">
                                    <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember me
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="auth/register">Registration</a>
                            <button type="submit" class="btn btn-info pull-right">Sign in</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
