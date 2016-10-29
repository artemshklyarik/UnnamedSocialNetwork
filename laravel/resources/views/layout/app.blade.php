<!DOCTYPE html>
<html>
    <head>
        <title>Unnamed Social Network - @yield('title')</title>
        @include('layout.scripts')
    </head>
    <body class="skin-blue">
        @include('layout.header')

        @if (Auth::check())
            @section('sidebar')
                @include('layout.sidebar')
            @show
        @endif

        @if (Auth::check())
            <div class="content-wrapper" style="padding-top: 15px;">
        @else
            <div class="content-wrapper" style="min-height: 946px; margin-left: 0;">
        @endif
            @yield('content')
        </div>

        @include('layout.footer')
        @include('layout.footer_scripts')
        @yield('custom_js')
    </body>
</html>
