@if (Auth::check())
    <footer class="main-footer">
@else
    <footer class="main-footer"  style="margin-left: 0">
@endif
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        Unnamed Social Network
    </div>
    <!-- Default to the left -->
    <strong>Copyright © 2016 <a href="https://www.linkedin.com/in/artem-shklyarik-bb2b14120">Artem Shklyarik</a>.</strong> All rights reserved.
</footer>