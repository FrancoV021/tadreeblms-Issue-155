@extends('frontend-rtl.layouts.app'.config('theme_layout'))
<?php
use App\Models\Lesson;
?>

@section('title', $course->meta_title ? $course->meta_title : app_name())
@section('meta_description', $course->meta_description)
@section('meta_keywords', $course->meta_keywords)
<?php
$subscribe_status = CustomHelper::courseStatus($course->id);
//dd($subscribe_status);
?>
@push('after-styles')
    <style>
        .leanth-course.go {
            right: 0;
        }

        .video-container iframe {
            max-width: 100%;
        }

        .modal-dialog {
            max-width: 50rem;
            margin: 1.75rem auto;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.5.3/plyr.css" />
@endpush

@section('content')

    <!-- Start of breadcrumb section
                            ============================================= -->
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold"><span>{{ $course->arabic_title }}</span></h2>
                </div>
            </div>
        </div>
    </section>
    <!-- End of breadcrumb section
                            ============================================= -->

    <!-- Start of course details section
                            ============================================= -->
    <section id="course-details" class="course-details-section">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="course-details-item border-bottom-0 mb-0">
                        <div class="course-single-pic mb30">
                            @if ($course->course_image != '')
                                <img src="{{ asset('storage/uploads/' . $course->course_image) }}" alt="">
                            @endif
                        </div>
                        <div class="course-single-text">
                            <div class="course-title mt10 headline relative-position">
                                <h3><a href="{{ route('courses.show', [$course->slug]) }}"><b>{{ $course->arabic_title }}</b></a>
                                    @if ($course->trending == 1)
                                        <span class="trend-badge text-uppercase bold-font"><i class="fas fa-bolt"></i>
                                            @lang('labels.frontend.badges.trending')</span>
                                    @endif

                                </h3>
                            </div>
                            <div class="course-details-content">
                                <p>
                                    {!! $course->description !!}
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- /course-details -->

                </div>

                <div class="col-md-3">
                    <div class="side-bar">
                        <div class="course-side-bar-widget">
                            <a href="{{ route('recordAttendance', ['slug' => $course->slug]) }}"
                                class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font">

                                @lang('حضور الدورة')

                                <i class="fa fa-arow-right"></i></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('after-scripts')
    <script>
        localStorage.setItem('redirect_url', window.location.href);
    </script>
@endpush
