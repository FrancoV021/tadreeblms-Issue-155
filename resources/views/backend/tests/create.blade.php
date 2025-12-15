@extends('backend.layouts.app')
@section('title', 'Tests | ' . app_name())

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

    <div id="error-messages"></div>
    <form method="POST" action="{{ route('admin.tests.store') }}" id="addTest">
        @csrf
        <div class="pb-3 d-flex justify-content-between align-items-center">
       <h4>
           Create Test
       </h4>
         <div >
               <a href="{{ route('admin.tests.index') }}" class="btn btn-primary">View Tests</a>
           </div>
     
   </div>
        <div class="card">
            <!-- <div class="card-header">
                <h3 class="page-title float-left mb-0">Create Test</h3>
                <div class="float-right">
                    <a href="{{ route('admin.tests.index') }}" class="btn btn-success">View Tests</a>
                </div>
            </div> -->
            <div class="card-body">

                <div class="row">
                    <div class="col-12 col-lg-6 form-group">
                        <label for="title" class="control-label">Select Course</label>
                       
                        <select class="select2" name="course_id_selected" onchange="setCourseId(this.value)">
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                                <option @if($selected_course_id == $course->id) selected @endif value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-6 form-group">
                        <label for="title" class="control-label">Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Enter Test Title" value="{{ old('title') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 form-group">
                        <label for="description" class="control-label">Description</label>
                        <textarea name="description" class="form-control" id="description" placeholder="Enter Test Description">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-4 form-group">
                        <label for="passing_score" class="control-label">Passing Score</label>
                        <input type="text" name="passing_score" class="form-control" id="passing_score" placeholder="Enter Passing Score" value="{{ old('passing_score') }}">
                    </div>
                    <div class="col-4 form-group mt-4">
                        <input type="hidden" name="published" value="1">
                        <input type="checkbox" checked name="published" value="1" id="published" class="checkbox">
                        <label for="published" class="control-label font-weight-bold">Published</label>
                    </div>
                </div>
            </div>
            <input type="hidden" id="feedback_index" name="feedback_url" value="{{ route('admin.tests.index') }}">

            <input type="hidden" id="user-assisment" name="assessment_url" value="{{ url('user/assignments/create').'?course_id='.$selected_course_id.'&assis_new' }}">

            <input type="hidden" id="questions_url" name="questions_url" value="{{ route('admin.test_questions.create') }}">
            <input type="hidden" id="action_btn" name="action_btn" value="submit_add_question">
            <input type="hidden" id="course_id" name="course_id" value="{{$selected_course_id}}">
            
        </div>

        {{-- <button type="submit" value="done" id="submit_done" class="btn btn-danger">Done</button> --}}
        <div class="col-12 text-right pr-0">

            <button type="submit" value="submit_add_question" id="submit_add_question" class="btn btn-info">Save & Add Questions</button>
        </div>
    </form>

@stop

@push('after-scripts')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
    var nxt_url_val = '';

    $('.frm_submit').on('click', function () {
        nxt_url_val = $(this).val();
        $('#action_btn').val(nxt_url_val);
    });

    $('#addTest input').on('keyup blur', function () {
        if ($('#addTest').valid()) {
            $('button.btn').prop('disabled', false);
        } else {
            $('button.btn').prop('disabled', 'disabled');
        }
    });

    function setCourseId(course_id)
    {
        $('#course_id').val(course_id)
        $('#user-assisment').val("{{ url('user/assignments/create') }}?course_id=" + course_id + "&assis_new=1");
    }

    $().ready(function() {
        $('#addTest').validate({
            rules: {
                course_id_selected: "required",
                title: "required",
                passing_score: "required",
            },
            submitHandler: function(form) {
                submit_function();
            }
        });
    });

    function submit_function() {
        hrefurl = $(location).attr("href");
        last_part = hrefurl.substr(hrefurl.lastIndexOf('&') + 1);
        var submit_done = $('#submit_done').val();
        var submit_add_question = $('#submit_add_question').val();

        setTimeout(() => {
            let data = $('#addTest').serialize();
            let url = '{{ route('admin.tests.store') }}';
            var redirect_url = $("#feedback_index").val();
            var redirect_url_course = $("#user-assisment").val();
            var redirect_url_add_question = $("#questions_url").val();

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                datatype: "json",
                success: function (res) {
                    console.log(res)
                    window.location.href = res.redirect_url;
                    return;
                },
                error: function (xhr, status, error) {
                // Check for validation error (422)
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        console.log(errors); // Debug: log all errors

                        // Optional: display the errors on the page
                        let errorHtml = '<ul>';
                        $.each(errors, function (key, value) {
                            errorHtml += '<li>' + value[0] + '</li>';
                        });
                        errorHtml += '</ul>';

                        $('#error-messages').html(errorHtml).show();
                    } else {
                        console.log("Something went wrong: ", error);
                    }
                }
            });
        }, 100);
    }
</script>
@endpush
