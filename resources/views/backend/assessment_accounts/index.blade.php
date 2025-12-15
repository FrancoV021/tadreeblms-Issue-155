@extends('backend.layouts.app')
@section('title', __('Assessments').' | '.app_name())
@push('after-styles')
<link rel="stylesheet" href="{{asset('assets/css/colors/switch.css')}}">
@endpush
@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('Assessment Accounts')</h3>
        @can('course_create')
        <div class="float-right">
            <!-- <a href="{{ route('admin.assessment_accounts.create') }}" class="btn btn-success">@lang('strings.backend.general.app_add_new')</a> -->
            <a href="{{ route('admin.assessment_accounts.new-assisment') }}?show_type=1" class="btn btn-success">@lang('strings.backend.general.app_add_new')</a>
        </div>
        @endcan
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered table-striped @if(auth()->user()->isAdmin()) @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>@lang('First Name')</th>
                                <th>@lang('Last Name')</th>
                                <th>@lang('Email')</th>
                                <th>@lang('Phone')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Assignments')</th>
                                <th>&nbsp; @lang('strings.backend.general.actions')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($assessment_accounts as $key=> $value)
                            <tr>
                                <td> {{$value->code}} </td>
                                <td> {{$value->first_name}} </td>
                                <td> {{$value->last_name}} </td>
                                <td> {{$value->email}} </td>
                                <td> {{$value->phone}} </td>
                                <td> <label class="switch switch-lg switch-3d switch-primary"><input class="switch-input" type="checkbox" value="<?= $value->active == 1 ? 1 : 0 ?>" id="{{$value->id}}" <?= $value->active == 1 ? "checked" : "" ?> data-id="{{$value->id}}"><span class="switch-label"></span><span class="switch-handle"></span></label> </td>
                                <td>
                                    <a href="{{ route('admin.assessment_accounts.account_assignments', ['id'=>$value->id, 'type'=>1]) }}" class="btn btn-xs btn-primary mb-1"><i class="fa fa-tasks"></i></a>
                                </td>
                                <td class="btnsflex">
                                    <a href="{{ route('admin.assessment_accounts.show', ['assessment_account' => $value->id]) }}" class="btn btn-xs btn-primary mb-1"><i class="icon-eye"></i></a>
                                    <a href="{{ route('admin.assessment_accounts.edit', ['assessment_account' => $value->id]) }}" class="btn btn-xs btn-info mb-1"><i class="icon-pencil"></i></a>
                                    <a data-method="delete" data-trans-button-cancel="Cancel" data-trans-button-confirm="Delete" data-trans-title="Are you sure you want to do this?" class="btn btn-xs btn-danger text-white mb-1" style="cursor:pointer;" onclick="$(this).find('form').submit();">
                                        <svg class="svg-inline--fa fa-trash fa-w-14" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" aria-hidden="true" data-prefix="fa" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                            <path fill="currentColor" d="M0 84V56c0-13.3 10.7-24 24-24h112l9.4-18.7c4-8.2 12.3-13.3 21.4-13.3h114.3c9.1 0 17.4 5.1 21.5 13.3L312 32h112c13.3 0 24 10.7 24 24v28c0 6.6-5.4 12-12 12H12C5.4 96 0 90.6 0 84zm415.2 56.7L394.8 467c-1.6 25.3-22.6 45-47.9 45H101.1c-25.3 0-46.3-19.7-47.9-45L32.8 140.7c-.4-6.9 5.1-12.7 12-12.7h358.5c6.8 0 12.3 5.8 11.9 12.7z"></path>
                                        </svg>
                                        <form action="{{ route('admin.assessment_accounts.destroy', ['assessment_account' => $value->id]) }}" method="POST" name="delete_item" style="display:none">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}"> <input type="hidden" name="_method" value="DELETE">
                                        </form>
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
<script>
    $(document).ready(function() {
        $('#myTable').dataTable({
            "paginate": true,
            "sort": true,
            "language": {
                "emptyTable": "No Data Is Available."
            },
            "order": [
                [0, "desc"]
            ],
            dom: 'lfBrtip<"actions">',
            buttons: [{
                    extend: 'csv',
                    exportOptions: {
                        columns: [1, 2, 3, 4]
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [1, 2, 3, 4],
                    }
                },
                'colvis'
            ]
        });
    });

    $(document).on('click', '.switch-input', function(e) {
        var id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: "{{ route('admin.assessment_accounts.status') }}",
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
            },
        }).done(function() {
            var table = $('#myTable').DataTable();
        });
    })
</script>

@endpush