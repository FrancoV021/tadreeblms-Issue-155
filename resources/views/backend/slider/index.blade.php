@extends('backend.layouts.app')

@section('title', __('labels.backend.hero_slider.title').' | '.app_name())

@push('after-styles')
<link rel="stylesheet" type="text/css" href="{{asset('plugins/amigo-sorter/css/theme-default.css')}}">
<style>
    ul.sorter>span {
        display: inline-block;
        width: 100%;
        height: 100%;
        background: #f5f5f5;
        color: #333333;
        border: 1px solid #cccccc;
        border-radius: 5px;
        padding: 0px;
        height: 32px !important;
    }

    ul.sorter li>span .title {
        padding-left: 15px;
    }

    ul.sorter li>span .btn {
        width: 20%;
    }

    .dropdown-item {
        border-bottom: none;
    }
</style>
@endpush

@section('content')

<div class="pb-3 d-flex justify-content-between align-items-center">
    <h4>@lang('labels.backend.hero_slider.title')</h4>
    <div>
        <a href="{{ route('admin.sliders.create') }}" class="add-btn">
            @lang('strings.backend.general.app_add_new')
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="myTable" class="table custom-teacher-table table-striped">
                <thead>
                    <tr>
                        <th>@lang('labels.general.sr_no')</th>
                        <th>ID</th>
                        <th>@lang('labels.backend.hero_slider.fields.name')</th>
                        <th>@lang('labels.backend.hero_slider.fields.bg_image')</th>
                        <th>@lang('labels.backend.hero_slider.fields.sequence')</th>
                        <th>@lang('labels.backend.hero_slider.fields.status')</th>
                        <th class="text-center">@lang('strings.backend.general.actions')</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($slides_list as $key => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->id }}</td>

                        <td>{{ $item->name }}</td>

                        <td>
                            <img src="{{ asset('storage/uploads/'.$item->bg_image) }}" height="50">
                        </td>

                        <td>{{ $item->sequence }}</td>

                        <td>
                            <div class="custom-control custom-switch">
                                <input type="checkbox"
                                    class="custom-control-input status-toggle"
                                    id="switch{{ $item->id }}"
                                    data-id="{{ $item->id }}"
                                    value="1"
                                    {{ $item->status ? 'checked' : '' }}>
                                <label class="custom-control-label"
                                       for="switch{{ $item->id }}">
                                </label>
                            </div>
                        </td>

                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm p-1" type="button"
                                    id="actionDropdown{{ $item->id }}"
                                    data-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v text-muted"></i>
                                </button>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="{{ route('admin.sliders.edit', $item->id) }}" class="dropdown-item">
                                        Edit
                                    </a>

                                    <a class="dropdown-item" style="cursor:pointer;"
                                        onclick="$(this).find('form').submit();">
                                        Delete
                                        <form action="{{ route('admin.sliders.destroy', $item->id) }}"
                                              method="POST" style="display:none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </a>
                                </div>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>

{{-- Sequence Section --}}
<div class="pb-3">
    <h4>@lang('labels.backend.hero_slider.manage_sequence')</h4>
</div>

<div class="card">
    <div class="card-body">

        @if(count($slides_list))
        <div class="row justify-content-center">
            <div class="col-md-6">

                <h4>@lang('labels.backend.hero_slider.sequence_note')</h4>

                <ul class="sorter list-unstyled">
                    @foreach($slides_list as $item)
                    <li class="mb-2">
                        <span data-id="{{ $item->id }}"
                              data-sequence="{{ $item->sequence }}"
                              class="d-block p-2 bg-light border rounded">
                            <span class="ml-2">{{ $item->name }}</span>
                        </span>
                    </li>
                    @endforeach
                </ul>

                <div class="d-flex justify-content-between mt-3">

                    <a href="{{ route('admin.courses.index') }}" class="cancel-btn">
                        @lang('strings.backend.general.app_back_to_list')
                    </a>

                    <a href="#" id="save_timeline" class="add-btn">
                        @lang('labels.backend.hero_slider.save_sequence')
                    </a>

                </div>
            </div>
        </div>
        @endif

    </div>
</div>

@endsection


@push('after-scripts')
<script src="{{asset('plugins/amigo-sorter/js/amigo-sorter.min.js')}}"></script>

<script>
    $(document).ready(function() {

        $('#myTable').DataTable({
            processing: true,
            serverSide: false,
            iDisplayLength: 10,
            retrieve: true,
            dom: 'lfBrtip<"actions">',
            buttons: [{
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, 1, 2, 4]
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 4]
                    }
                },
                'colvis'
            ],

            columnDefs: [{
                    "width": "10%",
                    "targets": 0
                },
                {
                    "width": "15%",
                    "targets": 4
                },
                {
                    "className": "text-center",
                    "targets": [0]
                }
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/{{$locale_full_name}}.json",
                buttons: {
                    colvis: '{{trans("datatable.colvis")}}',
                    pdf: '{{trans("datatable.pdf")}}',
                    csv: '{{trans("datatable.csv")}}',
                },
                search: "",
            },
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

    $('ul.sorter').amigoSorter({
        li_helper: "li_helper",
        li_empty: "empty",
    });
    $(document).on('click', '#save_timeline', function(e) {
        e.preventDefault();
        var list = [];
        $('ul.sorter li').each(function(key, value) {
            key++;
            var val = $(value).find('span').data('id');
            list.push({
                id: val,
                sequence: key
            });
        });

        $.ajax({
            method: 'POST',
            url: "{{route('admin.sliders.saveSequence')}}",
            data: {
                _token: '{{csrf_token()}}',
                list: list
            }
        }).done(function() {
            location.reload();
        });
    })

    // $(document).on('click', '.switch-input', function (e) {
    //     var id = $(this).data('id');
    //     $.ajax({
    //         type: "POST",
    //         url: "{{ route('admin.sliders.status') }}",
    //         data: {
    //             _token:'{{ csrf_token() }}',
    //             id: id,
    //         },
    //     }).done(function() {
    //         location.reload();
    //     });
    // })
    $(document).on('change', '.status-toggle', function(e) {
        var id = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "{{ route('admin.sliders.status') }}",
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
            },
            success: function() {
                location.reload(); // Optional: reload or toast or DOM update
            },
            error: function() {
                alert('Failed to update status.');
            }
        });
    });
</script>
@endpush