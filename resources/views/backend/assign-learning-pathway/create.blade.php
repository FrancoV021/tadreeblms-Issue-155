@extends('backend.layouts.app')
@section('title', __('Create Learning Pathway') . ' | ' . app_name())
@push('after-styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left">@lang('Create Learning Pathway')</h3>
            <div class="float-right">
                <a href="{{ route('admin.learning-pathways.index') }}" class="btn btn-success">@lang('View Learning Pathways')</a>
            </div>
        </div>

        <div class="card-body">
            <form class="ajax" action="/user/learning-pathways" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="course_with_order">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="required">@lang('Title')</label>
                            <input class="form-control" name="title" type="text" placeholder="@lang('Title')">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="required">@lang('Add Courses to Pathway')</label>
                            <select class="select2" name="course_id" multiple>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label>@lang('Description')</label>
                            <textarea class="form-control" cols="30" rows="10" name="description"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>@lang('Pathway courses (Drag and drop to reorder)')</label>
                        <div id="pathwayCourses" class="list-group col">
                            <div class="list-group-item" id="pathwayCourses-placeholder">Selected courses will appear here
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button class="btn btn-info text-uppercase px-4" type="submit">
                        @lang('Create')
                    </button>
                </div>
            </form>
        </div>
        <input type="hidden" id="course_index" value="{{ route('admin.courses.index') }}">
        <input type="hidden" id="lesson" value="{{ route('admin.lessons.create') }}">
        <input type="hidden" id="new-assisment" value="{{ route('admin.assessment_accounts.new-assisment') }}">
    </div>
@stop

@push('after-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.6/Sortable.min.js"></script>
    <script src="/js/helpers/form-submit.js"></script>
    <script>
        new Sortable(pathwayCourses, {
            animation: 150,
            onEnd: function(evt) {
                setCoursePositionFormData();
            }
        });

        $('[name="course_id"]').on('select2:select', function(e) {
            const selectedData = e.params.data; // The selected item data

            if (!$('#pathwayCourses-placeholder').hasClass('d-none')) {
                $('#pathwayCourses-placeholder').addClass('d-none');
            }

            const newItem = $('<div></div>')
                .addClass('list-group-item')
                .text(selectedData.text) // Display the text
                .attr('data-value', selectedData.id); // Store the value for later removal

            // Append the item to the sortable container
            $('#pathwayCourses').append(newItem);

            setCoursePositionFormData();
        });

        $('[name="course_id"]').on('select2:unselect', function(e) {
            const removed = e.params.data;
            $(`#pathwayCourses .list-group-item[data-value="${removed.id}"]`).remove();

            if ($('#pathwayCourses .list-group-item').length == 1) {
                $('#pathwayCourses-placeholder').removeClass('d-none');
            }

            setCoursePositionFormData();
        });

        function setCoursePositionFormData() {
            const order = [];
            $('#pathwayCourses .list-group-item:not(#pathwayCourses-placeholder)').each(function() {
                const value = $(this).attr('data-value'); // Get the data-value attribute
                order.push(value);
            });
            
            $('[name="course_with_order"]').val(JSON.stringify(order))
        }
    </script>
@endpush
