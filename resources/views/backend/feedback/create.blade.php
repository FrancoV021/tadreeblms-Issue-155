@extends('backend.layouts.app')
@section('title', __('labels.backend.courses.title').' | '.app_name())

@section('content')

{!! Form::open(['method' => 'POST', 'route' => ['admin.feedback.store'], 'files' => true]) !!}

<div class="card">
    <div class="card-header">
        <h3 class="page-title float-left">Feedback Question</h3>
        <div class="float-right">
            <a href="{{ route('admin.feedback_question.index') }}" class="btn btn-success">Submit</a>
        </div>
    </div>

    <div class="card-body">
        @if (Auth::user()->isAdmin())   
        <div class="row">

            <div class="col-12 form-group">
                {!! Form::label('question', trans('labels.backend.courses.fields.description'), ['class' => 'control-label']) !!}
                {!! Form::textarea('question', old('question'), ['class' => 'form-control editor', 'placeholder' => trans('labels.backend.courses.fields.description')]) !!}

            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-12 text-center form-group">
                {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn btn-lg btn-danger']) !!}
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@stop

@push('after-scripts')
<script type="text/javascript" src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript" src="{{asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
<script type="text/javascript">
$(function() {
    $('#your_textarea').ckeditor({
        toolbar: 'Full',
        enterMode : CKEDITOR.ENTER_BR,
        shiftEnterMode: CKEDITOR.ENTER_P
    });
});
</script>
<script src="{{asset('/vendor/laravel-filemanager/js/lfm.js')}}"></script>
<script>
    $('.editor').each(function() {
        CKEDITOR.replace($(this).attr('id'), {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}',
            extraPlugins: 'smiley,lineutils,widget,codesnippet,prism,flash,colorbutton,colordialog',
        });
    });
</script>
@endpush