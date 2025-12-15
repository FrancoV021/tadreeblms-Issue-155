@extends('backend.layouts.app')
@section('title', 'Employee'.' | '.app_name())
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

    <form name="edit-employee" action="{{ route('admin.employee.update',$teacher->id) }}" method="post" enctype="multipart/form-data">
        @csrf()
        @php
        //dd($teacher);
        @endphp
        <div class="pb-3 d-flex justify-content-between align-items-center">
      <h4 >
          Edit Trainee
      </h4>
     
          <div class="">
               <a href="{{ route('admin.teachers.index') }}"
             class="btn btn-primary">View Trainee</a>

          </div>
     
  </div>
    <div class="card">
           
     
        <div class="card-body">
            <div class="row">
                
                    <div class="col-lg-6 col-sm-12 mt-3">
                        <div>

                            {{ html()->label(__('labels.backend.teachers.fields.first_name'))->class(' form-control-label')->for('first_name') }}
                        </div>

                        <div class="">
                            <input class="form-control" type="text" name="first_name" id="first_name" placeholder="First Name" value="{{ $teacher->first_name  }}" maxlength="191" required="" autofocus="">
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="col-lg-6 col-sm-12 mt-3">
                        <div>

                            {{ html()->label(__('labels.backend.teachers.fields.last_name'))->class(' form-control-label')->for('last_name') }}
                        </div>

                        <div class="">
                            <input class="form-control" type="text" name="last_name" id="last_name" placeholder="Last Name" value="{{ $teacher->last_name  }}" maxlength="191" required="" autofocus="">
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="col-lg-6 col-sm-12 mt-3">
                        <div>

                            {{ html()->label(__('labels.backend.teachers.fields.email'))->class(' form-control-label')->for('email') }}
                        </div>

                        <div class="">
                            <input class="form-control" type="email" name="email" id="email" placeholder="Email"  value="{{ $teacher->email  }}" readonly maxlength="191" required="" autofocus="">
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
<div class="col-lg-12 col-sm-12 mt-3 pl-0">
    <div class=" form-control-label mt-4" for="image">Uploaded Image</div>
    <div class="mt-2 " style="width: 100%;">
       <img src="{{ asset('public/uploads/employee/'.$teacher->avatar_location) }}"  >
    </div><!--col-->
</div>
                    </div>

                    <div class="col-lg-6 col-sm-12 mt-3">
                        <div class="form-control-div" for="first_name">Id Number</div>
                        <div class="mt-2">
                           <input type="text" name="id_number" class="form-control" placeholder="Id Number" value="{{ $teacher->id_number }}">
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12 mt-3">
                        <div class=" form-control-div" for="first_name">Classification Number</div>
                        <div class="mt-2">
                           <input type="text" class="form-control" name="class_number" placeholder="Classification Number" value="{{ $teacher->classfi_number }}">
                        </div>
                    </div>


                    <div class="col-lg-6 col-sm-12 mt-3">
                    <div class=" form-control-div">Nationality</div>
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

                    <!-- <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="first_name">Nationality</label>
                        <div class="col-md-10">
                           <input type="text" name="nationality" class="form-control" placeholder="Nationality" value="{{ $teacher->nationality }}">
                        </div>
                    </div> -->

                    <div class="col-lg-6 col-sm-12 mt-3">
                        <div class="form-control-div" for="first_name">Date of birth</div>
                        <div class="mt-2">
                           <input type="date" name="dob" class="form-control" placeholder="DOB" value="{{ $teacher->dob }}">
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12 mt-3">
                        <div class="form-control-div" for="first_name">Mobile phone</div>
                        <div class="mt-2">
                           <input type="text" name="mobile_number" class="form-control" placeholder="Mobile phone" value="{{ $teacher->phone }}">
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
                        <div>

                            {{ html()->label(__('labels.backend.teachers.fields.status'))->class('form-control-label')->for('active') }}
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
                   
                         <div class="col-12 mt-3">
                            <div class="d-flex justify-content-between">

                                <div class="mr-4">
    
                                    {{ form_cancel(route('admin.teachers.index'), __('buttons.general.cancel')) }}
                                </div>
                                <div>
    
                                    {{ form_submit(__('buttons.general.crud.update')) }}
                                </div>
                            </div>

                        </div>
                       
                  

                    <!-- <div class="form-group row justify-content-center">
                        <div class="col-4">
                            {{ form_cancel(route('admin.teachers.index'), __('buttons.general.cancel')) }}
                            {{ form_submit(__('buttons.general.crud.update')) }}
                        </div>
                    </div> -->
                    <!--col-->
                
            </div>
        </div>

    </div>
    </form>
@endsection
@push('after-scripts')
    <script>
        $(document).on('change', '#payment_method', function(){
            if($(this).val() === 'bank'){
                $('.paypal_details').hide();
                $('.bank_details').show();
            }else{
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