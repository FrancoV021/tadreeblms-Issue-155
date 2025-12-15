@extends('backend.layouts.app')
@section('title', __('Manual Assessments Assignments') . ' | ' . app_name())
@push('after-styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet" />
      <style>
     
   .switch.switch-3d.switch-lg {
    width: 40px;
    height: 20px;
}
.switch.switch-3d.switch-lg .switch-handle {
    width: 20px;
    height: 20px;
}


    </style>
@endpush
@section('content')

<div class="pb-3  d-flex justify-content-between align-items-center">

    <h4 >
        @lang('Manual Assessments Assignments')
    </h4>
    
        <div class="">
             <div class="">
        <a id="send-reminder-all-users" href="#" class="btn btn-success">@lang('Send reminder to all users')</a>
        <a href="{{ url('/user/manual-assessments/create') }}" class="btn add-btn">+ @lang('Make New Assignment')</a>
    </div>
    
        </div>
</div>
    <div class="card">
           
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="myTable"
                            class="table dt-select custom-teacher-table table-striped @if (auth()->user()->isAdmin()) @if (request('show_deleted') != 1) dt-select @endif @endcan">
                            <thead>
                                <tr>
                                    <th>@lang('Assessment')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Qualifying %')</th>
                                    <th>@lang('Assigned Date')</th>
                                    <th>@lang('Due date')</th>
                                    <th>@lang('Score')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('after-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="/js/helpers/confirm-modal.js"></script>
    <script src="/js/helpers/load-modal.js"></script>
    <script src="/js/pages/manual-assessments.js"></script>
    <script src="/js/helpers/form-submit.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
@endpush
