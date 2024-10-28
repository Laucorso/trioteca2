<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\AppraisalStatusUpdated;
use App\Services\SendClientEmail;

class SendAppraisalStatusEmail
{

    protected $sendClientEmail;

    /**
     * Create the event listener.
     */
    public function __construct(SendClientEmail $sendClientEmail)
    {
        $this->sendClientEmail = $sendClientEmail;
    }

    /**
     * Handle the event.
     */

     public function handle(AppraisalStatusUpdated $event)
     {
        $appraisal = $event->appraisal;
        $this->sendClientEmail->execute($appraisal['client_id'], $appraisal);
     }
}
