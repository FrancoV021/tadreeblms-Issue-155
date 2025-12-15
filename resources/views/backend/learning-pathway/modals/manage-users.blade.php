<div id="manage-pathway-users-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('user/learning-pathways/manage-users/' . $lp->id) }}" class="ajax" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Manage users for') }} {{ $lp->title }} learning pathway</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('Assigned Users')</label>
                        <select class="select2" name="user_ids[]" multiple>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->full_name }}({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info" id="save">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('[name="user_ids[]"]').select2();    
    $('[name="user_ids[]"]').val({{ json_encode($lp->learningPathwayUsers->pluck('user_id')->toArray()) }}).trigger(
        'change');
</script>
