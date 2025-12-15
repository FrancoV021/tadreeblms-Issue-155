@extends('backend.layouts.app')
@push('after-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/amigo-sorter/css/theme-default.css')}}">
    <style>
        ul.sorter > span {
            display: inline-block;
            width: 100%;
            height: 100%;
            background: #f5f5f5;
            color: #333333;
            border: 1px solid #cccccc;
            border-radius: 6px;
            padding: 0px;
        }

        ul.sorter li > span .title {
            padding-left: 15px;
        }

        ul.sorter li > span .btn {
            width: 20%;
        }


    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">Attendence</h3>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="myTable"
                               class="table table-bordered table-striped ">
                            <thead>
                            <tr>
                                <th>@lang('labels.general.sr_no')</th>
                                <th>Course Title</th>
                                <th>Lesson Title</th>
                                <th>Date</th>
                                <th width="20%">Mark Attendence</th>
                                @if( request('show_deleted') == 1 )
                                    <th>&nbsp; @lang('strings.backend.general.actions')</th>
                                @else
                                    <th>&nbsp; @lang('strings.backend.general.actions')</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lessons_data as $key=>$item)
                                @php $key++ @endphp
                                <tr>
                                    <td>
                                        {{ $key }}
                                    </td>
                                    <td>
                                        {{$item->course_name}}
                                    </td>
                                    <td>
                                        {{$item->title}}
                                    </td>

                                    <td>
                                        {{date('d-m-Y H:i',strtotime($item->lesson_start_date))}}
                                    </td>

                                    <td >
                                        @if((strtotime($item->lesson_start_date) >= strtotime(date('Y-m-d')) && (strtotime($item->lesson_start_date) < strtotime(date('Y-m-d').' +1 day'))) && empty($item->status))
                                            <label class="switch switch-lg switch-3d switch-primary">
                                                <input class="switch-input" type="checkbox" id="{{ $item->id}}" checked="checked" data-id="{{ $item->id}}">
                                                <span class="switch-label"></span>
                                                <span class="switch-handle"></span>
                                            </label>
                                        @elseif((strtotime($item->lesson_start_date) >= strtotime(date('Y-m-d').' +1 day')) && empty($item->status))
                                            --
                                        @else
                                        {{ $item->status == 1 ? 'Present' : 'Absent' }}
                                        @endif
                                    </td>

                                    <td>
                                        

                                        <a target="_blank" href="#"
                                           class="btn mb-1 btn-danger">
                                            @lang('labels.backend.invoices.fields.view')
                                        </a>

                                        

                                        
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('after-scripts')
    <script src="{{asset('plugins/amigo-sorter/js/amigo-sorter.min.js')}}"></script>

    <script>
        

        $(document).ready(function () {

            var table = $('#myTable').DataTable({
                processing: true,
                serverSide: false,
                iDisplayLength: 10,
                retrieve: true,


                columnDefs: [
                    {"width": "10%", "targets": 0},
                ],
                language:{
                    url : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/{{$locale_full_name}}.json",
                    buttons :{
                        colvis : '{{trans("datatable.colvis")}}',
                        pdf : '{{trans("datatable.pdf")}}',
                        csv : '{{trans("datatable.csv")}}',
                    }
                }

            });
        });

        $('ul.sorter').amigoSorter({
            li_helper: "li_helper",
            li_empty: "empty",
        });

        $(document).on('click', '.switch-input', function (e) {
            var id = $(this).data('id');
            var checked = $(this).is(':checked');
            $.ajax({
                type: "POST",
                url: "{{ route('admin.attendence.mark_attendence') }}",
                data: {
                    _token:'{{ csrf_token() }}',
                    id: id,
                    checked:checked
                },
            }).done(function() {
                location.reload();
            });
        })
    </script>
@endpush

