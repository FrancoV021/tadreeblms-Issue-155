@extends('backend.layouts.app')
@section('title', __('labels.backend.categories.title').' | '.app_name())

@push('after-styles')
    <link rel="stylesheet" href="{{asset('plugins/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css')}}"/>
@endpush
@section('content')

<div class="pb-3 d-flex justify-content-between align-items-center">
    <h4>
        @lang('labels.backend.categories.create')
    </h4>
    <div class="">
        <a href="{{ route('admin.categories.index') }}"
            class="btn add-btn">@lang('labels.backend.categories.view')</a>
    </div>
</div>
    <div class="card">
        <!-- <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.categories.create')</h3>
            <div class="float-right">
                <a href="{{ route('admin.categories.index') }}"
                   class="btn btn-success">@lang('labels.backend.categories.view')</a>

            </div>
        </div> -->
        <div class="card-body">

            <div class="row">
                <div class="col-12">

                    {!! Form::open(['method' => 'POST', 'id' => 'addcategory', 'files' => true,]) !!}

                    <div class="row">
                        <div class="col-12 col-lg-4 form-group">
                            {!! Form::label('title', trans('labels.backend.categories.fields.name').' *', ['class' => 'control-label']) !!}
                            {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.categories.fields.name'), 'required' => false]) !!}

                        </div>


                        <!-- <div class="col-12 col-lg-2  form-group">

                                {!! Form::label('icon',  trans('labels.backend.categories.fields.select_icon'), ['class' => 'control-label  d-block']) !!}
                                <button class="btn  btn-block btn-default border" id="icon" name="icon"></button>

                        </div> -->

                        <div class="col-lg-3 col-md-3 form-group mt-4 d-flex align-items-center">

                            {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'add-btn']) !!}
                        </div>
                    </div>

                    {!! Form::close() !!}


                </div>
                <input type="hidden" id="teacher" value="{{ route('admin.categories.index') }}">
                <input type="hidden" id="new-assisment" value="{{ route('admin.courses.create') }}">
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script src="{{asset('plugins/bootstrap-iconpicker/js/bootstrap-iconpicker.bundle.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('#icon').iconpicker({
                cols: 10,
                icon: 'fas fa-bomb',
                iconset: 'fontawesome5',
                labelHeader: '{0} of {1} pages',
                labelFooter: '{0} - {1} of {2} icons',
                placement: 'bottom', // Only in button tag
                rows: 5,
                search: true,
                searchText: 'Search',
                selectedClass: 'btn-success',
                unselectedClass: ''
            });


        })

    </script>

<script>

$(document).on('submit', '#addcategory', function (e) {
    e.preventDefault();
    hrefurl=$(location).attr("href");
  last_part=hrefurl.substr(hrefurl.lastIndexOf('/') + 8)
//   alert(last_part)
    // setTimeout(() => {
        let data = $('#addcategory').serialize();
        let url = '{{route('admin.categories.store')}}'
        var redirect_url=$("#teacher").val()
        var redirect_url_assi=$("#new-assisment").val()
    $.ajax({
            type: 'POST',
            url: url,
            data: data,
            datatype: "json",
            success: function (res) {
            console.log(res)
            // alert(last_part)
                if(last_part == 'create'){
                    window.location.href = redirect_url_assi;
                    return;
                }
                else{
                    window.location.href = redirect_url;
                    return;
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr)
                res= JSON.parse(xhr.responseText)
               alert(res.errors.email[0]);
            }
        })
    // }, 100);
})
</script>

@endpush
