@extends('frontend.layouts.app' . config('theme_layout'))

@section('title', __('Request Course') . app_name())

@push('after-styles')
    <style>
        .my-alert {
            position: absolute;
            z-index: 10;
            left: 0;
            right: 0;
            top: 25%;
            width: 50%;
            margin: auto;
            display: inline-block;
        }

        @media screen and (max-width: 1200px) {
            .container .row {
                margin: 0rem 0rem;
            }
        }

        @media screen and (max-width: 767px) {
            .contact-info {
                margin-top: 0.6rem;
            }
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet" />
@endpush

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade my-alert show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{{ session('message') }}</strong>
        </div>
    @endif

    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold">{{ env('APP_NAME') }} / <span> @lang('Request Course')</span></h2>
                </div>
            </div>
        </div>
    </section>
    <section id="contact-form" class="contact-form-area_3 contact-page-version">
        <div class="container">
            <div class="section-title mb-4 headline text-center">
                <h4>@lang('Fill Out The Following Information To Book And Our Team Will Contact You')</h4>
            </div>

            <div class="contact_third_form">
                <form class="ajax" class="contact_form" action="{{ url('request-course-submit') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="required">@lang('Name')</label>
                                <input class="form-control" name="name" type="text" placeholder="@lang('Name')">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="required">@lang('Mobile phone')</label>
                                <input class="form-control" name="phone" type="number" placeholder="@lang('Mobile phone')">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="required">@lang('City')</label>
                                <input id="city" class="form-control" name="city" type="text"
                                    placeholder="@lang('City')">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="required">@lang('Email')</label>
                                <input id="email" class="form-control" name="email" type="email"
                                    placeholder="@lang('Email')">
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <div class="form-group">
                                <label class="required">@lang('Course')</label>
                                <select class="form-control" name="course_id">
                                    <option value="">@lang('Select One')</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}"
                                            @if (request()->slug == $course->slug) selected @endif>
                                            {{ $course->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-info text-uppercase px-4" type="submit">
                            @lang('Submit Request') <i class="fas fa-caret-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('after-scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="/js/helpers/form-submit.js"></script>
    <script>
        $('[name="course_id"]').select2();
        $(document).on("course_access_requested", "form", function(event, params) {
            snaptr('track', "PAGE_VIEW", {
                'user_phone_number': $('[name="phone"]').val(),
                'user_email': $('[name="email"]').val(),
                'item_category': $('[name="course_id"] option:selected').text(),
            })
        });
    </script>
@endpush
