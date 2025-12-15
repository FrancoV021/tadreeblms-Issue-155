@extends('backend.layouts.app')
@section('title', __('Course Requests') . ' | ' . app_name())

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('Course Requests')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="myTable"
                                        class="table table-bordered table-striped @can('category_delete') @if (request('show_deleted') != 1) dt-select @endif @endcan">
                                        <thead>
                                            <tr>
                                                <th>@lang('S. No')</th>
                                                <th>@lang('Name')</th>
                                                <th>@lang('Email')</th>
                                                <th>@lang('Mobile phone')</th>
                                                <th>@lang('City')</th>
                                                <th>@lang('Course requested')</th>
                                                <th>@lang('Requested at')</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
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
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/user/course-requests",
                    data: function(d) {
                        d.timezone = Intl.DateTimeFormat().resolvedOptions()
                            .timeZone; // Add the user's time zone
                    }
                },
                columns: [{
                        data: null,
                        sortable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'city',
                        name: 'city'
                    },
                    {
                        data: 'course',
                        name: 'course'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                ],
                "paginate": true,
                "sort": true,
                "language": {
                    "emptyTable": "No Data Is Available."
                },
                "order": [
                    [6, "desc"]
                ],
                dom: 'lfBrtip<"actions">',
                buttons: [{
                        extend: 'csv',
                    },
                    {
                        extend: 'pdf',
                        pageSize: 'A4',
                        orientation: 'landscape',
                        customize: function(doc) {
                            var objLayout = {};
                            objLayout['hLineWidth'] = function(i) {
                                return .5;
                            };
                            objLayout['vLineWidth'] = function(i) {
                                return .5;
                            };
                            objLayout['hLineColor'] = function(i) {
                                return '#aaa';
                            };
                            objLayout['vLineColor'] = function(i) {
                                return '#aaa';
                            };
                            objLayout['paddingLeft'] = function(i) {
                                return 2;
                            };
                            objLayout['paddingRight'] = function(i) {
                                return 2;
                            };
                            objLayout['paddingTop'] = function(i) {
                                return 1;
                            };
                            objLayout['paddingBottom'] = function(i) {
                                return 1;
                            };
                            doc.content[1].layout = objLayout;

                            // Reducing font size and cell padding
                            doc.styles.tableHeader.fontSize = 6;
                            doc.styles.tableBodyEven.fontSize = 6;
                            doc.styles.tableBodyOdd.fontSize = 6;

                            // Reducing page margins
                            doc.pageMargins = [5, 5, 5, 5];

                            // Setting explicit column widths if necessary
                            var widths = [];
                            for (var i = 0; i < doc.content[1].table.body[0].length; i++) {
                                widths.push('*');
                            }
                            doc.content[1].table.widths = widths;

                            // Adjust table styles
                            doc.styles.tableHeader.fillColor = '#f3f3f3';
                            doc.styles.tableHeader.color = '#333';
                            doc.styles.tableBodyEven.fillColor = '#f9f9f9';
                            doc.styles.tableBodyOdd.fillColor = '#fff';

                            // Making sure text wraps within the columns
                            doc.content[1].table.body.forEach(function(row) {
                                row.forEach(function(cell) {
                                    if (cell.text) {
                                        cell.text = cell.text.trim();
                                    }
                                });
                            });
                        }
                    },
                    'colvis'
                ]
            });
        });
    </script>
@endpush
