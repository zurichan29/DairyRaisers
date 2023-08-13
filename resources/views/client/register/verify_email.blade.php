@component('mail::message')
# Verify Email

<p>Hello {{ $user->first_name }},</p>
<p>Thank you for registering to Dairy Raisers. To complete your registration, please click the button below to verify your email address:</p>

@component('mail::button', ['url' => route('register.email.validate', ['token' => $user->email_verify_token, 'email' => $user->email])])
Verify Email
@endcomponent

<p>If you did not register as user, please ignore this email.</p>
<p>Thanks,<br> General Trias Dairy Raisers Multi-Purpose Cooperative</p>
@endcomponent

