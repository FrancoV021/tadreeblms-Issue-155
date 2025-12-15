@extends('frontend-rtl.layouts.app'.config('theme_layout'))

@push('after-styles')
@endpush

@section('content')
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold">
                        <span>{{ $course->title }}</span>
                    </h2>
                </div>
            </div>
        </div>
    </section>
    <section id="course-details" class="course-details-section">
        <div class="container ">
            <div class="row main-content">
                <div class="col-md-9">
                    @if ($course->grant_certificate)
                    <div class="m-4 pb-5">
                        <h4>
                            {{-- Dear {{ auth()->user()->full_name }},  --}}
                            {{ trans('course.welcome_title',['name'=>auth()->user()->full_name]) }}
                            <br> 
                            {{-- Thank you for completed assessment/feedback for <b>{{ $course->title }}</b> course. You may download the certificate now. --}}
                            {!! trans('course.welcome_heading',['course'=>$course->title]) !!}
                        </h4>
                    </div>
                    @else
                    @if (
                        @$isAssignmentTaken &&
                            $course->courseAssignments->count() > 0 &&
                            $course->assignmentStatus(auth()->id()) == 'Failed' && !$assessment_link)

                        <h4>{{ trans('course.welcome_title',['name'=>auth()->user()->full_name]) }}, <br>
                            {{ trans('course.sorry_you_failed_to_qualify') }}</h4>
                    @elseif (
                        @$isAssignmentTaken &&
                            $course->courseAssignments->count() > 0 &&
                            $course->assignmentStatus(auth()->id()) == 'Failed' && $assessment_link)

                        <h4>{{ trans('course.welcome_title',['name'=>auth()->user()->full_name]) }}, <br>
                            {{ trans('course.sorry_you_failed_to_qualify_please_try_again') }}</h4>
                    @else        
                    <div class="m-4 pb-5">
                        <h4>{{ trans('course.welcome_title',['name'=>auth()->user()->full_name]) }}, <br>
                            {!! trans('course.your_attendance_taken',['course'=>$course->title]) !!}
                        </h4>
                    </div>
                    @endif
                    @endif
                </div>

                <div class="col-md-3">
                    <div id="sidebar">
                        <div class="course-details-category ul-li">
                            @if (!@$isAssignmentTaken && $assessment_link)
                                <a class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                                    target="_blank" href="{{ htmlspecialchars_decode($assessment_link) }}">
                                    {{ trans('course.btn.start_assesment') }}
                                </a>
                            @endif
                            @if (@$isAssignmentTaken)
                                <a class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                                    href="javascript:void(0)">{{ trans('course.btn.start_completed') }}</a>
                            @endif
                            @if ($course->grant_certificate)
                                <a class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                                    href="{{ route('admin.certificates.generate', ['course_id' => $course->id, 'user_id' => auth()->id()]) }}">
                                    {{ trans('course.btn.download_certificate') }}
                                </a>
                                <div class="alert alert-success">
                                    @lang('labels.frontend.course.certified')
                                </div>
                            @endif
                            @if (
                                @$isAssignmentTaken &&
                                    $course->courseAssignments->count() > 0 &&
                                    $course->assignmentStatus(auth()->id()) == 'Failed')
                                <p class="text text-danger">@lang("Sorry! you didn't qualify the assignment. So certificate could not be issued.")</p>
                                @if ($assessment_link)
                                    <a class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                                        target="_blank" href="{{ htmlspecialchars_decode($assessment_link) }}">{{ trans('course.btn.re_attempt_assigment') }}</a>
                                @endif
                            @endif
                            @if (@$courseFeedbackLink && $course->assignmentStatus(auth()->id()) != 'Failed')
                                <a class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                                    href="{{ $courseFeedbackLink }}">{{ trans('course.btn.give_feedback') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('after-scripts')
@endpush
