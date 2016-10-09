<!DOCTYPE html>
<html>
    <head>
        <title>Unnamed Social Network</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900|Open+Sans:400,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-theme.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}" />

        <script src="{{ asset('assets/js/jquery-3.1.0.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/libs/fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>
        <script src="{{ asset('assets/libs/fancybox/source/jquery.fancybox.pack.js?v=2.1.5') }}"></script>

        <script src="{{ asset('assets/js/main/userpage.js') }}"></script>

    </head>
    <body>
        @if (Auth::check())
        <div class="container">
            <div class="row header">
                <div class="col-sm-8 left logo">
                    <h4>
                        <a href="/">Unnamed Social Network</a>
                    </h4>
                </div>
                <div class="col-sm-4 right">
                    <a class="btn btn-default" href="{!! route('logout') !!}" role="button">LOG OUT</a>
                </div>
            </div>
        </div>
        @endif

        <div class="container">
            @yield('content')
        </div>

        <div class="footer">
            <div class="content">
                <div class="title">Unnamed Social Network</div>
                creating by
                <a href="https://www.linkedin.com/in/artem-shklyarik-bb2b14120" target="_blank">Artem Shklyarik</a>
            </div>
        </div>
    </body>
</html>
