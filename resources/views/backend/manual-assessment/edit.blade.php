@extends('backend.layouts.app')

@section('title', __('Edit Assessment Assignment') . ' | ' . app_name())

@section('style')
    <style>
        .step_assign {
            font-size: 17px;
            font-weight: 600;
            padding-left: 12px;
            border-bottom: 1px solid #e7e7e7;
            padding-bottom: 11px;
            margin-bottom: 25px;
            display: block;
        }
    </style>
@endsection
@push('after-styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="card">
        <div class="bg-secondary card-body d-flex justify-content-between">
            <h4>
                @lang('Edit Assessment Assignment')
            </h4>
          
        </div>
        <!-- <div class="card-header">
            <h3 class="page-title d-inline">@lang('Edit Assessment Assignment')</h3>
        </div> -->
        <form action='{{ url("/user/manual-assessments/$ma->id") }}' method="post" class="ajax">
            @method('PUT')
            <div class="card-body">
                <div class="row">

                    <div class="col-12">

                        <div class="form-group row">
                            <label class="col-lg-3 col-md-3 col-sm-4 form-control-label required"
                                for="test_id">@lang('Assessment')</label>
                            <div class="col-lg-6 col-md-6 col-sm-7 mb-3 or_optional">
                                <select class="form-control" name="assessment_id">
                                    <option>@lang('Select Assessment')</option>
                                    @foreach ($assignment as $key => $value)
                                        <option value="{{ $value->id }}"
                                            @if ($ma->assessment_id == $value->id) selected @endif>{{ $value->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <a href="{{ route('admin.assessment_accounts.assignment_create_without_course') }}"
                                    class="btn btn-primary mt-auto w-100">@lang('Add New Assessment')</a>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-md-3 col-sm-4 form-control-label required"
                                for="test_id">@lang('Users')</label>
                            <div class="col-lg-6 col-md-6 col-sm-7 mb-3 or_optional">
                                <select class="form-control select2 js-example-placeholder-multiple" name="user_id" readonly>
                                    <option></option>
                                    @foreach ($users as $key => $value)
                                        <option value="{{ $key }}"
                                            @if ($ma->user_id == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <a href="{{ url('user/employee/create?add_user') }}"
                                    class="btn btn-primary mt-auto w-100">@lang('Add User')</a>
                            </div>
                        </div>

                        <div class="form-group row mt-2">
                            <label class="col-lg-3 col-md-3 col-sm-4 form-control-label required"
                                for="first_name">@lang('Due Date')</label>
                            <div class="col-lg-6 col-md-6 col-sm-7 mb-3">
                                <input type="date" class="form-control" name="due_date" value="{{ $ma->due_date }}">
                            </div>
                        </div>
                        <div class="form-group row mt-2">
                            <label class="col-lg-3 col-md-3 col-sm-4 form-control-label required"
                                for="first_name">@lang('Qualifying Percentage')</label>
                            <div class="col-lg-6 col-md-6 col-sm-7 mb-3">
                                <input type="number" class="form-control" min="1" max="100"
                                    oninput="this.value = Math.min(Math.max(this.value, 1), 100)" name="qualifying_percent"
                                    value="{{ $ma->qualifying_percent }}">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-info pt-2 pb-2 pr-5 pl-5" type="submit">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('after-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="/js/helpers/form-submit.js"></script>

    <script>
        $('[name="users[]"]').change(function(e) {
            if ($('[name="department_id"]').val() && $('[name="users[]"]').val()) {
                $('[name="department_id"]').val('').trigger('change');
            }
        });
    </script>
@endpush
