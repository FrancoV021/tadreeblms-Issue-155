@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.deactivated'))

@push('after-styles')
<link rel="stylesheet" href="{{asset('assets/css/colors/switch.css')}}">
<style>
    /* #myTable {
        table-layout: fixed !important;
        width: 100% !important;
    } */

    .dropdown-item {
        border-bottom: none;
    }
</style>

@endpush
@section('breadcrumb-links')
@include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="pb-3">
    <h4 class="">
        @lang('labels.backend.access.users.management')
        <small class="text-muted ml-3">@lang('labels.backend.access.users.deactivated')</small>
    </h4>
</div><!--col-->
<div class="card">
    <div class="card-body">


        <div class="row ">
            <div class="col">
                <div class="table-responsive">
                    <table class="table custom-teacher-table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th>@lang('labels.backend.access.users.table.last_name')</th>
                                <th>@lang('labels.backend.access.users.table.first_name')</th>
                                <th>@lang('labels.backend.access.users.table.email')</th>
                                <th>@lang('labels.backend.access.users.table.confirmed')</th>
                                <th>@lang('labels.backend.access.users.table.roles')</th>
                                <th>@lang('labels.backend.access.users.table.other_permissions')</th>
                                <th>@lang('labels.backend.access.users.table.social')</th>
                                <th>@lang('labels.backend.access.users.table.last_updated')</th>
                                <th>@lang('labels.general.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($users->count())
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{!! $user->confirmed_label !!}</td>
                                <td>{!! $user->roles_label !!}</td>
                                <td>{!! $user->permissions_label !!}</td>
                                <td>{!! $user->social_buttons !!}</td>
                                <td>{{ $user->updated_at->diffForHumans() }}</td>
                                <td>{!! $user->action_buttons !!}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="9">
                                    <p class="text-center">@lang('strings.backend.access.users.no_deactivated')</p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    {!! $users->total() !!} {{ trans_choice('labels.backend.access.users.table.total', $users->total()) }}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $users->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
