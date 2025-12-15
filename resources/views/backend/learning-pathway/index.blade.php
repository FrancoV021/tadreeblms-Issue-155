@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', __('Learning Pathways') . ' | ' . app_name())
@push('after-styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet" />
      <style>

    </style>
@endpush
@section('content')
<div class="pb-3 align-items-center d-flex justify-content-between">
    <h5 >@lang('Learning Pathways')</h5>
    <div >
        <a href="{{ route('admin.learning-pathways.create') }}" class="btn add-btn">@lang('strings.backend.general.app_add_new')</a>

    </div>
</div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="table dt-select custom-teacher-table table-striped">
                    <thead>
                        <tr>
                            <th>@lang('Name')</th>
                            <th>@lang('Courses')</th>
                            <th>@lang('Description')</th>
                            <th>@lang('In Sequence')</th>
                            <th>@lang('strings.backend.general.actions')</th>
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@push('after-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="/js/pages/learning-pathway.js"></script>
    <script src="/js/helpers/confirm-modal.js"></script>
    <script src="/js/helpers/load-modal.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.6/Sortable.min.js"></script>
    <script src="/js/helpers/form-submit.js"></script>
@endpush
