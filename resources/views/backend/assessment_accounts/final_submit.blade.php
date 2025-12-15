@extends('backend.layouts.app')

@section('title', __('Final Submit').' | '.app_name())

@section('content')
<form method="POST" action="{{ route('admin.assessment_accounts.final-submit-store') }}" enctype="multipart/form-data" class="form-horizontal">
    @csrf

    <div class="card">

        <div class="card-header">
            <h3 class="page-title d-inline mb-0">Final Page</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <p>Do you want to submit this final page?</p>
            </div>
        </div>

        <div class="form-group p-3">
            <div class="col-4">
                <a href="{{ route('admin.assessment_accounts.index') }}" class="btn btn-danger">
                    {{ __('buttons.general.cancel') }}
                </a>

                <button type="submit" class="btn btn-success">
                    Submit
                </button>
            </div>
        </div>

    </div>
</form>

@stop