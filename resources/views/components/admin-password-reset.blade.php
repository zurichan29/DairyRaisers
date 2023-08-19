@component('mail::message')
# Reset Password Notification

<p>You are receiving this email because we received a password reset request for your account.</p>
@component('mail::button', ['url' => route('admin.password.reset', ['token' => $token, 'email' => $user->getEmailForPasswordReset()])])
Reset Password
@endcomponent
<p>This password reset link will expire in :count minutes.</p>
<p>If you did not request a password reset, no further action is required.</p>
@endcomponent
