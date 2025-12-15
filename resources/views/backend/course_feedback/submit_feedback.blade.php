@extends('frontend.layouts.basic')

@section('title', trans('labels.frontend.home.title').' | '.app_name())
@section('meta_description', '')
@section('meta_keywords','')


@push('after-styles')
    <style>
        .teacher-img-content .teacher-social-name {
            max-width: 67px;
        }

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
        .container.course-detail {
            padding-bottom: 80px;
        }
    </style>
@endpush

@section('content')





    <section class="about-section padding-top">
        <div class="container course-detail">

            <div class="row">
                <div class="col-md-6">
                    <h3 class="title">{{ $course_list->title }}</h3>
                    <p class="desc">{!! $course_list->short_text !!}</p>
                    <h4 class="title">Course:{{ $course_list->title }}</h4>
                    {{-- <p class="desc">Date: {{ date('d/m/Y h:i A',strtotime($course_list->lesson_start_date)) }}</p> --}}
                    @if(!empty($course_list->price))<p class="desc">Price: {{ $course_list->price }}</p>@endif
                    @if(isset($course_list->publishedLessons) && count($course_list->publishedLessons))
                    {{-- {{ dd($course_list->publishedLessons) }} --}}
                    <span>Lessons Included</span>
                    <ul class="course-lesson-list">
                        @foreach($course_list->publishedLessons as $lesson)
                            <li>{{ $lesson->title }}</li>
                        @endforeach
                    </ul>
                    @endif
                    @if ($course_list->course_image)
                        <img width="300" height="80" src="{{ asset('storage/uploads/'.$course_list->course_image) }}" class="mt-1">
                    @endif


                </div>
                <div class="col-md-6">
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    @if($feedback_questions)
                    <form action="{{ route('feedback.submit') }}" method="post">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course_list->id }}" />
                        <input type="hidden" name="user_id" value="{{ $user->id }}" />
                        @foreach($feedback_questions as $question)
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ $question->question }}</label>
                            <input type="hidden"  class="form-control" name="feedback_ids[]" value="{{ $question->id }}">
                            <input type="number" min="1" max="5"  class="form-control" name="feedback_rates[]" placeholder="Your Rate Please">
                        </div>
                        @endforeach

                        <button type="submit" class="btn btn-primary">Submit Your Feedback</button>
                    </form>
                    @endif
                </div>

            </div>
        </div>
    </section>


@endsection
@push('after-scripts')
    <script>
        $('ul.product-tab').find('li:first').addClass('active');
        $('.news-slider').slick({
          dots: false,
          infinite: true,
          speed: 300,
          slidesToShow: 3,
          slidesToScroll: 1,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
            ]
         });
    </script>
@endpush
