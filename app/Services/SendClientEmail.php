<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppraisalStatusUpdatedMail;

class SendClientEmail
{
    /**
     * Send client email when appraisal status change.
     *
     * @param int $clientId
     * @return void
     * @throws \Exception
     */
    public function execute(array $appraisal): void
    {
        $client = Client::findOrFail($appraisal['client_id']);

        Mail::to($client->email)->send(new AppraisalStatusUpdatedMail($client, $appraisal));
    }
}
