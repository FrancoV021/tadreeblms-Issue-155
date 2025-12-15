@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')

@section('title', __('labels.backend.pages.title').' | '.app_name())
@push('after-styles')
 <style>
        .create_done {
            padding: 7px 40px;
            background: #4dbd74;
            border: none;
            outline: none;
            float: right;
            margin: 0 15px 0 0;
            color: #fff;

        }

        .create_done.next {
            background: #4dbd74;
        }
        

    
    </style>

@endpush

@section('content')

<div class="pb-3 d-flex justify-content-between align-items-center">
    <h4>@lang('labels.backend.pages.title')</h4>
    @can('blog_create')
        {{-- <div class="">
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">@lang('strings.backend.general.app_add_new')</a>
        </div> --}}
    @endcan
</div>
    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <div class="d-block">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="{{ route('admin.pages.index') }}"
                               style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">{{trans('labels.general.all')}}</a>
                        </li>
                        |
                        <li class="list-inline-item">
                            <a href="{{ route('admin.pages.index') }}?show_deleted=1"
                               style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">{{trans('labels.general.trash')}}</a>
                        </li>
                    </ul>
                </div>


                <table id="myTable"
                       class="table dt-select custom-teacher-table table-striped">
                    <thead>
                    <tr>
                        @can('lesson_delete')
                            @if ( request('show_deleted') != 1 )
                                <th style="text-align:center;"><input class="mass" type="checkbox" id="select-all"/>
                                </th>@endif
                        @endcan
                        <th>@lang('labels.general.sr_no')</th>
                        <th>@lang('Id')</th>
                        <th>@lang('labels.backend.pages.fields.title')</th>
                        <th>@lang('labels.backend.pages.fields.status')</th>
                        <th>@lang('labels.backend.pages.fields.created')</th>
                        @if( request('show_deleted') == 1 )
                            <th>@lang('strings.backend.general.actions') &nbsp;</th>
                        @else
                            <th style="text-align: center;width:120px">@lang('strings.backend.general.actions') &nbsp;</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>

        </div>
    </div>

@endsection

@push('after-scripts')
    <script>

        $(document).ready(function () {
            var route = '{{route('admin.pages.get_data')}}';

            @if(request('show_deleted') == 1)
                route = '{{route('admin.pages.get_data',['show_deleted' => 1])}}';
            @endif



            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                retrieve: true,
                dom: "<'table-controls'lfB>" +
                     "<'table-responsive't>" +
                     "<'d-flex justify-content-between align-items-center mt-3'ip><'actions'>",
                // buttons: [
                //     {
                //         extend: 'csv',
                //         exportOptions: {
                //             columns: [ 1, 2, 3, 4]
                //         }
                //     },
                //     {
                //         extend: 'pdf',
                //         exportOptions: {
                //             columns: [ 1, 2, 3, 4]
                //         }
                //     },
                //     'colvis'
                // ],
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
                        @if(request('show_deleted') != 1)
                    {
                        "data": function (data) {
                            return '<input type="checkbox" class="single" name="id[]" value="' + data.id + '" />';
                        }, "orderable": false, "searchable": false, "name": "id"
                    },
                        @endif
                    {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false, orderable: false},
                    {data: "id", name: 'id'},
                    {data: "title", name: 'title'},
                    {data: "status", name: 'status'},
                    {data: "created", name: "created"},
                    {data: "actions", name: "actions"}
                ],
                @if(request('show_deleted') != 1)
                columnDefs: [
                    {"width": "5%", "targets": 0},
                    {"className": "text-center", "targets": [0]}
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
                
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-entry-id', data.id);
                },
                language:{
                    url : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/{{$locale_full_name}}.json",
                    buttons :{
                        colvis : '{{trans("datatable.colvis")}}',
                        pdf : '{{trans("datatable.pdf")}}',
                        csv : '{{trans("datatable.csv")}}',
                    },
                   search:"",
                }
            });


            @can('blog_delete')
            @if(request('show_deleted') != 1)
            $('.actions').html('<a href="' + '{{ route('admin.pages.mass_destroy') }}' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
            @endif
            @endcan

        });

    </script>
@endpush