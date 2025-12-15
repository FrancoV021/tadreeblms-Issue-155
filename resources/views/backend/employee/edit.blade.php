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
        <div>
<div
        class="d-flex justify-content-between align-items-center pb-3">
        <div class="">
            <h4 class="">Edit Trainee</h4>
        </div>
        <div>
            <a href="{{ route('admin.teachers.index') }}">

                <button
                    type="button"
                    class="add-btn">
                    View Trainee
                </button>

            </a>

        </div>
        
       
    </div>
        
        </div>
    <div class="card">
            
        <!-- <div class="card-header">
            <h3 class="page-title d-inline">Edit Trainee</h3>
            <div class="float-right">
                <a href="{{ route('admin.teachers.index') }}"
                   class="btn btn-success">View Trainee</a>
            </div>
        </div> -->
        <div class="card-body pt-0">
            <div class="row">
               
                    <div class="col-lg-6 col-sm-12 mt-3">
                        <div>

                            {{ html()->label(__('labels.backend.teachers.fields.first_name'))->class('form-control-label')->for('first_name') }}
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

                            {{ html()->label(__('First Name In Arabic'))->class(' form-control-label')->for('arabic_first_name') }}
                        </div>

                        <div class="">
                            <input class="form-control" type="text" name="arabic_first_name" placeholder="First Name" value="{{ $teacher->arabic_first_name  }}" maxlength="191" required="" autofocus="">
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="col-lg-6 col-sm-12 mt-3">
                        <div>

                            {{ html()->label(__('Last Name In Arabic'))->class(' form-control-label')->for('arabic_last_name') }}
                        </div>

                        <div class="">
                            <input class="form-control" type="text" name="arabic_last_name" placeholder="Last Name" value="{{ $teacher->arabic_last_name  }}" maxlength="191" required="" autofocus="">
                        </div><!--col-->
                    </div><!--form-group-->


 <div class="col-lg-6 col-sm-12 mt-3">
    <div>

        {{ html()->label('Employee Id')->class(' form-control-label')->for('last_name') }}
    </div>

                        <div class="">
                            <input class="form-control" type="text" name="emp_id" id="emp_id" placeholder="Employee Id" value="{{ $teacher->emp_id  }}"  required="" autofocus="">
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

                    {{-- <div class="form-group row">
                        {{ html()->label(__('labels.backend.teachers.fields.password'))->class('col-md-2 form-control-label')->for('password') }}

                        <div class="col-md-10">
                            <input class="form-control" type="password" name="password" id="password" placeholder="Password" maxlength="191" autofocus="">

                        </div><!--col-->
                    </div><!--form-group--> --}}

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
<div class="col-lg-12 col-sm-12 mt-4">

    <div class=" form-control-label mt-3" for="image">Uploaded Image</div>
    <div class="mt-2">
       <img src="{{ asset('public/uploads/employee/'.$teacher->avatar_location) }}" style="width: 100%;" >
    </div><!--col-->
</div>
                    </div>
                    <div class="col-lg-6 col-sm-12 mt-3">
                        <div class=" form-control-label" for="first_name">Select Department</div>

                        <div class=" mt-2 custom-select-wrapper">
                            <select name="department" class="form-control custom-select-box">
                                <option value=""> Select One </option>
                                @foreach($departments as $row)
                                    @if(isset($teacher->employee->department_details->id) && $row->id == $teacher->employee->department_details->id)
                                        <?php
                                        $sel = 'selected';
                                        ?>
                                    @else
                                        <?php
                                        $sel = '';
                                        ?>
                                    @endif
                                    <option <?php echo $sel?>  value="{{ $row->id }}"> {{ $row->title }} </option>
                                @endforeach
                            </select>
                             <span class="custom-select-icon">
        <i class="fa fa-chevron-down"></i>
    </span>
                        </div><!--col-->
                         <div class="col-lg-12 col-sm-12 mt-3 pl-0">
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
                    <div class="col-lg-12 col-sm-12 mt-3 pl-0">
                        <div>

                            {{ html()->label(__('Preferred Language'))->class('form-control-label')->for('Preferred Language') }}
                        </div>
                        <div class="">
                            <label class="radio-inline mr-3 mb-0">
                                <input type="radio" name="fav_lang" value="english" {{ $teacher->fav_lang == 'english'?'checked':'' }}> {{__('English')}}
                            </label>
                            <label class="radio-inline mr-3 mb-0">
                                <input type="radio" name="fav_lang" value="arabic" {{ $teacher->fav_lang == 'arabic'?'checked':'' }}> {{__('Arabic')}}
                            </label>
                        </div>
                    </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 mt-3">
                        <div class="form-control-label" for="first_name">Position</div>
                        <div class="mt-2">
                        {{-- <textarea class="form-control editor" placeholder="Position" name="position" type="text" id="position" style="height:100px;width:100%">{{ $new_positions->position }}</textarea> --}}
                        <select name="position" class="form-control">
                                <option value=""> Select One </option>
                            @foreach ($positions as $row)
                                <option @if($new_positions->position == $row->title) selected @endif value="{{ $row->title }}"> {{ $row->title }} </option>
                            @endforeach
                        </select>
                        </div><!--col-->
                    </div>
                    
                     <div class="col-lg-6 col-sm-12 mt-3">
                                            <div>
                    
                                                {{ html()->label(__('labels.backend.teachers.fields.status'))->class(' form-control-label')->for('active') }}
                                            </div>
                                            <div class="">
                                                {{ html()->label(html()->checkbox('')->name('active')
                                                            ->checked(($teacher->active == 1) ? true : false)->class('switch-input')->value(($teacher->active == 1) ? 1 : 0)
                    
                                                        . '<span class="switch-label"></span><span class="switch-handle"></span>')
                                                    ->class('switch switch-lg switch-3d switch-primary')
                                                }}
                                            </div>
                    
                                        </div>
                   

                    






                    <!-- <div class="form-group row justify-content-center">
                        <div class="col-4">
                            {{ form_cancel(route('admin.teachers.index'), __('buttons.general.cancel')) }}
                            {{ form_submit(__('buttons.general.crud.update')) }}
                        </div>
                    </div> -->
                  
                           <div class="col-12 d-flex justify-content-between mt-4">
                            <div class="">

                               <a href="{{ route('admin.teachers.index') }}">
                                <button class="cancel-btn" type="button">
                                    Cancel
                                </button>
                               </a>
                            </div>
                            <div>
                                <button type="submit" class="add-btn">
                                    Update
                                </button>

                                <!-- {{ form_submit(__('buttons.general.crud.create')) }} -->
                            </div>
                           </div>
                       
                    
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
    document.querySelectorAll('.custom-file-input').forEach(function(input) {
        input.addEventListener('change', function(e) {
            const label = input.nextElementSibling;
            const fileName = e.target.files.length > 0 ? e.target.files[0].name : 'Choose a file';
            label.innerHTML = '<i class="fa fa-upload mr-1"></i> ' + fileName;
        });
    });
</script>
@endpush