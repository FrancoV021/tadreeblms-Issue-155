@extends('frontend.layouts.app'.config('theme_layout'))
@section('title', trans('labels.frontend.course.courses').' | '. app_name() )

@push('after-styles')
    <style>
        .couse-pagination li.active {
            color: #333333 !important;
            font-weight: 700;
        }

        .page-link {
            position: relative;
            display: block;
            padding: .5rem .75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #c7c7c7;
            background-color: white;
            border: none;
        }

        .page-item.active .page-link {
            z-index: 1;
            color: #333333;
            background-color: white;
            border: none;

        }
     .listing-filter-form select{
            height:50px!important;
        }

        ul.pagination {
            display: inline;
            text-align: center;
        }

        .title {
        
            font-size: 20px;
            background-color: #f7f7f7;
            padding: 10px;
            text-align: center;
            position: absolute;
            top: 0;
             width: 100%;

        }
    </style>
@endpush
@section('content')

    <!-- Start of breadcrumb section
        ============================================= -->
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold">
                        <span> Departments </span>
                    </h2>
                </div>
            </div>
        </div>
    </section>
    <!-- End of breadcrumb section
        ============================================= -->


    <!-- Start of course section
        ============================================= -->
    <section id="course-page" class="course-page-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(session()->has('success'))
                        <div class="alert alert-dismissable alert-success fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{session('success')}}
                        </div>
                    @endif
                    <!--div class="short-filter-tab">
                        <div class="shorting-filter w-50 d-inline float-left mr-3">
                            <span>@lang('labels.frontend.course.sort_by')</span>
                            <select id="sortBy" class="form-control d-inline w-50">
                                <option value="">@lang('labels.frontend.course.none')</option>
                                <option value="popular">@lang('labels.frontend.course.popular')</option>
                                <option value="trending">@lang('labels.frontend.course.trending')</option>
                                <option value="featured">@lang('labels.frontend.course.featured')</option>
                            </select>
                        </div>

                        <div class="tab-button blog-button ul-li text-center float-right">
                            <ul class="product-tab">
                                <li class="active" rel="tab1"><i class="fas fa-th"></i></li>
                                <li rel="tab2"><i class="fas fa-list"></i></li>
                            </ul>
                        </div>

                    </div-->

                    <div class="genius-post-item">
                        <div class="tab-container">
                            <div id="tab1" class="tab-content-1 pt35">
                                <div class="best-course-area best-course-v2">
                                    <div class="row">
                                        @if($departments->count() > 0)

                                            @foreach($departments as $course)

                                                
                                                <div class="col-md-4">
                                                    <div class="best-course-pic-text relative-position">
                                                        <div class="best-course-pic relative-position"
                                                             style="background-image: url('{{asset('storage/logos/book.png')}}')" 

                                                            @if($course->trending == 1)
                                                                <div class="trend-badge-2 text-center text-uppercase">
                                                                    <i class="fas fa-bolt"></i>
                                                                    <span>@lang('labels.frontend.badges.trending')</span>
                                                                </div>
                                                            @endif
                                                                @if($course->free == 1)
                                                                    <div class="trend-badge-3 text-center text-uppercase">
                                                                        <i class="fas fa-bolt"></i>
                                                                        <span>@lang('labels.backend.courses.fields.free')</span>
                                                                    </div>
                                                                @endif
                                                            <!--div class="course-price text-center gradient-bg">
                                                                @if($course->free == 1)
                                                                    <span>{{trans('labels.backend.courses.fields.free')}}</span>
                                                                @else
                                                                    <span>
                                                                        {!!  $course->strikePrice  !!}
                                                                        {{$appCurrency['symbol'].' '.$course->price}}
                                                                    </span>
                                                                @endif
                                                            </div-->

                                                            <div class="course-rate ul-li">
                                                                <ul>
                                                                    @for($i=1; $i<=(int)$course->rating; $i++)
                                                                        <li><i class="fas fa-star"></i></li>
                                                                    @endfor
                                                                </ul>
                                                            </div>
                                                            <div class="course-details-btn">
                                                                <a href="{{ route('department.show', [$course->id]) }}">View Courses
                                                                    <i class="fas fa-arrow-right"></i></a>
                                                            </div>
                                                            
                                                            <h2 class="title">{{ $course->title }}</h2>
                                                        </div>
                                                        
                                                        
                                                    </div>
                                                </div>

                                            @endforeach
                                        @else
                                            <h3>@lang('labels.general.no_data_available')</h3>
                                    @endif

                                    <!-- /course -->

                                    </div>
                                </div>
                            </div><!-- /tab-1 -->

                            
                        </div>
                        <div class="couse-pagination text-center ul-li">
                          
                        </div>
                    </div>


                </div>

                
            </div>
        </div>
    </section>
    <!-- End of course section
        ============================================= -->

    <!-- Start of best course
   =============================================  -->
    @include('frontend.layouts.partials.browse_courses')
    <!-- End of best course
            ============================================= -->


@endsection

@push('after-scripts')
    <script>
        $(document).ready(function () {
            $(document).on('change', '#sortBy', function () {
                if ($(this).val() != "") {
                    location.href = '{{url()->current()}}?type=' + $(this).val();
                } else {
                    location.href = '{{route('courses.all')}}';
                }
            })

            @if(request('type') != "")
            $('#sortBy').find('option[value="' + "{{request('type')}}" + '"]').attr('selected', true);
            @endif
        });

    </script>
@endpush
