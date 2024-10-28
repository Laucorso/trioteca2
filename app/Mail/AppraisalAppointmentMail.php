<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppraisalAppointmentMail extends Mailable
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
        return $this->subject('Recordatorio cita mañana')
                    ->view('emails.appraisal_appointment')
                    ->with([
                        'message' => 'Le recordamos que usted tiene una cita: ',
                        'client' => $this->client,
                        'appraisal' => $this->appraisal, //
                    ]);
    }
}