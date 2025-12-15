@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', __('Assign Learning Pathways') . ' | ' . app_name())
@push('after-styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('Assign Learning Pathways')</h3>
            <div class="float-right">
                <a href="{{ route('admin.assign-learning-pathways.create') }}" class="btn btn-success">@lang('strings.backend.general.app_add_new')</a>

            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="assign-learning-pathways-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>@lang('Learning Pathway Name')</th>
                            <th>@lang('Users Assigned')</th>
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
    <script src="/js/pages/assign-learning-pathway.js"></script>
    <script src="/js/helpers/confirm-modal.js"></script>
@endpush
