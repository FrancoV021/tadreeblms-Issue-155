@extends('backend.layouts.app')
@section('title', __('labels.backend.general_settings.footer.title').' | '.app_name())

@push('after-styles')
    <link rel="stylesheet" href="{{asset('plugins/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css')}}"/>

    <link rel="stylesheet" href="{{asset('assets/css/colors/switch.css')}}">
    <style>
        .color-list li {
            float: left;
            width: 8%;
        }

        .options {
            line-height: 35px;
        }

        .color-list li a {
            font-size: 20px;
        }

        .color-list li a.active {
            border: 4px solid grey;
        }

        .color-default {
            font-size: 18px !important;
            background: #101010;
            border-radius: 100%;
        }

        .form-control-label {
            line-height: 35px;
        }

        .switch.switch-3d {
            margin-bottom: 0px;
            vertical-align: middle;

        }

        .color-default i {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .preview {
            background-color: #dcd8d8;
            background-image: url(https://www.transparenttextures.com/patterns/carbon-fibre-v2.png);
        }
        @media screen and (max-width: 768px) {
        .offset-2 {
    margin-left: 0%;
}
        }
    </style>
@endpush
@section('content')

<form method="POST" action="{{ route('admin.general-settings') }}" 
      id="general-settings-form" 
      class="form-horizontal" 
      enctype="multipart/form-data">
@csrf

<div class="pb-3">
    <h4 class="page-title d-inline">@lang('labels.backend.general_settings.footer.title')</h4>
</div>

<div class="card">

    <div class="card-body" id="footer">

        <input type="hidden" id="footer_data" name="footer_data">

        {{-- Short Description --}}
        <div class="form-group row">
            <label class="col-md-2 form-control-label" for="short_description">
                {{ __('labels.backend.general_settings.footer.short_description') }}
            </label>

            <div class="col-md-8">
                <textarea id="short_description" 
                          name="short_description" 
                          class="form-control"
                          placeholder="{{ __('labels.backend.general_settings.footer.short_description') }}"></textarea>
            </div>

            <div class="col-md-2">
                <p style="line-height: 35px">
                    <span class="mr-2">{{ __('labels.backend.general_settings.contact.show') }}</span>
                    <label class="switch switch-sm switch-3d switch-primary">
                        <input type="checkbox" class="switch-input status" checked value="1">
                        <span class="switch-label"></span><span class="switch-handle"></span>
                    </label>
                </p>
            </div>
        </div>

        {{-- Footer Sections (1 to 3) --}}
        @for($i=1; $i<=3; $i++)
            <div class="form-group row">
                
                <label class="col-md-2 form-control-label">
                    {{ __('labels.backend.general_settings.footer.section_'.$i) }}
                </label>

                <div class="col-md-8 options">
                    <div class="row">

                        {{-- Radio 1 --}}
                        <div class="col-4">
                            <label class="switch switch-sm switch-3d switch-success">
                                <input type="radio" name="section{{ $i }}" value="1" checked class="switch-input section{{ $i }}">
                                <span class="switch-label"></span><span class="switch-handle"></span>
                            </label>
                            <span class="ml-2 title">{{ __('labels.backend.general_settings.footer.popular_categories') }}</span>
                        </div>

                        {{-- Radio 2 --}}
                        <div class="col-4">
                            <label class="switch switch-sm switch-3d switch-success">
                                <input type="radio" name="section{{ $i }}" value="2" class="switch-input section{{ $i }}">
                                <span class="switch-label"></span><span class="switch-handle"></span>
                            </label>
                            <span class="ml-2 title">{{ __('labels.backend.general_settings.footer.featured_courses') }}</span>
                        </div>

                        {{-- Radio 3 --}}
                        <div class="col-4">
                            <label class="switch switch-sm switch-3d switch-success">
                                <input type="radio" name="section{{ $i }}" value="3" class="switch-input section{{ $i }}">
                                <span class="switch-label"></span><span class="switch-handle"></span>
                            </label>
                            <span class="ml-2 title">{{ __('labels.backend.general_settings.footer.trending_courses') }}</span>
                        </div>

                        {{-- Radio 4 --}}
                        <div class="col-4 mt-2">
                            <label class="switch switch-sm switch-3d switch-success">
                                <input type="radio" name="section{{ $i }}" value="4" class="switch-input section{{ $i }}">
                                <span class="switch-label"></span><span class="switch-handle"></span>
                            </label>
                            <span class="ml-2 title">{{ __('labels.backend.general_settings.footer.popular_courses') }}</span>
                        </div>

                        {{-- Custom Links --}}
                        <div class="col-4 mt-2">
                            <label class="switch switch-sm switch-3d switch-success">
                                <input type="radio" name="section{{ $i }}" value="5" class="switch-input custom_links section{{ $i }}">
                                <span class="switch-label"></span><span class="switch-handle"></span>
                            </label>
                            <span class="ml-2 title">{{ __('labels.backend.general_settings.footer.custom_links') }}</span>
                        </div>

                    </div>
                </div>

                <div class="col-md-2">
                    <p style="line-height: 35px">
                        <span class="mr-2">{{ __('labels.backend.general_settings.contact.show') }}</span>
                        <label class="switch switch-sm switch-3d switch-primary">
                            <input type="checkbox" class="switch-input status" checked value="1">
                            <span class="switch-label"></span><span class="switch-handle"></span>
                        </label>
                    </p>
                </div>

                <div class="col-10 offset-2 button-container"></div>

            </div>
        @endfor


        {{-- Social Links --}}
        <div class="form-group row">
            <label class="col-md-2 form-control-label">
                {{ __('labels.backend.general_settings.footer.social_links') }}
            </label>

            <div class="col-md-4 my-1">
                <input type="text" id="social_link_url" class="form-control"
                       placeholder="{{ __('labels.backend.general_settings.footer.link_url') }}">
                <span class="error text-danger"></span>
            </div>

            <div class="col-md-2 my-1">
                <button type="button" id="icon" class="btn btn-default border btn-block"></button>
            </div>

            <div class="col-md-2 my-1">
                <button type="button" class="btn btn-light add-social-link border btn-block">
                    {{ trans('strings.backend.general.app_add') }} <i class="fa fa-plus"></i>
                </button>
            </div>

            <div class="col-md-2 my-1">
                <label class="switch switch-sm switch-3d switch-primary">
                    <input type="checkbox" class="switch-input status" checked value="1">
                    <span class="switch-label"></span><span class="switch-handle"></span>
                </label>
            </div>

            <div class="col-md-10 offset-2">
                <p class="font-italic">{!! __('labels.backend.general_settings.footer.social_links_note') !!}</p>
            </div>

            <div class="col-md-8 offset-2 social-links-container"></div>
        </div>


        {{-- Newsletter --}}
        <div class="form-group row">
            <label class="col-md-2 form-control-label">
                {{ __('labels.backend.general_settings.footer.newsletter_form') }}
            </label>

            <div class="col-md-2">
                <label class="switch switch-sm switch-3d switch-primary">
                    <input type="checkbox" class="switch-input newsletter-form status" checked value="1">
                    <span class="switch-label"></span><span class="switch-handle"></span>
                </label>
            </div>
        </div>


        {{-- Bottom Footer --}}
        <div class="form-group row">
            <label class="col-md-2 form-control-label">
                {{ __('labels.backend.general_settings.footer.bottom_footer') }}
            </label>

            <div class="col-md-10">
                <label class="switch switch-sm switch-3d switch-primary">
                    <input type="checkbox" class="switch-input bottom-footer status" checked value="1">
                    <span class="switch-label"></span><span class="switch-handle"></span>
                </label>
                <span class="ml-3 font-italic">{{ __('labels.backend.general_settings.footer.bottom_footer_note') }}</span>
            </div>
        </div>


        {{-- Copyright --}}
        <div class="form-group row">
            <label class="col-md-2 form-control-label" for="copyright_text">
                {{ __('labels.backend.general_settings.footer.copyright_text') }}
            </label>

            <div class="col-md-8">
                <input type="text" id="copyright_text" 
                       class="form-control"
                       placeholder="{{ __('labels.backend.general_settings.footer.copyright_text') }}">
            </div>

            <div class="col-md-2">
                <label class="switch switch-sm switch-3d switch-primary">
                    <input type="checkbox" class="switch-input status" checked value="1">
                    <span class="switch-label"></span><span class="switch-handle"></span>
                </label>
            </div>
        </div>


        {{-- Footer Links --}}
        <div class="form-group row">
            <label class="col-md-2 form-control-label">
                {{ __('labels.backend.general_settings.footer.footer_links') }}
            </label>

            <div class="col-md-4 my-1">
                <input type="text" id="footer_link_url" class="form-control"
                       placeholder="{{ __('labels.backend.general_settings.footer.link_url') }}">
                <span class="error text-danger"></span>
            </div>

            <div class="col-md-2 my-1">
                <input type="text" id="footer_link_label" class="form-control"
                       placeholder="{{ __('labels.backend.general_settings.footer.link_label') }}">
            </div>

            <div class="col-md-2 my-1">
                <button type="button" class="btn btn-light btn-block add-footer-link border">
                    {{ trans('strings.backend.general.app_add') }} <i class="fa fa-plus"></i>
                </button>
            </div>

            <div class="col-md-2 my-1">
                <label class="switch switch-sm switch-3d switch-primary">
                    <input type="checkbox" class="switch-input status" checked value="1">
                    <span class="switch-label"></span><span class="switch-handle"></span>
                </label>
            </div>

            <div class="col-md-8 offset-2 footer-links-container"></div>

        </div>

    </div>

    {{-- Footer Submit --}}
    <div class="row p-3">
        <div class="col">
            <a href="{{ route('admin.general-settings') }}" class="btn btn-secondary">
                {{ __('buttons.general.cancel') }}
            </a>
        </div>

        <div class="col text-right">
            <button type="submit" id="submit" class="btn btn-primary">
                {{ __('buttons.general.crud.update') }}
            </button>
        </div>
    </div>

</div>

</form>

@endsection


@push('after-scripts')
    <script src="{{asset('plugins/bootstrap-iconpicker/js/bootstrap-iconpicker.bundle.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            //========= Initialisation for Iconpicker ===========//
            $('#icon').iconpicker({
                cols: 10,
                icon: 'fab fa-facebook-f',
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

            //========== Preset Footer Data ===========//
            @if(config('footer_data'))
            var footer_data = "{{config('footer_data')}}";

            footer_data = JSON.parse(footer_data.replace(/&quot;/g, '"').replace(/\n/g,"<br>"));
            var footer = $('#footer');
            var status;

            //== Preset Short description
            footer.find('#short_description').val(footer_data.short_description.text.replace(/<br>/g,"\n").replace(/amp;/g,""));
            status = (footer_data.short_description.status === 1);
            footer.find('#short_description').parents('.form-group').find('.status').attr('checked', status);

            //== Preset Section inputs data
            footer.find('.section1[value="' + footer_data.section1.type + '"]').attr('checked', true);
            status = (footer_data.section1.status === 1);
            footer.find('.section1[value="' + footer_data.section1.type + '"]').parents('.form-group').find('.status').attr('checked', status);
            if (footer_data.section1.type == 5) {
                presetCustomLinks(footer.find('.section1[value="' + footer_data.section1.type + '"]'), footer_data.section1.links)
            }

            footer.find('.section2[value="' + footer_data.section2.type + '"]').attr('checked', true);
            status = (footer_data.section2.status === 1);
            footer.find('.section2[value="' + footer_data.section2.type + '"]').parents('.form-group').find('.status').attr('checked', status);
            if (footer_data.section2.type == 5) {
                presetCustomLinks(footer.find('.section2[value="' + footer_data.section2.type + '"]'), footer_data.section2.links)
            }

            footer.find('.section3[value="' + footer_data.section3.type + '"]').attr('checked', true);
            status = (footer_data.section3.status === 1);
            footer.find('.section3[value="' + footer_data.section3.type + '"]').parents('.form-group').find('.status').attr('checked', status);
            if (footer_data.section3.type == 5) {
                presetCustomLinks(footer.find('.section3[value="' + footer_data.section3.type + '"]'), footer_data.section3.links)
            }
            @endif

            //== Preset Social links data
            if (footer_data.social_links) {
                $(footer_data.social_links.links).each(function (key, link_data) {
                    var html = "<div class='alert border alert-light alert-dismissible social-link-wrapper fade show'> " +
                        "<button type='button' class='close' data-dismiss='alert'>&times;</button> " +
                        "<strong><i class='" + link_data.icon + " mr-2'></i></strong><span data-icon='" + link_data.icon + "' class='mb-0 social-link-data'> " + link_data.link + "</span></div>";
                    $('.social-links-container').append(html);
                });
                status = (footer_data.social_links.status == 1);
                console.log((footer_data.social_links.status === 1))
                footer.find('.social-links-container').parents('.form-group').find('.status').attr('checked', status);
            }


            //== Preset newsletter form checkbox
            if (footer_data.newsletter_form) {
                status = (footer_data.newsletter_form.status === 1);
                $('.newsletter-form').attr('checked', status);
            }


            //=== Preset Bottom Footer status
            if (footer_data.bottom_footer) {
                status = (footer_data.bottom_footer.status === 1);
                $('.bottom-footer').attr('checked', status);

            }

            //== Preset Copyright text
            if (footer_data.copyright_text) {
                status = (footer_data.copyright_text.status === 1);
                footer.find('#copyright_text').val(footer_data.copyright_text.text)
                footer.find('#copyright_text').parents('.form-group').find('.status').attr('checked', status);
            }


            //== Bottom footer links
            if (footer_data.bottom_footer_links) {
                status = (footer_data.bottom_footer_links.status === 1);
                footer.find('#footer_link_label').parents('.form-group').find('.status').attr('checked', status);
                $(footer_data.bottom_footer_links.links).each(function (key, link_data) {
                    var html = "<div class='alert border alert-light footer-link-wrapper alert-dismissible fade show'> " +
                        "<button type='button' class='close' data-dismiss='alert'>&times;</button> " +
                        "<strong class='footer-link-label'>" + link_data.label + "</strong> <a target='_blank' href='" + link_data.link + "'>" + link_data.link + "</a></div>";
                    $('.footer-links-container').append(html)
                });
            }


            $(document).on('submit', '#general-settings-form', function (e) {
//                e.preventDefault();
                //====== Saving Footer section details =========//
                var footer = $('#footer');
                var footer_data = {};
                var option, type, option_title, option_status, i, b, links, label, link;

                var short_description = footer.find('#short_description').val();
                var description_status = (footer.find('#short_description').parents('.form-group').find('.status').is(':checked')) ? 1 : 0;

                footer_data['short_description'] = {text: short_description, status: description_status};

                //== Saving data for Footer links ==//
                for (i = 0; i <= $('.options').length; i++) {
                    if ($('.options')[i]) {
                        option = $('.options')[i];
                        type = $(option).find('input[type="radio"]:checked').val();
                        option_title = $(option).find('input[type="radio"]:checked').attr('name')
                        option_status = $(option).parents('.form-group').find('.status').is(':checked') ? 1 : 0;
                        if (type != 5) {
                            footer_data[option_title] = {type: type, status: option_status};
                        } else {
                            var link_list = [];
                            links = $(option).parents('.form-group').find('.button-wrapper');
                            $(links).each(function () {
                                label = $(this).find('.button_label').val()
                                link = $(this).find('.button_link').val()
                                link_list.push({label: label, link: link})
                            })
                            footer_data[option_title] = {
                                type: type,
                                links: link_list,
                                status: option_status
                            }
                        }
                    }
                }


                //=== Saving Social links for footer ===//
                var social_links = $('.social-links-container').find('.social-link-wrapper');
                var icon, link, link_list = [];
                $(social_links).each(function () {
                    icon = $(this).find('.social-link-data').data('icon');
                    link = $(this).find('.social-link-data').text().trim();
                    link_list.push({icon: icon, link: link})

                });
                status = (footer.find('.social-links-container').parents('.form-group').find('.status').is(':checked')) ? 1 : 0;
                footer_data['social_links'] = {status: status, links: link_list};

                //==== Newsletter form status ====//
                if ($('.newsletter-form').is(':checked')) {
                    footer_data['newsletter_form'] = {status: 1}
                } else {
                    footer_data['newsletter_form'] = {status: 0}
                }

                //=== Bottom Footer status ====//
                if ($('.bottom-footer').is(':checked')) {
                    footer_data['bottom_footer'] = {status: 1}
                } else {
                    footer_data['bottom_footer'] = {status: 0}
                }

                //=== Copyright Text ===//
                var copy_text = $('#copyright_text').val();
                var status_checkbox = $('#copyright_text').parents('.form-group').find('.status');
                if ($(status_checkbox).is(':checked')) {
                    status = 1;
                } else {
                    status = 0;
                }
                footer_data['copyright_text'] = {text: copy_text, status: status}

                //=== Bottom Footer links ===//
                var footer_links = $('.footer-links-container').find('.footer-link-wrapper');
                var label, link, link_list = [];
                $(footer_links).each(function () {
                    label = $(this).find('.footer-link-label').text().trim();
                    link = $(this).find('.footer-link-label').siblings('a').attr('href');
                    link_list.push({label: label, link: link})
                });
                var status_checkbox = $('.footer-links-container').parents('.form-group').find('.status');
                if ($(status_checkbox).is(':checked')) {
                    status = 1;
                } else {
                    status = 0;
                }

                footer_data['bottom_footer_links'] = {status: status, links: link_list};
                $('#footer_data').val(JSON.stringify(footer_data))
            });
        });


        //====Checking checkbox inputs to show text input for Custom links in section====//
        $(document).on('click', '.options input', function () {
            var button_container = $(this).parents('.form-group').find('.button-container');

            if ($(this).is(':checked') && $(this).val() == 5) {
                button_container.removeClass('d-none')
                if ($(button_container).find('.button-wrapper').length == 0) {
                    var name = "{{__('labels.backend.general_settings.footer.link')}}";
                    var link_label = "{{__('labels.backend.general_settings.footer.link_label')}}";
                    var link_url = "{{__('labels.backend.general_settings.footer.link_url')}}";
                    var html = "<div class='button-wrapper'> <h6 class='mt-3'> " + name + " </h6>" +
                        "<div class='row'>" +
                        "<div class='col-lg-5'>" +
                        "<input type='text' required name=''  class='form-control button_link' placeholder='" + link_url + "'>" +
                        "</div>" +
                        "<div class='col-lg-5'>" +
                        "<input type='text' required name='' class='form-control button_label' placeholder='" + link_label + "'>" +
                        "</div>" +
                        "<div class='col-lg-2'><buttton class='remove btn-danger btn mr-2'><i class='fa fa-times'></i></buttton><buttton class='add btn btn-success  '><i class='fa fa-plus'></i></buttton></div>";

                    $(button_container).append(html);
                }
            } else {
                button_container.addClass('d-none');
            }

        })


        //==========Remove Custom links to Sections============//
        $(document).on('click', '.remove', function () {
            if ($(this).parents('.form-group').find('.button-wrapper').length > 1) {
                if (confirm('Are you sure want to remove link?')) {
                    $(this).parents('.button-wrapper').remove();
                    $('#buttons').val($('.button-wrapper').length)
                }
            } else {
                alert('Minimum one link is required for this selection')
            }

        });


        //=========Add Custom links to Sections==============//
        $(document).on('click', '.add', function () {
            var button_container = $(this).parents('.form-group').find('.button-container');
            if ($(button_container).find('.button-wrapper').length <= 5) {
                var name = "{{__('labels.backend.general_settings.footer.link')}}";
                var link_label = "{{__('labels.backend.general_settings.footer.link_label')}}";
                var link_url = "{{__('labels.backend.general_settings.footer.link_url')}}";
                var html = "<div class='button-wrapper'> <h6 class='mt-3'> " + name + " </h6>" +
                    "<div class='row'>" +
                    "<div class='col-lg-5'>" +
                    "<input type='text' required name='' class='form-control button_link' placeholder='" + link_url + "'>" +
                    "</div>" +
                    "<div class='col-lg-5'>" +
                    "<input type='text' required name='' class='form-control button_label' placeholder='" + link_label + "'>" +
                    "</div>" +
                    "<div class='col-lg-2'><buttton class='remove btn-danger btn mr-2'><i class='fa fa-times'></i></buttton><buttton class='add btn btn-success  '><i class='fa fa-plus'></i></buttton></div>";
                $(button_container).append(html);
            } else {
                alert('Maximum limit of button exceeded!')
            }
        });


        //=========Adding social links====================//
        $(document).on('click', '.add-social-link', function () {
            if ($('#social_link_url').val() == "") {
                $('#social_link_url').siblings('span').empty().html('Please input value')
            } else {
                var icon = $('input[name="icon"]').val();
                var url = $('#social_link_url').val();
                $('#social_link_url').siblings('span').empty();
                var html = "<div class='alert border alert-light alert-dismissible social-link-wrapper fade show'> " +
                    "<button type='button' class='close' data-dismiss='alert'>&times;</button> " +
                    "<strong><i class='" + icon + " mr-2'></i></strong><span data-icon='" + icon + "' class='mb-0 social-link-data'> " + url + "</span></div>";
                $('.social-links-container').append(html);
                $('#social_link_url').val('');
            }
        });


        //======== Add footer links ===========//
        $(document).on('click', '.add-footer-link', function () {
            if ($('#footer_link_url').val() == "" || $('#footer_link_label').val() == "") {
                $('#footer_link_url').siblings('span').empty().html('Please input valid value')
            } else {
                var label = $('#footer_link_label').val();
                var url = $('#footer_link_url').val();
                $('#footer_link_url').siblings('span').empty();
                var html = "<div class='alert border alert-light footer-link-wrapper alert-dismissible fade show'> " +
                    "<button type='button' class='close' data-dismiss='alert'>&times;</button> " +
                    "<strong class='footer-link-label'>" + label + "</strong> <a target='_blank' href='" + url + "'>" + url + "</a></div>";
                $('.footer-links-container').append(html)
                $('#footer_link_url').val('');
                $('#footer_link_label').val('');
            }
        });


        function presetCustomLinks(element, data) {
            var name = "{{__('labels.backend.general_settings.footer.link')}}";

            var button_container = $(element).parents('.form-group').find('.button-container');
            $(data).each(function (key, link_data) {
                var html = "<div class='button-wrapper'> <h6 class='mt-3'> " + name + " </h6>" +
                    "<div class='row'>" +
                    "<div class='col-lg-5'>" +
                    "<input type='text' required name=''  class='form-control button_link' value='" + link_data.link + "'>" +
                    "</div>" +
                    "<div class='col-lg-5'>" +
                    "<input type='text' required name='' class='form-control button_label' value='" + link_data.label + "'>" +
                    "</div>" +
                    "<div class='col-lg-2'><buttton class='remove btn-danger btn mr-2'><i class='fa fa-times'></i></buttton><buttton class='add btn btn-success  '><i class='fa fa-plus'></i></buttton></div>";

                $(button_container).append(html);
            });
        }


    </script>
@endpush

