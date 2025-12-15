@component('mail::message')
Hello

Please click to below link to reset your password
<a href="{{ route('admin.account') }}">Reset Password Link</a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
