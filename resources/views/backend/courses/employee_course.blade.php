@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', __('labels.backend.courses.title').' | '.app_name())

@section('content')


    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">{{ CustomHelper::getUserName($employee_id); }} [{{ CustomHelper::getCourseName($course_id); }}]</h3>
            @can('course_create')
                <div class="float-right">
                    <a href="{{ route('admin.courses.create') }}"
                       class="btn btn-success">@lang('strings.backend.general.app_add_new')</a>

                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-block">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="{{ route('admin.courses.index') }}"
                               style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">{{trans('labels.general.all')}}</a>
                        </li>
                        |
                        <li class="list-inline-item">
                            <a href="{{ route('admin.courses.index') }}?show_deleted=1"
                               style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">{{trans('labels.general.trash')}}</a>
                        </li>
                    </ul>
                </div>


                <table id="myTable" class="table table-bordered table-striped @can('course_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                    <thead>
                    <tr>
                        @can('course_delete')
                            @if ( request('show_deleted') != 1 )
                                <th style="text-align:center;"><input type="checkbox" class="mass" id="select-all"/></th>@endif
                        @endcan


                        
                        <th>@lang('labels.general.sr_no')</th>
                        <th>@lang('labels.general.id')
                        <th>Lesson Title</th>
                        <th>Attendance</th>
                        <th>Lesson Start Date</th>
                        <th>Lesson Completed Date</th>
                        <th>@lang('labels.backend.courses.fields.status')</th>
                        
                    </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@push('after-scripts')
    <script>

        $(document).ready(function () {
            var route = '{{route('admin.courses.get_data_employee_course',[ $course_id , $employee_id])}}';

            
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                retrieve: true,
                dom: 'lfBrtip<"actions">',
                buttons: [
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4,5,6 ]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4,5,6 ]
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [
                    @if(request('show_deleted') != 1)
                    { "data": function(data){
                        return '<input type="checkbox" class="single" name="id[]" value="'+ data.id +'" />';
                    }, "orderable": false, "searchable":false, "name":"id" },
                    @endif
                   
                   
                    {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false},
                    {data: "id", name: 'id'},
                    {data: "title", name: 'title'},
                    {data: "attendance", name: 'attendance'},
                    {data: "lesson_start_date", name: 'lesson_start_date'},
                    {data: "lesson_end_date", name: 'lesson_end_date'},
                    {data: "status", name: "status"},
                    //{data: "actions", name: "actions"}
                ],
                @if(request('show_deleted') != 1)
                columnDefs: [
                    {"width": "5%", "targets": 0},
                    {"className": "text-center", "targets": [0]}
                ],
                @endif

                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-entry-id', data.id);
                },
                language:{
                    url : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/{{$locale_full_name}}.json",
                    buttons :{
                        colvis : '{{trans("datatable.colvis")}}',
                        pdf : '{{trans("datatable.pdf")}}',
                        csv : '{{trans("datatable.csv")}}',
                    }
                }
            });
            {{--@can('course_delete')--}}
            {{--@if(request('show_deleted') != 1)--}}
            {{--$('.actions').html('<a href="' + '{{ route('admin.courses.mass_destroy') }}' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');--}}
            {{--@endif--}}
            {{--@endcan--}}
        });

    </script>

@endpush