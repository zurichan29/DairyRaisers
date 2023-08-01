@component('mail::message')
    # Verify Staff Email

    Hello {{ $staff->name }},

    Thank you for registering as staff. To complete your registration, please click the button below to verify your email
    address:

    @component('mail::button', ['url' => route('admin.staff.setup', ['token' => $staff->verification_token])])
        Verify Email
    @endcomponent

    If you did not register as staff, please ignore this email.

    Thanks,<br>
    Your Company Name
@endcomponent
