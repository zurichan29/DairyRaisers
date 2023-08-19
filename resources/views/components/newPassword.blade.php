@component('mail::message')
# Reset Password

<p>Hello {{ $user->name }}!</p>
<p>Password Reset Instructions:</p>
@component('mail::panel')
You have requested to reset your account password. Please click the link below to set a new password:
@endcomponent
@component('mail::button', ['url' => route('reset_password.new-password', ['token' => $user->reset_password_token, 'email' => $user->email])])
Reset Passowrd    
@endcomponent
<br>
<p>If you didn't request this password reset, please ignore this email. Your account security is important to us.</p>
<br>

<p>Thanks,<br>{{ config('app.name') }}</p>
@endcomponent
