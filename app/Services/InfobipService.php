<?php

namespace App\Services;

use Infobip;
// use Infobip\InfobipClient;
use Infobip\Models\Destination;
use Infobip\Models\ShortMessage\TextualRequest;

class InfobipService
{
    private $infobip;

    public function __construct(InfobipClient $infobip)
    {
        $this->infobip = $infobip;
    }

    public function sendOTP($phoneNumber, $otp)
    {
        $destination = new Destination();
        $destination->setTo($phoneNumber);

        $message = "Your OTP is: " . $otp;

        $smsRequest = new TextualRequest();
        $smsRequest->setFrom("YourSenderID"); // Set your desired sender ID or phone number
        $smsRequest->setDestinations([$destination]);
        $smsRequest->setText($message);

        $this->infobip->sms()->send($smsRequest);
    }
}
