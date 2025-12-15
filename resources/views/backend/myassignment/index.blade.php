@extends('backend.layouts.app')

@section('title', 'My Assessment | ' . app_name())




@section('content')

<div class="userheading">

    <h4 class=""> <span>@lang('My Assignment')</span> </h4>


</div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">


                        <table id="myTable" class="table custom-teacher-table table-striped ">
                            <thead>
                                <tr>

                                    <th>@lang('labels.general.sr_no')</th>
                                    <th>@lang('Test Name')</th>
                                    <th>@lang('Assign Date')</th>
                                    <th>@lang('Due Date')</th>
                                    <th>@lang('Url')</th>
                                    <th>{{ trans('labels.general.score_label') }}</th>
                                    <th>@lang('Status')</th>
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

@stop

@push('after-scripts')
    <script>
        $(document).ready(function() {
            var route = '{{ route('user.myassignment.getdata') }}';

            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                retrieve: true,
                select: { info: false },
                //dom: 'lfBrtip<"actions">',
                buttons: [{
                        extend: 'csv',
                        exportOptions: {
                            columns: ':visible',
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible',
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [

                    {
                        data: "DT_RowIndex",
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "assessment_name",
                        name: 'assessment_name'
                    },
                    {
                        data: "created_at",
                        name: 'created_at'
                    },
                    {
                        data: "due_date",
                        name: 'due_date'
                    },
                    {
                        data: "assesment_url",
                        name: 'assesment_url'
                    },
                    {
                        data: "score",
                        name: 'score'
                    },
                    {
                        data: "status",
                        name: 'status'
                    },
                ],
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
                    @if(app()->getLocale() == 'ar')
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json'
                    @else
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/en-GB.json'
                    @endif
                },
            });

        });
    </script>
@endpush
