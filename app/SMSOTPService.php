<?php
namespace App;

use Vonage\Client as VonageClient;
use Vonage\Message\MessageInterface;

class SMSOTPService
{
    protected $vonage;

    public function __construct(VonageClient $vonage)
    {
        $this->vonage = $vonage;
    }

    public function generateAndSendOTP($phoneNumber)
    {
        $otp = rand(1000, 9999);

        // Store the OTP in your database or session for later verification

        $this->sendOTP($phoneNumber, $otp);
    }

    protected function sendOTP($phoneNumber, $otp)
    {
        $message = [
            'to' => $phoneNumber,
            'from' => config('app.VONAGE_SMS_FROM'),
            'text' => 'Your OTP: ' . $otp,
        ];

        /** @var MessageInterface $response */
        $response = $this->vonage->message()->send($message);

        // Handle the response and any errors
    }
}
