<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appraisal;
use App\Models\User;
use Carbon\Carbon;
use App\Jobs\SendAppointmentReminderJob;
use App\Services\SendClientUserEmailAppointment;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:send-reminders';

    protected $description = 'Send appointment reminders to reponsable users and client the day before to prevent problems';

    protected $sendClientUserEmailAppointment;

    public function __construct(SendClientUserEmailAppointment $sendClientUserEmailAppointment)
    {
        parent::__construct();
        $this->sendClientUserEmailAppointment = $sendClientUserEmailAppointment;
    }

    public function handle()
    {
        $tomorrow = Carbon::now()->addDay()->startOfDay();
        $appraisals = Appraisal::whereDate('next_appointment', $tomorrow)->get();

        foreach ($appraisals as $appraisal) {
            $user = $appraisal->managedByUser;
            if ($user) {
                $this->sendClientUserEmailAppointment->execute([$user->email,$appraisal->client->email], $appraisal, $appraisal->client);
            }
        }

        $this->info('Reminders sent successfully.');
    }
}
