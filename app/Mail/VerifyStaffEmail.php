<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use App\Models\Admin;

class VerifyStaffEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $staff;

    /**
     * Create a new message instance.
     *
     * @param  Admin  $staff
     * @return void
     */
    public function __construct(Admin $staff)
    {
        $this->staff = $staff;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Verify Staff Email')
        ->markdown('admin.staffs.verify_email', ['staff' => $this->staff]);
    }
}
