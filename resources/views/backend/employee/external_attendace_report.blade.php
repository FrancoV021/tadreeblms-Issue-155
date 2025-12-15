@extends('backend.layouts.app')
@section('title', 'Trainee' . ' | ' . app_name())
@push('after-styles')
<link rel="stylesheet" href="{{ asset('assets/css/colors/switch.css') }}">
<style>
    .switch.switch-3d.switch-lg {
        width: 40px;
        height: 20px;
    }

    .switch.switch-3d.switch-lg .switch-handle {
        width: 20px;
        height: 20px;
    }

    #myTable {
        table-layout: fixed !important;
        width: 100% !important;
    }
</style>
@endpush

@section('content')
<div class="pb-3">
    <h5 class="">@lang('External Attendace Report')</h5>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">

                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="myTable"
                                class="table dt-select custom-teacher-table table-striped @can('category_delete') @if (request('show_deleted') != 1) dt-select @endif @endcan">
                                <thead>
                                    <tr>
                                        <th style="width: 120px;">@lang('Trainee Type')</th>
                                        <th style="width: 120px;">@lang('UserName')</th>
                                        <th style="width: 120px;">@lang('UserMail')</th>
                                        <th style="width: 120px;">@lang('Id Number')</th>
                                        <th style="width: 160px;">@lang('Classification Number')</th>
                                        <th style="width: 120px;">@lang('DOB')</th>
                                        <th style="width: 120px;">@lang('Gender')</th>
                                        <th style="width: 120px;">@lang('Course Name')</th>
                                        <th style="width: 120px;">@lang('Trainer Name')</th>
                                        <th style="width: 120px;">@lang('User Attendence')</th>
                                        <th style="width: 120px;">@lang('Enrollment Date')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($val as $key => $value)
                                    <tr>
                                        <td>{{ $value->employee_type }}</td>
                                        <td>{{ $value->first_name }} {{ $value->last_name }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->id_number }}</td>
                                        <td>{{ $value->classfi_number }}</td>
                                        <td>{{ $value->dob }}</td>
                                        <td>{{ $value->gender }}</td>
                                        <td>{{ $value->title }}</td>
                                        <td>{{ $value->employee_type }}</td>
                                        <td>{{ $value->progress_per ?? 0 }} %</td>
                                        <td>{{ $value->sub_created_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script>
    $(document).ready(function() {
        $('#myTable').dataTable({
            autoWidth: false,
            "paginate": true,
            "sort": true,
            "language": {
                "emptyTable": "No Data Is Available.",
                search: "",

            },
            "order": [
                [0, "desc"]
            ],
            dom: "<'table-controls'lfB>" +
                "<'table-responsive't>" +
                "<'d-flex justify-content-between align-items-center mt-3'ip><'actions'>",
            buttons: [
    {
        extend: 'collection',
        text: '<i class="fa fa-download icon-styles"></i>',
        className: '',
        buttons: [
            {
                extend: 'csv',
                text: 'CSV',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'pdf',
                text: 'PDF',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            }
        ]
    },
      {extend: 'colvis',
    text: '<i class="fa fa-eye icon-styles" aria-hidden="true"></i>',
    className: ''},
],
            initComplete: function() {
                let $searchInput = $('#myTable_filter input[type="search"]');
                $searchInput
                    .addClass('custom-search')
                    .wrap('<div class="search-wrapper position-relative d-inline-block"></div>')
                    .after('<i class="fa fa-search search-icon"></i>');

                $('#myTable_length select').addClass('form-select form-select-sm custom-entries');
            },

        });
    });
</script>
@endpush