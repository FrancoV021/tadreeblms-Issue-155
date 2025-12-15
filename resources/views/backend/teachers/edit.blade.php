@extends('backend.layouts.app')
@section('title', __('labels.backend.teachers.title').' | '.app_name())
@push('after-styles')
<link rel="stylesheet" href="{{asset('assets/css/colors/switch.css')}}">

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
{{ html()->modelForm($teacher, 'PATCH', route('admin.teachers.update', $teacher->id))->class('form-horizontal')->acceptsFiles()->open() }}
<div class="">
    <div
        class="d-flex justify-content-between align-items-center pb-3">
        <div class="grow">
            <h4 class="text-20">@lang('labels.backend.teachers.edit')</h4>
        </div>
        <div>
            <a href="{{ route('admin.teachers.index') }}">

                <button
                    type="button"
                    class="add-btn">
                    @lang('labels.backend.teachers.view')
                </button>

            </a>

        </div>


    </div>

    <div class="card">

        <div class="card-body">
            <div class="row">


                <div class="col-lg-6 col-sm-12 mt-3">
                    <div class="">Id Number</div>
                    <div class="mt-2">
                        <input class="form-control" type="text" id="id_number" name="id_number" value="{{$teacher->id_number}}" placeholder="Id Number" required>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-12 mt-3">
                    <!-- {{ html()->label(__('labels.backend.teachers.fields.first_name'))->class(' ')->for('first_name') }} -->
                    <div>
                        First Name
                    </div>

                    <div class="mt-2">
                        {{ html()->text('first_name')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.teachers.fields.first_name'))
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->

                <div class="col-lg-6 col-sm-12 mt-3">
                    <!-- {{ html()->label(__('labels.backend.teachers.fields.last_name'))->class('col-md-2 form-control-label')->for('last_name') }} -->
                    <div>
                        Last Name
                    </div>
                    <div class="mt-2">
                        {{ html()->text('last_name')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.teachers.fields.last_name'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                    </div><!--col-->
                </div><!--form-group-->

                <div class="col-lg-6 col-sm-12 mt-3">
                    <!-- {{ html()->label(__('labels.backend.teachers.fields.email'))->class('col-md-2 form-control-label')->for('email') }} -->
                    <div>
                        Email
                    </div>
                    <div class="mt-2">
                        {{ html()->email('email')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.teachers.fields.email'))
                                ->attributes(['maxlength'=> 191,'readonly'=>true])
                                ->required() }}
                    </div><!--col-->
                </div><!--form-group-->

                <div class="col-lg-6 col-sm-12 mt-3">
                    <div>
                        {{ html()->label(__('labels.backend.teachers.fields.password'))->class('form-control-label')->for('password') }}
                    </div>
                    <div class="position-relative">
                        {{ html()->password('password')
            ->class('form-control')
            ->id('password-field')
            ->placeholder(__('labels.backend.teachers.fields.password'))
            ->required() }}

                        <span class="password-toggle" onclick="togglePassword()" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                            <i class="fa fa-eye" style="color: #ccc;" id="toggle-icon"></i>
                        </span>
                    </div>
                </div>


                <div class="col-lg-6 col-sm-12 mt-3">
                    <div>
                        {{ html()->label(__('labels.backend.teachers.fields.image'))->class(' form-control-label')->for('image') }}
                    </div>

                    <div class="custom-file-upload-wrapper">
                        <input type="file" name="image" id="customFileInput" class="custom-file-input">
                        <label for="customFileInput" class="custom-file-label">
                            <i class="fa fa-upload mr-1"></i> Choose a file
                        </label>
                    </div>


                </div>
                <div class="col-lg-6 col-sm-12 mt-3">
                    <div>

                        {{ html()->label(__('labels.backend.general_settings.user_registration_settings.fields.gender'))->class('form-control-label')->for('gender') }}
                    </div>
                    <div class="">
                        <label class="radio-inline mr-3 mb-0">
                            <input type="radio" name="gender" value="male" {{ $teacher->gender == 'male'?'checked':'' }}> {{__('validation.attributes.frontend.male')}}
                        </label>
                        <label class="radio-inline mr-3 mb-0">
                            <input type="radio" name="gender" value="female" {{ $teacher->gender == 'female'?'checked':'' }}> {{__('validation.attributes.frontend.female')}}
                        </label>
                        <!-- <label class="radio-inline mr-3 mb-0">
                            <input type="radio" name="gender" value="other" {{ $teacher->gender == 'other'?'checked':'' }}> {{__('validation.attributes.frontend.other')}}
                        </label> -->
                    </div>
                </div>

                <div class="col-lg-6 col-sm-12 mt-3">
                    <div class="">Classification Number</div>
                    <div class="mt-2">
                        <input class="form-control" type="text" id="classfi_number" name="classfi_number" value="{{$teacher->classfi_number}}" placeholder="Classification Number">
                    </div>
                </div>

                <!-- <div class="col-lg-6 col-sm-12 mt-3">
                    <div class="">Nationality</div>
                    <div class="mt-2">
                        <select name="nationality" class="form-control">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ $teacher->nationality == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> -->
                <div class="col-lg-6 col-sm-12 mt-3">
                    <div>
                        Nationality
                    </div>
                    <div class="mt-2 custom-select-wrapper">
                        <select name="nationality" class="form-control custom-select-box">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ $teacher->nationality == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <span class="custom-select-icon">
                            <i class="fa fa-chevron-down"></i>
                        </span>
                    </div>

                </div>

                <div class="col-lg-6 col-sm-12 mt-3">
                    <div class="mb-2">
                        Cv Upload
                    </div>
                    <div class="custom-file-upload-wrapper">
                        <input type="file" name="image" id="customFileInput" class="custom-file-input">
                        <label for="customFileInput" class="custom-file-label">
                            <i class="fa fa-upload mr-1"></i> Choose a file
                        </label>
                    </div>
                </div>

                @php
                $teacherProfile = $teacher->teacherProfile?:'';
                $payment_details = $teacher->teacherProfile?json_decode($teacher->teacherProfile->payment_details):new stdClass();
                @endphp

                <div class="col-lg-6 col-sm-12 mt-3">
                    <div>

                        {{ html()->label(__('labels.teacher.facebook_link'))->class('form-control-label')->for('facebook_link') }}
                    </div>

                    <div class="">
                        {{ html()->text('facebook_link')
                                            ->class('form-control')
                                            ->value($teacherProfile->facebook_link)
                                            ->placeholder(__('labels.teacher.facebook_link')) }}
                    </div><!--col-->
                </div>

                <div class="col-lg-6 col-sm-12 mt-3">
                    <div>

                        {{ html()->label(__('labels.teacher.twitter_link'))->class(' form-control-label')->for('twitter_link') }}
                    </div>

                    <div class="">
                        {{ html()->text('twitter_link')
                                            ->class('form-control')
                                            ->value($teacherProfile->twitter_link)
                                            ->placeholder(__('labels.teacher.twitter_link')) }}

                    </div><!--col-->
                </div>

                <div class="col-lg-6 col-sm-12 mt-3">
                    <div>

                        {{ html()->label(__('labels.teacher.linkedin_link'))->class(' form-control-label')->for('linkedin_link') }}
                    </div>

                    <div class="">
                        {{ html()->text('linkedin_link')
                                            ->class('form-control')
                                            ->value($teacherProfile->linkedin_link)
                                            ->placeholder(__('labels.teacher.linkedin_link')) }}
                    </div><!--col-->
                    <div class="col-lg-6 col-sm-12 mt-3 pl-0">
                    <div>

                        {{ html()->label(__('labels.backend.teachers.fields.status'))->class(' form-control-label')->for('active') }}
                    </div>
                 <div class="custom-control custom-switch">
                <input type="checkbox" 
                       class="custom-control-input status-toggle" 
                       id="switch" 
                       data-id="" 
                       value="1">
                <label class="custom-control-label" for="switch"></label>
            </div>

                </div>
                </div>





                <div class="col-lg-6 col-sm-12 mt-3">
                    <div>

                        {{ html()->label(__('labels.teacher.description'))->class('form-control-label')->for('description') }}
                    </div>

                    <div class="">
                        {{ html()->textarea('description')
                                    ->class('form-control')
                                    ->style('height:100px')
                                    ->value($teacherProfile->description)
                                    ->placeholder(__('labels.teacher.description')) }}
                    </div>
                </div>

                


                <div class="col-lg-12 col-sm-12 mt-3">
                
                        <div class="d-flex justify-content-between">

                            <div class="mr-4">

                                {{ form_cancel(route('admin.teachers.index'), __('buttons.general.cancel')) }}


                            </div>
                            <div>
                                {{ form_submit(__('buttons.general.crud.update')) }}

                                <!-- {{ form_submit(__('buttons.general.crud.create')) }} -->
                            </div>
                        </div>

                    
                    <!-- <div class="col-12 text-right d-flex justify-content-end">
                            <div class="d-flex">

                                <div class="mr-4">
    
                                    {{ form_cancel(route('admin.teachers.index'), __('buttons.general.cancel')) }}
                                </div>
                                <div>
    
                                    {{ form_submit(__('buttons.general.crud.update')) }}
                                </div>
                            </div>

                        </div> -->
                    <!-- <div class="col-4">
                            {{ form_cancel(route('admin.teachers.index'), __('buttons.general.cancel')) }}
                            {{ form_submit(__('buttons.general.crud.update')) }}
                        </div> -->
                </div>

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
<script>
    function togglePassword() {
        var passwordField = document.getElementById("password-field");
        var icon = document.getElementById("toggle-icon");
        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
<script>
    document.querySelectorAll('.custom-file-input').forEach(function(input) {
        input.addEventListener('change', function(e) {
            const label = input.nextElementSibling;
            const fileName = e.target.files.length > 0 ? e.target.files[0].name : 'Choose a file';
            label.innerHTML = '<i class="fa fa-upload mr-1"></i> ' + fileName;
        });
    });
</script>
@endpush