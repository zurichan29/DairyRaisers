@component('mail::message')
# Verify Your Email

Please click the button below to verify your email address.

@component('mail::button', ['url' => route('email.verify', $user->email_verify_token)])
Verify Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
