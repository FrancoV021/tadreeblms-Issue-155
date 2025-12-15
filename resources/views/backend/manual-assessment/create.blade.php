@extends('backend.layouts.app')

@section('title', __('Create Assessment Assignment') . ' | ' . app_name())
@push('after-styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet" />
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
 
.select2-container .select2-search--inline .select2-search__field {
    box-sizing: border-box;
    border: none;
    font-size: 100%;
    margin-top: 5px;
    padding-left: 8px;
}

.select2-container--default .select2-selection--multiple:focus {
    outline: none !important;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5) !important;
    border-color: #007bff !important;
}
.select2-container--default.select2-container--focus .select2-selection--multiple {
     outline: none !important;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5) !important;
    border-color: #007bff !important;
}
.select2-container--default .select2-selection--multiple{
    border: 1px solid #ccc !important;
}
       </style>
@endpush


@section('content')
<div class="pb-3 d-flex justify-content-between align-items-center">
  <h4>
      @lang('Create Assessment Assignment')
  </h4>

</div>
    <div class="card">
        <!-- <div class="card-header">
            <h3 class="page-title d-inline">@lang('Create Assessment Assignment')</h3>
        </div> -->
        <form action="{{ route('admin.manual-assessments.store') }}" method="post" class="ajax">
            <div class="card-body">
                <div class="row">

                    <div class="col-12">

                        <div class="form-group row">
                            <div class="col-lg-3 col-md-3 col-sm-4 form-control-label required"
                                for="test_id">@lang('Assessment')</div>
                            <div class="col-lg-6 col-md-9 col-sm-8 mb-3 custom-select-wrapper mt-2">
                                <select class="form-control custom-select-box" name="assessment_id">
                                    <option>@lang('Select Assessment')</option>
                                    @foreach ($assignment as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->title }}</option>
                                    @endforeach
                                </select>
                                <span class="custom-select-icon" style="right: 24px;">
            <i class="fa fa-chevron-down"></i>
        </span>
                            </div>

                            <div class="col-lg-3 col-md-12 col-sm-12 mt-2">
                                <a href="{{ route('admin.assessment_accounts.assignment_create_without_course') }}"
                                    class="btn btn-primary mt-auto w-100">@lang('Add New Assessment')</a>
                            </div>

                        </div>

                        <div class="form-group row">
                           <label class="col-lg-3 col-md-3 col-sm-4 form-control-label required" for="users">@lang('Users')</label>
<div class="col-lg-6 col-md-9 col-sm-8 mb-3">
    <div class="custom-select-wrapper mt-2">
        <select name="users[]" class="form-control custom-select-box select2 js-example-placeholder-multiple" multiple required>
            @foreach($users as $id => $name)
                <option value="{{ $id }}" @if(in_array($id, old('users', []))) selected @endif>{{ $name }}</option>
            @endforeach
        </select>
        <span class="custom-select-icon">
            <i class="fa fa-chevron-down"></i>
        </span>
    </div>
</div>

                            <div class="col-lg-3 col-md-12 col-sm-12 mt-2">
                                <a href="{{ url('user/employee/create?add_user') }}"
                                    class="btn btn-primary mt-auto w-100">@lang('Add User')</a>
                            </div>
                        </div>

                        <br>
                        @lang('OR')
                        <br>

                        <div class="form-group row mt-2">
                            <div class="col-lg-3 col-md-3 col-sm-4 form-control-label required"
                                for="first_name">@lang('Select Department')</div>
                            <div class="col-lg-6 col-md-9 col-sm-8 mb-3 custom-select-wrapper mt-2">
                                <select name="department_id" class="form-control custom-select-box">
                                    <option value="" selected disabled> @lang('Select One') </option>
                                    @foreach ($departments as $row)
                                        <option value="{{ $row->id }}"> {{ $row->title }} </option>
                                    @endforeach
                                </select>
                                <span class="custom-select-icon" style="right: 23px;">
            <i class="fa fa-chevron-down"></i>
        </span>
                            </div><!--col-->
                            <div class="col-lg-3 col-md-12 col-sm-12 mt-2">
                                <!-- <div class="col-lg-3 col-md-3 col-sm-6"> -->
                                    <a href="{{ url('user/department-create?add_dep') }}"
                                        class="btn btn-primary w-100">@lang('Add Department')</a>
                                <!-- </div> -->
                            </div>
                        </div>
                        <div class="form-group row mt-2">
                            <label class="col-lg-3 col-md-3 col-sm-4 form-control-label required"
                                for="first_name">@lang('Due Date')</label>
                            <div class="col-lg-6 col-md-9 col-sm-8 mb-3">
                                <input type="date" class="form-control" id="due_date" name="due_date"
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            </div>
                        </div>
                        <div class="form-group row mt-2">
                            <label class="col-lg-3 col-md-3 col-sm-4 form-control-label required"
                                for="first_name">@lang('Qualifying Percentage')</label>
                            <div class="col-lg-6 col-md-9 col-sm-8 mb-3">
                                <input type="number" class="form-control" min="1" max="100"
                                    oninput="this.value = Math.min(Math.max(this.value, 1), 100)" name="qualifying_percent">
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

        const dateInput = document.getElementById('due_date');
        const today = new Date();

        // Calculate tomorrow's date
        const tomorrow = new Date(today);
        tomorrow.setDate(today.getDate() + 1);

        // Format date as YYYY-MM-DD
        const yyyy = tomorrow.getFullYear();
        const mm = String(tomorrow.getMonth() + 1).padStart(2, '0'); // Months are 0-based
        const dd = String(tomorrow.getDate()).padStart(2, '0');

        const minDate = `${yyyy}-${mm}-${dd}`;
        dateInput.min = minDate; // Set the min attribute to tomorrow's date
    </script>
@endpush
