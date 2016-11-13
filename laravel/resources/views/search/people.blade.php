@extends('layout.app')
@section('content')
    <div class="overlay">
        <i class="fa fa-refresh fa-spin"></i>
    </div>

    <div class="row nm" id="friends-block">
        <div class="col-md-12" id="friends-block-inner">
            <div class="nav-tabs-custom">
                {!! csrf_field() !!}
                <input type="hidden" name="id_owner" id="idOwner" value="{!! $authUserInfo['id'] !!}" />
                <input type="hidden" name="url" id="url" value="{!! route('search_people_ajax') !!}" />

                <ul class="nav nav-tabs">
                    <li class="active"><a href="#people" data-toggle="tab">People</a></li>
                </ul>

                <div class="tab-content">
                    <div class="active tab-pane" id="search">
                        <div class="row nm filter-block">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" id="name" name="q" value="{!! $q !!}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select id="gender" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                        <option value="" selected="selected">Any</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" id="countryId" value="{!! $country !!}">
                                    <label>Country</label>
                                    <select class="form-control" id="countries" name="country">

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" id="cityId" value="{!! $city !!}">
                                    <label>City</label>
                                    <select class="form-control" id="cities" name="city" disabled="">

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row nm">
                            <input type="hidden" name="scope" id="scope" value="search" />
                            <div id="all-people">
                            </div>
                        </div>
                        <button type="button" class="btn btn-block btn-info" id="showMorePeople">Show more people</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script src="{{ asset('assets/dist/js/people.js') }}"></script>
@stop