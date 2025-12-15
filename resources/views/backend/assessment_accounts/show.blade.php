@extends('backend.layouts.app')

@section('title', __('Assessment').' | '.app_name())
@push('after-styles')
<link rel="stylesheet" href="{{asset('assets/css/colors/switch.css')}}">
<style>
    table th {
        width: 20%;
    }
</style>
@endpush
@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="page-title d-inline mb-0">@lang('Assessment Account')</h3>
        <div class="float-right">
            <a href="{{ route('admin.assessment_accounts.index') }}" class="btn btn-success">@lang('View Assessments')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-striped">

                    <tr>
                        <th>@lang('labels.backend.access.users.tabs.content.overview.name')</th>
                        <td>{{ $assessment->first_name }} {{ $assessment->last_name }}</td>
                    </tr>

                    <tr>
                        <th>@lang('labels.backend.access.users.tabs.content.overview.email')</th>
                        <td>{{ $assessment->email }}</td>
                    </tr>

                    <tr>
                        <th>@lang('Phone')</th>
                        <td>{!! $assessment->phone !!}</td>
                    </tr>

                    <tr>
                        <th>@lang('labels.backend.access.users.tabs.content.overview.status')</th>
                        <td>
                            <label class="switch switch-lg switch-3d switch-primary">
                                <input class="switch-input" disabled type="checkbox" value="<?= $assessment->active == 1 ? 1 : 0 ?>" id="{{$assessment->id}}" <?= $assessment->active == 1 ? "checked" : "" ?>>
                                <span class="switch-label"></span><span class="switch-handle"></span>
                            </label>
                        </td>
                    </tr>
                </table>
            </div>
        </div><!-- Nav tabs -->
    </div>
</div>
@stop