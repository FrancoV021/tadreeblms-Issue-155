@extends('frontend.layouts.app'.config('theme_layout'))

@section('title', 'Contact | '.app_name())
@section('meta_description', '')
@section('meta_keywords','')

@push('after-styles')
    <style>
        .my-alert{
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
@endpush

@section('content')
    @php
        $footer_data = json_decode(config('footer_data'));
    @endphp
    @if(session()->has('alert'))
        <div class="alert alert-light alert-dismissible fade my-alert show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{{session('alert')}}</strong>
        </div>
    @endif

    <!-- Start of breadcrumb section
        ============================================= -->
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold"> <!-- {{env('APP_NAME')}} --> <span> @lang('Delta Academy Contact')</span></h2>
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
                <h2>@lang('labels.frontend.contact.keep_in_touch')</h2>
            </div>
            @if(($footer_data->social_links->status == 1) && (count($footer_data->social_links->links) > 0))
                <div class="social-contact text-center d-inline-block w-100">
                    @foreach($footer_data->social_links->links as $item)
                    <div class="category-icon-title text-center">
                        <a href="{{$item->link}}" target="_blank">
                            <div class="category-icon">
                                <i class="{{$item->icon}}"></i>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
    <!-- End of contact section
        ============================================= -->

    <!-- Start of contact area form
        ============================================= -->
    <section id="contact-form" class="contact-form-area_3 contact-page-version">
        <div class="container">
            <div class="section-title mb45 headline text-center">
                <h2>@lang('labels.frontend.contact.send_us_a_message')</h2>
            </div>

            <div class="contact_third_form">
                <form class="contact_form" action="{{route('contact.send')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="contact-info">
                                <input class="name" name="name" type="text" placeholder="@lang('labels.frontend.contact.your_name')">
                                @if($errors->has('name'))
                                    <span class="help-block text-danger">{{$errors->first('name')}}</span>
                                @endif
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="contact-info">
                                <input class="email" name="email" type="email" placeholder="@lang('labels.frontend.contact.your_email')">
                                @if($errors->has('email'))
                                    <span class="help-block text-danger">{{$errors->first('email')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="contact-info">
                                <input class="number" name="phone" type="number" placeholder="@lang('labels.frontend.contact.phone_number')">
                                @if($errors->has('phone'))
                                    <span class="help-block text-danger">{{$errors->first('phone')}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <textarea name="message" placeholder="@lang('labels.frontend.contact.message')"></textarea>

                @if($errors->has('message'))
                        <span class="help-block text-danger">{{$errors->first('message')}}</span>
                    @endif

                    @if(config('access.captcha.registration'))
                        <div class="contact-info mt-5 text-center">
                            {{ no_captcha()->display() }}
                            {{ html()->hidden('captcha_status', 'true')->id('captcha_status') }}
                            @if($errors->has('g-recaptcha-response'))
                                <p class="help-block text-danger mx0auto">{{$errors->first('g-recaptcha-response')}}</p>
                            @endif
                        </div><!--col-->
                    @endif


                    <div class="nws-button text-center text-uppercase">
                        <button class="text-uppercase px-4" type="submit" value="Submit">@lang('labels.frontend.contact.send_email') <i class="fas fa-caret-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- End of contact area form
        ============================================= -->


    <!-- Start of contact area
        ============================================= -->
    <!-- @include('frontend.layouts.partials.contact_area') -->
    <!-- End of contact area
        ============================================= -->


@endsection
@push('after-scripts')
    @if(config('access.captcha.registration'))
        {{ no_captcha()->script() }}
    @endif
@endpush
