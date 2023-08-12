@component('mail::message')
    # Verify Email

    Hello {{ $user->first_name }},

    Thank you for registering to Dairy Raisers. To complete your registration, please click the button below to verify your email
    address:

    @component('mail::button', ['url' => route('register.email.validate', ['token' => $user->email_verify_token, 'email' => $user->email])])
        Verify Email
    @endcomponent

    If you did not register as user, please ignore this email.

    Thanks,<br>
    General Trias Dairy Raisers Multi-Purpose Cooperative
@endcomponent



{{-- @component('mail::message')
# Verify Your Email

Please click the button below to verify your email address.

@component('mail::button', ['url' => route('email.verify', ['token' => $user->email_verify_token, 'email' => $user->email])])
Verify Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent --}}
