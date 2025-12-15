@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.edit'))

@section('breadcrumb-links')
@include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
{{ html()->modelForm($user, 'PATCH', route('admin.auth.user.update', $user->id))->class('form-horizontal')->open() }}
<div class="pb-3 d-flex justify-content-between">
<h4 >
@lang('labels.backend.access.users.management')
<small class="text-muted ml-3">@lang('labels.backend.access.users.edit')</small>
</h4>
</div><!--col-->
<div class="card">
<div class="card-body">

<div class="row">
</div><!--row-->


<div class="row mt-4 mb-4">
<div class="col">
<div class="form-group row">
{{ html()->label(__('validation.attributes.backend.access.users.first_name'))->class('col-md-2 form-control-label')->for('first_name') }}

<div class="col-md-10">
{{ html()->text('first_name')
->class('form-control')
->placeholder(__('validation.attributes.backend.access.users.first_name'))
->attribute('maxlength', 191)
->required() }}
</div><!--col-->
</div><!--form-group-->

<div class="form-group row">
{{ html()->label(__('validation.attributes.backend.access.users.last_name'))->class('col-md-2 form-control-label')->for('last_name') }}

<div class="col-md-10">
{{ html()->text('last_name')
->class('form-control')
->placeholder(__('validation.attributes.backend.access.users.last_name'))
->attribute('maxlength', 191)
->required() }}
</div><!--col-->
</div><!--form-group-->

<div class="form-group row">
{{ html()->label(__('validation.attributes.backend.access.users.email'))->class('col-md-2 form-control-label')->for('email') }}

<div class="col-md-10">
{{ html()->email('email')
->class('form-control')
->placeholder(__('validation.attributes.backend.access.users.email'))
->attributes(['maxlength'=> 191,'readonly'=>true])
->required() }}
</div><!--col-->
</div><!--form-group-->

<div class="form-group row">
<div class="col-md-2">	
Type
</div>
<div class="col-md-10 mt-2 custom-select-wrapper">
<select class="form-control custom-select-box" name="employee_type">
	<option value="" @if($user->employee_type == '') selected="" @endif>General</option>
	<option value="internal" @if($user->employee_type == 'internal') selected="" @endif>Internal</option>
	<option value="external" @if($user->employee_type == 'external') selected="" @endif>External</option>
</select>
<span class="custom-select-icon" style="right: 23px;">
        <i class="fa fa-chevron-down"></i>
    </span>
</div><!--col-->
</div><!--form-group-->

<div class="form-group row">
{{ html()->label('Abilities')->class('col-md-2 form-control-label') }}

<div class="table-responsive col-md-10">
<table class="table">
<thead>
<tr>
<th>@lang('labels.backend.access.users.table.roles')</th>
<!-- <th>@lang('labels.backend.access.users.table.permissions')</th> -->
</tr>
</thead>
<tbody>
<tr>
<td>
@if($roles->count())
@foreach($roles as $role)
@if($role->id == 1)
<div class="card">
<div class="card-header">
<div class="checkbox d-flex align-items-center">
{{ html()->label(
html()->checkbox('roles[]', in_array($role->name, $userRoles), $role->name)
->class('switch-input')
->id('role-'.$role->id)
. '<span class="switch-slider" data-checked="on" data-unchecked="off"></span>')
->class('switch switch-label switch-pill switch-primary mr-2')
->for('role-'.$role->id) }}
{{ html()->label(ucwords($role->name))->for('role-'.$role->id) }}
</div>
</div>
<div class="card-body">
@if($role->id != 1)
@if($role->permissions->count())
@foreach($role->permissions as $permission)
<i class="fas fa-dot-circle"></i> {{ ucwords($permission->name) }}
@endforeach
@else
@lang('labels.general.none')
@endif
@else
@lang('labels.backend.access.users.all_permissions')
@endif
</div>
</div><!--card-->
@endif
@endforeach
@endif
</td>
<td  style="display: none">
@if($permissions->count())
@foreach($permissions as $permission)
<div class="checkbox d-flex align-items-center">
{{ html()->label(
html()->checkbox('permissions[]', in_array($permission->name, $userPermissions), $permission->name)
->class('switch-input')
->id('permission-'.$permission->id)
. '<span class="switch-slider" data-checked="on" data-unchecked="off"></span>')
->class('switch switch-label switch-pill switch-primary mr-2')
->for('permission-'.$permission->id) }}
{{ html()->label(ucwords($permission->name))->for('permission-'.$permission->id) }}
</div>
@endforeach
@endif
</td>
</tr>
</tbody>
</table>
</div><!--col-->
</div><!--form-group-->
</div><!--col-->
</div><!--row-->
<div class="row">
	<div class="col-12 d-flex justify-content-between">

		<div class="">
		{{ form_cancel(route('admin.auth.user.index'), __('buttons.general.cancel')) }}
		</div><!--col-->
		<div class="">
		{{ form_submit(__('buttons.general.crud.update')) }}
		</div><!--row-->
	</div>

</div>
</div><!--card-body-->


<!--row-->

</div><!--card-->
{{ html()->closeModelForm() }}
@endsection
