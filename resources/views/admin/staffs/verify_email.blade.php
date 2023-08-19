@component('mail::message')
# Verify Staff Email

<p>Hello {{ $staff->name }},</p>
<p>Thank you for registering as staff. To complete your registration, please click the button below to verify your email address:</p>

@component('mail::button', ['url' => route('admin.staff.setup', ['token' => $staff->verification_token])])
Verify Email
@endcomponent

<p>If you did not register as staff, please ignore this email.</p>
<p>Thanks,<br>General Trias Dairy Raisers Multi-Purpose Cooperative</p>
@endcomponent
