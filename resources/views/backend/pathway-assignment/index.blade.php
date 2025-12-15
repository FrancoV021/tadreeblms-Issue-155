@extends('backend.layouts.app')
@section('title', __('Learning Pathway Assignments') . ' | ' . app_name())
@push('after-styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet" />
  <style>
       
    </style>
@endpush
@section('content')

<div class="pb-3 align-items-center d-flex justify-content-between">
    <h5>@lang('Learning Pathway Assignments')</h5>
    @can('course_create')
        <div >
            <a href="{{ url('/user/pathway-assignments/create') }}" class="btn add-btn">+ @lang('Make New Assignment')</a>
        </div>
    @endcan
</div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <form id="advace_filter">
                        <div class="row">

                            
                            <div class="col-lg-4 col-sm-6 col-xs-12 mt-3" id="email-block">
                                Select Employee By Email 
                                <div class="custom-select-wrapper mt-2">
                                <select class="form-control custom-select-box select2 js-example-placeholder-single" name="user" id="user" >
                                    <option value="">Select</option>
                                    @if($internal_users)
                                        @foreach($internal_users as $user)
                                            <option @if($user->id == request()->user) selected @endif value="{{ $user->id }}">{{ $user->email }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="custom-select-icon" style="right: 10px;">
                                            <i class="fa fa-chevron-down"></i>
                                        </span>
                                </div>
                            </div>
                            
                            
                            
                            <div class="col-lg-4 col-sm-6 col-xs-12 mt-3">

                                Select Course
                                <div class="custom-select-wrapper mt-2">
                                    <select name="course_id" id="course_id" class="select2 form-control custom-select-box">
                                        <option value="">Select</option>
                                        @if($published_courses)
                                        @foreach($published_courses as $row)
                                        <option @if($row->id == request()->course_id) selected @endif value="{{ $row->id }}">{{ $row->title }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <span class="custom-select-icon">
                                        <i class="fa fa-chevron-down"></i>
                                    </span>
                                </div>
                            </div>
                            
                            
                           

                           

                            <div class="col-lg-4 col-md-12 col-sm-6 col-xs-12 d-flex align-items-center mt-4">

                            <div class="d-flex justify-content-between mt-3">
                                <div>
                                    <button class="btn btn-primary" id="advance-search-btn" type="submit">Advance Search</button>
                                </div>
                                <div>
                                    <button class="btn btn-danger ml-3" id="reset" type="button">Reset</button>

                                </div>
                                
                            </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table id="myTable"
                            class="table dt-select custom-teacher-table table-striped @if (auth()->user()->isAdmin()) @if (request('show_deleted') != 1) dt-select @endif @endcan">
                            <thead>
                                <tr>
                                    <th>@lang('Assign title')</th>
                                    {{-- <th>@lang('Pathway Name')</th> --}}
                                    <th>@lang('Course Name')</th>
                                    <th>@lang('Assigned By')</th>
                                    <th>@lang('Assigned Users')</th>
                                    <th>User Email</th>
                                    <th>@lang('Assign. Date')</th>
                                    <th>@lang('Due Date')</th>
                                    {{-- <th>@lang('Action')</th> --}}
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('after-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="/js/helpers/confirm-modal.js"></script>
    <script src="/js/helpers/load-modal.js"></script>
    <script src="/js/pages/learning-pathway-assignment.js"></script>
@endpush
