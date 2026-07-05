<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Services\WhatsAppService;
use Carbon\Carbon;

class SendAppointmentWhatsAppReminder extends Command
{
    protected $signature = 'appointment:whatsapp-reminder {to?} {message?}';
    protected $description = 'Send a test WhatsApp message or reminders for appointments';

    public function handle(WhatsAppService $whatsAppService)
    {
        $to = $this->argument('to');
        $message = $this->argument('message');
        if ($to && $message) {
            try {
                $whatsAppService->sendMessage($to, $message);
                $this->info("Test WhatsApp message sent to $to");
            } catch (\Exception $e) {
                $this->error("Failed to send to $to: " . $e->getMessage());
            }
            return 0;
        }

        $date = Carbon::today()->toDateString();
        $appointments = Appointment::whereDate('appointmentDate', $date)->get();

        if ($appointments->isEmpty()) {
            $this->info('No appointments found for ' . $date);
            return 0;
        }

        foreach ($appointments as $appointment) {
            if (empty($appointment->patientTel)) {
                $this->warn("No phone number for appointment ID: {$appointment->id}");
                continue;
            }
            $message = "Reminder: Dear {$appointment->patientName}, you have an appointment on {$appointment->appointmentDate} at {$appointment->appointmentTime}.";
            try {
                $whatsAppService->sendMessage($appointment->patientTel, $message);
                $this->info("WhatsApp reminder sent to {$appointment->patientTel}");
            } catch (\Exception $e) {
                $this->error("Failed to send to {$appointment->patientTel}: " . $e->getMessage());
            }
        }
        return 0;
    }
}
