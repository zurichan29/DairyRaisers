<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;
use App\Models\Admin;

class AdminResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $user; // Add this property

    public function __construct($token, Admin $user) // Modify the constructor
    {
        $this->token = $token;
        $this->user = $user;
    }

    public function build()
    {
        $resetUrl = route('admin.password.reset', [
            'token' => $this->token,
            'email' => $this->user->getEmailForPasswordReset()
        ], false);

        return $this->subject(Lang::get('Reset Password Notification'))
        ->markdown('components.admin-password-reset')
        ->with(['user' => $this->user, 'token' => $this->token]);

        // return $this->subject(Lang::get('Reset Password Notification'))
        //     ->markdown('components.admin-password-reset', ['resetUrl' => $resetUrl]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Admin Reset Password Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
