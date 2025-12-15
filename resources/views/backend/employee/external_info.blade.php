@extends('backend.layouts.app')
@section('title', 'Employee' . ' | ' . app_name())
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
    <h5>@lang('External User') </h5>
</div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <div class="d-block">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="{{ route('admin.employee.index') }}"
                                        style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">{{ trans('labels.general.all') }}</a>
                                </li>
                                |
                                <li class="list-inline-item">
                                    <a href="{{ route('admin.employee.index') }}?show_deleted=1"
                                        style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">{{ trans('labels.general.trash') }}</a>
                                </li>
                            </ul>
                        </div>


                        <table id="myTable"
                            class="table dt-select custom-teacher-table table-striped @if (auth()->user()->isAdmin()) @if (request('show_deleted') != 1) dt-select @endif @endcan" >
                            <thead>
                                <tr>
                                    @can('category_delete')
                                        @if (request('show_deleted') != 1)
                                            <th style="text-align:center; width:80px"><input type="checkbox" class="mass"
                                                    id="select-all" />
                                            </th>
                                        @endif
                                    @endcan
                                    <th style="width: 80px;">@lang('ID')</th>
                                    <th style="width: 120px;">@lang('Trainee Type')</th>
                                    <th style="width: 120px;">@lang('labels.backend.teachers.fields.first_name')</th>
                                    <th style="width: 120px;">@lang('labels.backend.teachers.fields.last_name')</th>
                                    <th style="width: 120px;">@lang('labels.backend.teachers.fields.email')</th>
                                    <th style="width: 120px;">@lang('Id Number')</th>
                                    <th style="width: 150px;">@lang('Classification Number')</th>
                                    <th style="width: 100px;">@lang('Nationality')</th>
                                    <th style="width: 120px;">@lang('Date of birth')</th>
                                    <th style="width: 120px;">@lang('Mobile phone')</th>
                                    <th style="width: 100px;">@lang('Gender')</th>
                                    <th style="width: 100px;">@lang('labels.backend.teachers.fields.status')</th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('after-scripts')
    <script>
        $(document).ready(function() {
            var route = '{{ route('admin.employee.get_external_trainee_info') }}';

            @if (request('show_deleted') == 1)
                route = '{{ route('admin.employee.get_external_trainee_info', ['show_deleted' => 1]) }}';
            @endif

            var table = $('#myTable').DataTable({
                autoWidth:false,
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                retrieve: true,
                dom:  "<'table-controls'lfB>" +
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
                ajax: route,
                columns: [
                    @if (request('show_deleted') != 1)
                        {
                            "data": function(data) {
                                return '<input type="checkbox" class="single" name="id[]" value="' +
                                    data.id + '" />';
                            },
                            "orderable": false,
                            "searchable": false,
                            "name": "id"
                        },
                    @endif {
                        data: "id",
                        name: 'id'
                    },
                    {
                        data: "employee_type",
                        name: 'employee_type'
                    },
                    {
                        data: "first_name",
                        name: 'first_name'
                    },
                    {
                        data: "last_name",
                        name: 'last_name'
                    },
                    {
                        data: "email",
                        name: 'email'
                    },
                    {
                        data: "id_number",
                        name: 'id_number'
                    },
                    {
                        data: "classfi_number",
                        name: 'classfi_number'
                    },
                    {
                        data: "nationality",
                        name: 'nationality'
                    },
                    {
                        data: "dob",
                        name: 'dob'
                    },
                    {
                        data: "phone",
                        name: 'phone'
                    },
                    {
                        data: "gender",
                        name: 'gender'
                    },
                    {
                        data: "status",
                        name: 'status'
                    }
                ],
                @if (request('show_deleted') != 1)
                    columnDefs: [{
                            "width": "20px",
                            "targets": 0
                        },
                        {
                            "className": "text-center",
                            "targets": [0]
                        }
                    ],
                @endif
                 initComplete: function () {
                     let $searchInput = $('#myTable_filter input[type="search"]');
    $searchInput
        .addClass('custom-search')
        .wrap('<div class="search-wrapper position-relative d-inline-block"></div>')
        .after('<i class="fa fa-search search-icon"></i>');

    $('#myTable_length select').addClass('form-select form-select-sm custom-entries');
                },
                  

                createdRow: function(row, data, dataIndex) {
                    $(row).attr('data-entry-id', data.id);
                },
                language: {
                    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/{{ $locale_full_name }}.json",
                    buttons: {
                        colvis: '{{ trans('datatable.colvis') }}',
                        pdf: '{{ trans('datatable.pdf') }}',
                        csv: '{{ trans('datatable.csv') }}',
                    },
                    search:"",
      
                }

            });
            @if (auth()->user()->isAdmin())
                $('.actions').html('<a href="' + '{{ route('admin.teachers.mass_destroy') }}' +
                    '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>'
                    );
            @endif



        });
        $(document).on('click', '.switch-input', function(e) {
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "{{ route('admin.employee.status') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                },
            }).done(function() {
                var table = $('#myTable').DataTable();
                table.ajax.reload();
            });
        })
    </script>
@endpush
