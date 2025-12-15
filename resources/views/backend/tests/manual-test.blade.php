@extends('backend.layouts.app')
@section('title', __('labels.backend.tests.title') . ' | ' . app_name())

@push('after-styles')
    <style>
        .select2-container--default .select2-selection--single {
            height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px;
        }
    </style>
@endpush
@section('content')

    <!-- {!! Form::open(['method' => 'POST', 'route' => ['admin.tests.store']]) !!} -->
    {!! Form::open(['method' => 'POST', 'id' => 'addTest']) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.tests.create')</h3>
            <div class="float-right">

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('course_id', trans('labels.backend.tests.fields.course'), ['class' => 'control-label']) !!}
                        {!! Form::select('course_id', $courses, old('course_id'), ['class' => 'form-control select2']) !!}

                    </div> -->

                <div class="col-12 col-lg-6  form-group">
                    {!! Form::label('title', trans('labels.backend.tests.fields.title'), ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), [
                        'class' => 'form-control',
                        'placeholder' => trans('labels.backend.tests.fields.title'),
                    ]) !!}

                </div>
            </div>

            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('description', trans('labels.backend.tests.fields.description'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('description', old('description'), [
                        'class' => 'form-control ',
                        'placeholder' => trans('labels.backend.tests.fields.description'),
                    ]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-4 form-group">
                    {!! Form::label('passing_score', trans('labels.backend.tests.fields.score_field'), ['class' => 'control-label']) !!}
                    {!! Form::text('passing_score', old('passing_score'), [
                        'class' => 'form-control',
                        'placeholder' => trans('labels.backend.tests.fields.score_field_placeholder'),
                    ]) !!}
                </div>
                <div class="col-4 form-group">
                    {!! Form::hidden('published', 0) !!}
                    {!! Form::checkbox('published', 1, false, []) !!}
                    {!! Form::label('published', trans('labels.backend.tests.fields.published'), [
                        'class' => 'control-label font-weight-bold',
                    ]) !!}

                </div>
            </div>
        </div>
        <input type="hidden" id="feedback_index" name="feedback_url" value="{{ route('admin.tests.index') }}">
        <input type="hidden" id="user-assisment" name="assessment_url"
            value="{{ url('user/assignments/create') . '?course_id=' . $selected_course_id . '&assis_new' }}">
        <input type="hidden" id="questions_url" name="questions_url" value="{{ route('admin.test_questions.create') }}">
        <input type="hidden" id="action_btn" name="action_btn" value="">
        <input type="hidden" id="course_id" name="course_id" value="{{ $selected_course_id }}">
    </div>

    <button type="submit" value="submit_add_question" id="submit_add_question" class="frm_submit submit btn btn-info">Save
        & Add Questions</button>
    {!! Form::close() !!}
@stop
@push('after-scripts')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script>
        var nxt_url_val = '';

        $('.frm_submit').on('click', function() {
            nxt_url_val = $(this).val();
            $('#action_btn').val(nxt_url_val);
        });

        $('#addTest input').on('keyup blur', function() { // fires on every keyup & blur
            if ($('#addTest').valid()) { // checks form for validity
                $('button.btn').prop('disabled', false); // enables button
            } else {
                $('button.btn').prop('disabled', 'disabled'); // disables button
            }
        });

        $().ready(function() {
            $('#addTest').validate({
                rules: {
                    title: "required",
                    passing_score: "required",
                },
                messages: {

                },
                submitHandler: function(form) {
                    submit_function();
                }

                // any other options and/or rules
            });

        });

        function submit_function() {

            hrefurl = $(location).attr("href");
            last_part = hrefurl.substr(hrefurl.lastIndexOf('&') + 1)
            var submit_done = $('#submit_done').val();
            var submit_add_question = $('#submit_add_question').val();


            //return false;
            setTimeout(() => {
                let data = $('#addTest').serialize();
                let url = '{{ route('admin.tests.manualTest') }}';
                var redirect_url = $("#feedback_index").val();
                var redirect_url_course = $("#user-assisment").val();
                var redirect_url_add_question = $("#questions_url").val();

                //alert(data);
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    datatype: "json",
                    success: function(res) {
                        window.location.href = res.redirect_url;
                        return;
                    }
                })
            }, 100);

        }
    </script>
@endpush
