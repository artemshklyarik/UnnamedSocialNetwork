@extends('layout.app')
@section('content')
    <div class="overlay">
        <i class="fa fa-refresh fa-spin"></i>
    </div>

    <div class="row nm">
        <div class="col-md-12">
            <ul class="timeline" id="newsletter">

                <!-- timeline time label -->
                <li class="time-label">
                    <span class="bg-red">
                        Newsletter
                    </span>
                </li>
                <!-- /.timeline-label -->
            </ul>
        </div>
    </div>

    <div class="row nm">
        <div class="col-md-12 center">
            <button type="button" class="btn btn-block btn-info" id="showMore">Show more</button>
        </div>
    </div>

@endsection

@section('custom_js')
    <script src="{{ asset('assets/dist/js/newsletter.js') }}"></script>
@stop