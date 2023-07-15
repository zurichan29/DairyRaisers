@component('mail::message')
# Verify Your Email

Please click the button below to verify your email address.

@component('mail::button', ['url' => route('email.verify', ['token' => $user->email_verify_token, 'email' => $user->email])])
Verify Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
