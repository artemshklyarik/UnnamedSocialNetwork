<!DOCTYPE html>
<html>
    <head>
        <title>Unnamed Social Network</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900|Open+Sans:400,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-theme.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}" />

        <script src="{{ asset('assets/js/jquery-3.1.0.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>

    </head>
    <body>



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
