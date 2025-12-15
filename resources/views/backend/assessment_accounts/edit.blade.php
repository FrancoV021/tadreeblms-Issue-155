@extends('backend.layouts.app')
@section('title', __('Assessment').' | '.app_name())

@section('content')
{{ html()->modelForm($assessment, 'PATCH', route('admin.assessment_accounts.update', $assessment->id))->class('form-horizontal')->acceptsFiles()->open() }}

<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('Edit Assessment Account')</h3>
        <div class="float-right">
            <a href="{{ route('admin.assessment_accounts.index') }}" class="btn btn-success">@lang('View Assessments')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    {{ html()->label(__('First Name'))->class('col-md-2 form-control-label')->for('first_name') }}

                    <div class="col-md-10">
                        {{ html()->text('first_name')
                                ->class('form-control')
                                ->placeholder(__('First Name'))
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                    </div>
                    <!--col-->
                </div>
                <!--form-group-->

                <div class="form-group row">
                    {{ html()->label(__('Last Name'))->class('col-md-2 form-control-label')->for('last_name') }}

                    <div class="col-md-10">
                        {{ html()->text('last_name')
                                ->class('form-control')
                                ->placeholder(__('Last Name'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                    </div>
                    <!--col-->
                </div>
                <!--form-group-->

                <div class="form-group row">
                    {{ html()->label(__('Email'))->class('col-md-2 form-control-label')->for('email') }}

                    <div class="col-md-10">
                        {{ html()->email('email')
                                ->class('form-control')
                                ->placeholder(__('Email'))
                                ->attributes(['maxlength'=> 191,'readonly'=>true])
                                ->required() }}
                    </div>
                    <!--col-->
                </div>
                <!--form-group-->

                <div class="form-group row">
                    {{ html()->label(__('Phone'))->class('col-md-2 form-control-label')->for('phone') }}

                    <div class="col-md-10">
                        {{ html()->text('phone')
                                ->class('form-control')
                                ->placeholder(__('Phone'))
                        }}
                    </div>
                    <!--col-->
                </div>
                <!--form-group-->
                <div class="form-group row">
                    {{ html()->label(__('Status'))->class('col-md-2 form-control-label')->for('active') }}
                    <div class="col-md-10">
                        {{ html()->label(html()->checkbox('')->name('active')
                                        ->checked(($assessment->active == 1) ? true : false)->class('switch-input')->value(($assessment->active == 1) ? 1 : 0)

                                    . '<span class="switch-label"></span><span class="switch-handle"></span>')
                                ->class('switch switch-lg switch-3d switch-primary')
                            }}
                    </div>

                </div>


                <div class="form-group row justify-content-center">
                    <div class="col-4">
                        {{ form_cancel(route('admin.assessment_accounts.index'), __('buttons.general.cancel')) }}
                        {{ form_submit(__('buttons.general.crud.update')) }}
                    </div>
                </div>
                <!--col-->
            </div>
        </div>
    </div>

</div>
{{ html()->closeModelForm() }}
@endsection
@push('after-scripts')
<script>
    $(document).on('change', '#payment_method', function() {
        if ($(this).val() === 'bank') {
            $('.paypal_details').hide();
            $('.bank_details').show();
        } else {
            $('.paypal_details').show();
            $('.bank_details').hide();
        }
    });
</script>
@endpush