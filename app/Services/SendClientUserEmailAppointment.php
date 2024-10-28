<?php

namespace App\Services;

use App\Mail\AppraisalAppointmentMail;
use App\Models\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppraisalStatusUpdatedMail;

class SendClientUserEmailAppointment
{
    /**
     * Send client email when appraisal status change.
     *
     * @param int $clientId
     * @return void
     * @throws \Exception
     */
    public function execute(array $emails, array $client, array $appraisal): void
    {
        Mail::to($emails)->send(new AppraisalAppointmentMail($client, $appraisal));
    }
}