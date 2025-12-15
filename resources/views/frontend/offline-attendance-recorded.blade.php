@extends('frontend.layouts.app' . config('theme_layout'))

@section('title', __('Offline Course Attendance'). ' | ' . app_name())
@section('meta_description', '')
@section('meta_keywords', '')

@push('after-styles')
    <style>
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
@endpush

@section('content')
    @php
        $footer_data = json_decode(config('footer_data'));
    @endphp

    <!-- Start of breadcrumb section
                ============================================= -->
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold">{{ env('APP_NAME') }} : <span> @lang('Offline Course Attendance')</span></h2>
                </div>
            </div>
        </div>
    </section>
    <!-- End of breadcrumb section
                ============================================= -->


    <!-- Start of contact section
                ============================================= -->
    <section id="contact-page" class="contact-page-section">
        <div class="container">
            <div class="section-title mb45 headline text-center">
                <h2>@lang('Attendance recorded for') {{ $course_name }}</h2>
            </div>
            <p style="font-size: xx-large;">{!! $message !!}</p>
        </div>
    </section>
@endsection
