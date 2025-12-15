@extends('backend.layouts.app')
@section('title', __('labels.backend.courses.title') . ' | ' . app_name())
@push('after-styles')
<style>
      .select2-container--default .select2-selection--single .select2-selection__arrow {
    display: none !important;
}
   .select2-container .select2-search--inline .select2-search__field {
    box-sizing: border-box;
    border: none;
    font-size: 100%;
    margin-top: 5px;
    padding-left: 8px;
}

.select2-container--default .select2-selection--multiple:focus {
    outline: none !important;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5) !important;
    border-color: #007bff !important;
}
.select2-container--default.select2-container--focus .select2-selection--multiple {
     outline: none !important;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5) !important;
    border-color: #007bff !important;
}
.select2-container--default .select2-selection--multiple{
    border: 1px solid #ccc !important;
}

.select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow b{
    display: none;
}
.select2-container .select2-selection--single .select2-selection__rendered {
    display: block;
    padding-left: 10px;
    padding-right: 20px;
    padding-top: 3px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 34px;
    user-select: none;
    -webkit-user-select: none;
}
</style>

@endpush

@section('content')

    {!! Form::model($course, ['method' => 'PUT', 'route' => ['admin.courses.update', $course->id], 'files' => true]) !!}

    <div class="pb-3 d-flex justify-content-between align-items-center">
        <h4>
            @lang('labels.backend.courses.edit')
        </h4>
        <div class="">
            <a href="{{ route('admin.courses.index') }}" class="add-btn">@lang('labels.backend.courses.view')</a>
        </div>
      
    </div>
    <div class="card">
        <!-- <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.courses.edit')</h3>
            <div class="float-right">
                <a href="{{ route('admin.courses.index') }}" class="btn btn-success">@lang('labels.backend.courses.view')</a>
            </div>
        </div> -->

        <div class="card-body">

            @if (Auth::user()->isAdmin())
                <div class="row">

                    <div class="col-lg-10 col-md-12 form-group">
                        {!! Form::label('teachers', trans('labels.backend.courses.fields.teachers'), ['class' => 'control-label']) !!}
                        <div class="custom-select-wrapper">

                            {!! Form::select(
                                'teachers[]',
                                $teachers,
                                old('teachers') ? old('teachers') : $course->teachers->pluck('id')->toArray(),
                                ['class' => 'form-control custom-select-box select2 js-example-placeholder-multiple', 'multiple' => 'multiple', 'required' => true],
                            ) !!}
                            <span class="custom-select-icon" style="right: 10px;">
                <i class="fa fa-chevron-down"></i>
            </span>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-12 d-flex form-group flex-column">
                        OR <a target="_blank" class="btn btn-primary mt-auto"
                            href="{{ route('admin.teachers.create') }}">{{ trans('labels.backend.courses.add_teachers') }}</a>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-10 col-md-12 form-group">
                    {!! Form::label('category_id', trans('labels.backend.courses.fields.category'), ['class' => 'control-label']) !!}
                    <div class="custom-select-wrapper">

                        {!! Form::select('category_id', $categories, old('category_id'), [
                            'class' => 'form-control custom-select-box select2 js-example-placeholder-single',
                            'multiple' => false,
                            'required' => true,
                        ]) !!}
                        <span class="custom-select-icon" style="right: 10px;">
            <i class="fa fa-chevron-down"></i>
        </span>
                    </div>
                </div>
                <div class="col-lg-2 col-md-12 d-flex form-group flex-column">
                    OR <a target="_blank" class="btn btn-primary mt-auto"
                        href="{{ route('admin.categories.index') . '?create' }}">{{ trans('labels.backend.courses.add_categories') }}</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-4 form-group">
                    {!! Form::label('course_code', 'Course Code' . ' *', ['class' => 'control-label']) !!}
                    {!! Form::text('course_code', old('course_code'), [
                        'class' => 'form-control',
                        'placeholder' => 'Course code',
                        'required' => false,
                    ]) !!}
                </div>
                <div class="col-12 col-lg-4 form-group">
                    {!! Form::label('title', trans('labels.backend.courses.fields.title') . ' *', ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                </div>
                <div class="col-12 col-lg-4 form-group">
                    {!! Form::label('arabic_title', trans('Title In Arabic') . ' *', ['class' => 'control-label']) !!}
                    {!! Form::text('arabic_title', old('arabic_title'), [
                        'class' => 'form-control',
                        'placeholder' => trans('Arabic Title'),
                    ]) !!}

                </div>
                <div class="col-12 col-lg-4 form-group">
                    {!! Form::label('slug', trans('labels.backend.courses.fields.slug'), ['class' => 'control-label']) !!}
                    {!! Form::text('slug', old('slug'), [
                        'class' => 'form-control',
                        'placeholder' => trans('labels.backend.courses.slug_placeholder'),
                    ]) !!}
                </div>
                <div class="col-12 col-lg-4 form-group">
                    {!! Form::label('slug', trans('Course Language'), ['class' => 'control-label']) !!}
                    <div class="custom-select-wrapper">

                        <select name="course_lang" class="form-control custom-select-box">
                            <option @if($course->course_lang == 'english') selected @endif value="english">English</option>
                            <option @if($course->course_lang == 'arabic') selected @endif value="arabic">Arabic</option>
                        </select>
                        <span class="custom-select-icon" style="right: 10px;">
            <i class="fa fa-chevron-down"></i>
        </span>
                    </div>
                </div>

            </div>

            @if (Auth::user()->isAdmin())
                <div class="row">
                    <div class="col-12 form-group">
                        {!! Form::label('internal_students', trans('labels.backend.courses.fields.internal_students'), [
                            'class' => 'control-label',
                        ]) !!}
                        <div class="custom-select-wrapper">

                            {!! Form::select(
                                'internalStudents[]',
                                $internalStudents,
                                old('internalStudents') ? old('internalStudents') : $already_assigned_internal_users,
                                [
                                    'class' => 'form-control custom-select-box select2 js-example-internal-student-placeholder-multiple',
                                    'multiple' => 'multiple',
                                    'required' => false,
                                ],
                            ) !!}
                            <span class="custom-select-icon" style="right: 10px;">
            <i class="fa fa-chevron-down"></i>
        </span>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('description', trans('labels.backend.courses.fields.description'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('description', old('description'), [
                        'class' => 'form-control editor',
                        'placeholder' => trans('labels.backend.courses.fields.description'),
                    ]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-4 form-group">
                    {!! Form::label('price', trans('labels.backend.courses.fields.price') . ' (in ' . $appCurrency['symbol'] . ')', [
                        'class' => 'control-label',
                    ]) !!}
                    {!! Form::number('price', old('price'), [
                        'class' => 'form-control',
                        'placeholder' => trans('labels.backend.courses.fields.price'),
                        'step' => 'any',
                        'pattern' => '[0-9]',
                    ]) !!}
                </div>
                <div class="col-lg-4 col-md-12">
                    <label for="control-label">@lang('Minimum percentage required to qualify')</label>
                    <input type="number" name="marks_required" class="form-control" value="{{ $course->marks_required }}">
                </div>
                <!--div class="col-12 col-lg-4 form-group">
                            {!! Form::label(
                                'strike',
                                trans('labels.backend.courses.fields.strike') . ' (in ' . $appCurrency['symbol'] . ')',
                                ['class' => 'control-label'],
                            ) !!}
                            {!! Form::number('strike', old('strike'), [
                                'class' => 'form-control',
                                'placeholder' => trans('labels.backend.courses.fields.strike'),
                                'step' => 'any',
                                'pattern' => '[0-9]',
                            ]) !!}
                        </div-->
                <div class="col-md-12 col-lg-4 form-group">

                    {!! Form::label('course_image', trans('labels.backend.courses.fields.course_image'), [
                        'class' => 'control-label',
                        'accept' => 'image/jpeg,image/gif,image/png',
                    ]) !!}
                    <!-- {!! Form::file('course_image', ['class' => 'form-control']) !!}
                    {!! Form::hidden('course_image_max_size', 8) !!}
                    {!! Form::hidden('course_image_max_width', 4000) !!}
                    {!! Form::hidden('course_image_max_height', 4000) !!} -->
                     <div class="custom-file-upload-wrapper">
    <input type="file" name="course_image" id="customFileInput" class="custom-file-input">
    <label for="customFileInput" class="custom-file-label">
        <i class="fa fa-upload mr-1"></i> Choose a file
    </label>
</div>
                    @if ($course->course_image)
                        <a href="{{ $course->course_image }}" target="_blank"><img
                                height="50px" src="{{  $course->course_image }}"
                                class="mt-4"></a>
                    @endif
                </div>
                <div class="col-12 col-lg-4 form-group">
                    {!! Form::label('start_date', trans('labels.backend.courses.fields.start_date') . ' (yyyy-mm-dd)', [
                        'class' => 'control-label',
                    ]) !!}
                    {!! Form::text('start_date', old('start_date'), [
                        'class' => 'form-control date',
                        'pattern' =>
                            '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))',
                        'placeholder' => trans('labels.backend.courses.fields.start_date') . ' (Ex . 2019-01-01)',
                    ]) !!}
                    <p class="help-block"></p>
                    @if ($errors->has('start_date'))
                        <p class="help-block">
                            {{ $errors->first('start_date') }}
                        </p>
                    @endif
                </div>
                @if (Auth::user()->isAdmin())
                    <div class="col-12 col-lg-4 form-group">
                        {!! Form::label('expire_at', trans('labels.backend.courses.fields.expire_at') . ' (yyyy-mm-dd)', [
                            'class' => 'control-label',
                        ]) !!}
                        {!! Form::text('expire_at', old('expire_at'), [
                            'class' => 'form-control date',
                            'pattern' =>
                                '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))',
                            'placeholder' => trans('labels.backend.courses.fields.expire_at') . ' (Ex . 2019-01-01)',
                            'autocomplete' => 'off',
                        ]) !!}
                        <p class="help-block"></p>
                        @if ($errors->has('expire_at'))
                            <p class="help-block">
                                {{ $errors->first('expire_at') }}
                            </p>
                        @endif
                    </div>
                @endif


            </div>
            <div class="row">
                <label class="col-md-2 form-control-label" for="first_name">Select Department</label>

                <div class="col-md-10">
                    <div class="custom-select-wrapper">

                        <select name="department_id" class="form-control custom-select-box">
                            <option value=""> Select One </option>
                            @foreach ($departments as $row)
                                @if (isset($course->department_id) && $row->id == $course->department_id)
                                    <?php
                                    $sel = 'selected';
                                    ?>
                                @else
                                    <?php
                                    $sel = '';
                                    ?>
                                @endif
                                <option <?php echo $sel; ?> value="{{ $row->id }}"> {{ $row->title }} </option>
                            @endforeach
                        </select>
                        <span class="custom-select-icon" style="right: 10px;">
            <i class="fa fa-chevron-down"></i>
        </span>
                    </div>
                </div>
                <!--col-->

                
            </div>
            <div class="row mt-3">
                <div class="col-md-12 form-group">
                    <input class="course-type" @if($course->is_online == 'Online') checked @endif type="radio" checked name="course_type" value="Online" /> E-Learning
                    <input class="course-type ml-3" @if($course->is_online == 'Offline') checked @endif type="radio" name="course_type" value="Offline" /> Live-Online
                    <input class="course-type ml-3" @if($course->is_online == 'Live-Classroom') checked @endif type="radio" name="course_type" value="Live-Classroom" /> Live-Classroom
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    {!! Form::label('add_video', trans('labels.backend.lessons.fields.add_video'), ['class' => 'control-label']) !!}
                    <div class="custom-select-wrapper mb-3">

                        {!! Form::select(
                            'media_type',
                            ['youtube' => 'Youtube', 'vimeo' => 'Vimeo', 'upload' => 'Upload', 'embed' => 'Embed'],
                            $course->mediavideo ? $course->mediavideo->type : null,
                            ['class' => 'form-control custom-select-box', 'placeholder' => 'Select One', 'id' => 'media_type'],
                        ) !!}
                        <span class="custom-select-icon" style="right: 10px;">
            <i class="fa fa-chevron-down"></i>
        </span>
                    </div>


                    {!! Form::text('video', $course->mediavideo ? $course->mediavideo->url : null, [
                        'class' => 'form-control mt-3 d-none',
                        'placeholder' => trans('labels.backend.lessons.enter_video_url'),
                        'id' => 'video',
                    ]) !!}

                    {!! Form::file('video_file', [
                        'class' => 'form-control mt-3 d-none',
                        'placeholder' => trans('labels.backend.lessons.enter_video_url'),
                        'id' => 'video_file',
                        'accept' => 'video/mp4',
                    ]) !!}
      
                    <input type="hidden" name="old_video_file"
                        value="{{ $course->mediavideo && $course->mediavideo->type == 'upload' ? $course->mediavideo->url : '' }}">
                    @if ($course->mediavideo != null)
                        <div class="form-group">
                            <a href="#" data-media-id="{{ $course->mediaVideo->id }}"
                                class="btn btn-xs btn-danger my-3 delete remove-file">@lang('labels.backend.lessons.remove')</a>
                        </div>
                    @endif



                    @if ($course->mediavideo && $course->mediavideo->type == 'upload')
                        <video width="300" class="mt-2 d-none video-player" controls>
                            <source
                                src="{{ $course->mediavideo && $course->mediavideo->type == 'upload' ? $course->mediavideo->url : '' }}"
                                type="video/mp4">
                            Your browser does not support HTML5 video.
                        </video>
                    @endif

                    @lang('labels.backend.lessons.video_guide')
                </div>
            </div>

            <div class="row">
                <div class="col-12 form-group">
                    <div class="checkbox d-inline mr-4">
                        {!! Form::hidden('published', 0) !!}
                        {!! Form::checkbox('published', 1, old('published'), []) !!}
                        {!! Form::label('published', trans('labels.backend.courses.fields.published'), [
                            'class' => 'checkbox control-label font-weight-bold',
                        ]) !!}
                    </div>

                    @if (Auth::user()->isAdmin())
                        <div class="checkbox d-inline mr-4">
                            {!! Form::hidden('featured', 0) !!}
                            {!! Form::checkbox('featured', 1, old('featured'), []) !!}
                            {!! Form::label('featured', trans('labels.backend.courses.fields.featured'), [
                                'class' => 'checkbox control-label font-weight-bold',
                            ]) !!}
                        </div>

                        <div class="checkbox d-inline mr-4">
                            {!! Form::hidden('trending', 0) !!}
                            {!! Form::checkbox('trending', 1, old('trending'), []) !!}
                            {!! Form::label('trending', trans('labels.backend.courses.fields.trending'), [
                                'class' => 'checkbox control-label font-weight-bold',
                            ]) !!}
                        </div>

                        <div class="checkbox d-inline mr-4">
                            {!! Form::hidden('popular', 0) !!}
                            {!! Form::checkbox('popular', 1, old('popular'), []) !!}
                            {!! Form::label('popular', trans('labels.backend.courses.fields.popular'), [
                                'class' => 'checkbox control-label font-weight-bold',
                            ]) !!}
                        </div>

                        <div class="checkbox d-inline mr-4">
                            {!! Form::hidden('cms', 0) !!}
                            {!! Form::checkbox('cms', 1, old('cms'), []) !!}
                            {!! Form::label('cms', trans('CME'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                        </div>
                    @endif
                    <div class="checkbox d-inline mr-4">
                        {!! Form::hidden('free', 0) !!}
                        {!! Form::checkbox('free', 1, old('free'), []) !!}
                        {!! Form::label('free', trans('labels.backend.courses.fields.free'), [
                            'class' => 'checkbox control-label font-weight-bold',
                        ]) !!}
                    </div>

                </div>
            </div>

            <!--div class="row">
                        <div class="col-12 form-group">
                            {!! Form::label('meta_title', trans('labels.backend.courses.fields.meta_title'), ['class' => 'control-label']) !!}
                            {!! Form::text('meta_title', old('meta_title'), [
                                'class' => 'form-control',
                                'placeholder' => trans('labels.backend.courses.fields.meta_title'),
                            ]) !!}

                        </div>
                        <div class="col-12 form-group">
                            {!! Form::label('meta_description', trans('labels.backend.courses.fields.meta_description'), [
                                'class' => 'control-label',
                            ]) !!}
                            {!! Form::textarea('meta_description', old('meta_description'), [
                                'class' => 'form-control',
                                'placeholder' => trans('labels.backend.courses.fields.meta_description'),
                            ]) !!}
                        </div>
                        <div class="col-12 form-group">
                            {!! Form::label('meta_keywords', trans('labels.backend.courses.fields.meta_keywords'), [
                                'class' => 'control-label',
                            ]) !!}
                            {!! Form::textarea('meta_keywords', old('meta_keywords'), [
                                'class' => 'form-control',
                                'placeholder' => trans('labels.backend.courses.fields.meta_keywords'),
                            ]) !!}
                        </div>

                    </div-->

            <div class="row">
                <div class="col-12  text-right form-group ">
                    {!! Form::submit(trans('strings.backend.general.app_update'), ['class' => 'add-btn']) !!}
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@stop

@push('after-scripts')
    <script type="text/javascript" src="{{ asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('/vendor/laravel-filemanager/js/lfm.js') }}"></script>
    <script>
        $('.editor').each(function() {

            CKEDITOR.replace($(this).attr('id'), {
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}',
                extraPlugins: 'smiley,lineutils,widget,codesnippet,prism,flash,colorbutton,colordialog',
            });

        });

        $(document).ready(function() {
            $('#start_date').datepicker({
                autoclose: true,
                dateFormat: "{{ config('app.date_format_js') }}"
            });
            var dateToday = new Date();
            $('#expire_at').datepicker({
                autoclose: true,
                minDate: dateToday,
                dateFormat: "{{ config('app.date_format_js') }}"
            });

            $(".js-example-placeholder-single").select2({
                placeholder: "{{ trans('labels.backend.courses.select_category') }}",
            });

            $(".js-example-placeholder-multiple").select2({
                placeholder: "{{ trans('labels.backend.courses.select_teachers') }}",
            });
        });
        $(document).on('change', 'input[type="file"]', function() {
            var $this = $(this);
            $(this.files).each(function(key, value) {
                // if (value.size > 50000000) {
                //     alert('"' + value.name + '"' + 'exceeds limit of maximum file upload size')
                //     $this.val("");
                // }
            })
        });

        $(document).ready(function() {
            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                var parent = $(this).parent('.form-group');
                var confirmation = confirm("{{ trans('strings.backend.general.are_you_sure') }}")
                if (confirmation) {
                    var media_id = $(this).data('media-id');
                    $.post("{{ route('admin.media.destroy') }}", {
                            media_id: media_id,
                            _token: '{{ csrf_token() }}'
                        },
                        function(data, status) {
                            if (data.success) {
                                parent.remove();
                                $('#video').val('').addClass('d-none').attr('required', false);
                                $('#video_file').attr('required', false);
                                $('#media_type').val('');
                                @if ($course->mediavideo && $course->mediavideo->type == 'upload')
                                    $('.video-player').addClass('d-none');
                                    $('.video-player').empty();
                                @endif


                            } else {
                                alert('Something Went Wrong')
                            }
                        });
                }
            })
        });


        @if ($course->mediavideo)
            @if ($course->mediavideo->type != 'upload')
                $('#video').removeClass('d-none').attr('required', true);
                $('#video_file').addClass('d-none').attr('required', false);
                $('.video-player').addClass('d-none');
            @elseif ($course->mediavideo->type == 'upload')
                $('#video').addClass('d-none').attr('required', false);
                $('#video_file').removeClass('d-none').attr('required', false);
                $('.video-player').removeClass('d-none');
            @else
                $('.video-player').addClass('d-none');
                $('#video_file').addClass('d-none').attr('required', false);
                $('#video').addClass('d-none').attr('required', false);
            @endif
        @endif

        $(document).on('change', '#media_type', function() {
            if ($(this).val()) {
                if ($(this).val() != 'upload') {
                    $('#video').removeClass('d-none').attr('required', true);
                    $('#video_file').addClass('d-none').attr('required', false);
                    $('.video-player').addClass('d-none')
                } else if ($(this).val() == 'upload') {
                    $('#video').addClass('d-none').attr('required', false);
                    $('#video_file').removeClass('d-none').attr('required', true);
                    $('.video-player').removeClass('d-none')
                }
            } else {
                $('#video_file').addClass('d-none').attr('required', false);
                $('#video').addClass('d-none').attr('required', false)
            }
        })
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
