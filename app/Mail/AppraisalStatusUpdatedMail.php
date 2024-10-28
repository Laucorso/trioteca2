<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppraisalStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $appraisal;

    /**
     * Create a new message instance.
     *
     * @param $client
     * @param $appraisal
     */
    public function __construct($client, $appraisal)
    {
        $this->client = $client;
        $this->appraisal = $appraisal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Estado de Tasación Actualizado')
                    ->view('emails.appraisal_status_updated')
                    ->with([
                        'message' => 'El estado de la siguiente tasación ha cambiado: ',
                        'clientName' => $this->client->name,
                        'appraisal' => $this->appraisal, 
                    ]);
    }
}

