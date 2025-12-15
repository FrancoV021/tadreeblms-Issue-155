<!-- Reminder Email Modal -->
<div class="modal fade" id="reminderEmailModal" tabindex="-1" aria-labelledby="reminderEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reminderEmailModalLabel">Send Reminder Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="reminderEmailForm" method="post" class="ajax" action="/user/send-reminder/{{ $id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="emailContent" class="form-label">Email Content</label>
                        <textarea class="form-control" id="emailContent" name="email_content" rows="5"
                            placeholder="Enter the email content here...">{{ $email_content }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send Email</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        ClassicEditor
            .create($('#emailContent')[0]) // Use jQuery to select the element
            .then(editor => {
                console.log('Editor initialized');
                // Optionally store the editor instance for later use
                $('#emailContent').data('editor', editor);
            })
            .catch(error => {
                console.error('There was a problem initializing the editor.', error);
            });
    });
</script>
