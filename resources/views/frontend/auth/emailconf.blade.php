@extends('frontend.layouts.app'.config('theme_layout'))

@section('title', app_name() . ' | ' . __('labels.frontend.auth.register_box_title'))

@section('content')
    <div class="row justify-content-center align-items-center" style="padding:60px; padding-top:120px;">
        <div class="col col-sm-8 align-self-center">
            <div class="card">
                <div class="card-header">
                    <strong>
                        Email Activation Status :
                        
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    {{ html()->form('POST', route('frontend.auth.register.post'))->open() }}
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                  
                                </div><!--col-->
                            </div><!--row-->

                            
                        </div><!--row-->
                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-0 clearfix" style="text-align:center;">
                                @php
                                print($status);
                                @endphp
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                    {{ html()->form()->close() }}

                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                               
                            </div>
                        </div><!--/ .col -->
                    </div><!-- / .row -->

                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col-md-8 -->
    </div><!-- row -->
@endsection

@push('after-scripts')
    @if(config('access.captcha.registration'))
        {!! Captcha::script() !!}
    @endif
@endpush
