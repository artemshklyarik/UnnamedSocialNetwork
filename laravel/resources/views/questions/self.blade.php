@extends('layout.app')
@section('content')
    <div class="overlay">
        <i class="fa fa-refresh fa-spin"></i>
    </div>

    <div class="row nm">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Your questions</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" id="questionsTable">
                        <tbody>
                            <tr>
                                <th>To user</th>
                                <th>Question time</th>
                                <th>Status</th>
                                <th>Your question</th>
                                <th>Answer</th>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

    <div class="row nm">
        <div class="col-md-12 center">
            <button type="button" class="btn btn-block btn-info" id="showMore">Show more</button>
        </div>
    </div>

@endsection

@section('custom_js')
    <script src="{{ asset('assets/dist/js/questions.js') }}"></script>
@stop