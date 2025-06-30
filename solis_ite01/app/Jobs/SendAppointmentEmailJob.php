<?php

namespace App\Jobs;

use App\Mail\AppointmentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendAppointmentEmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected $student,
        protected $appointment
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->student->email)->send(new AppointmentCreated($this->appointment));
    }
}
