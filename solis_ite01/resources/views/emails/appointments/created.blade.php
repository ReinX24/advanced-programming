<x-mail::message>
    # Appointment Confirmation

    Dear {{ $student->fname }},

    This email is to confirm that your new appointment has been successfully scheduled.

    **Appointment Details:**
    * **Title:** {{ $appointment->title }}
    * **Date:** {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}
    * **Time:** {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
    * **Remarks:** {{ $appointment->remarks ?? 'N/A' }}
    * **Status:** {{ $appointment->status }}

    Please make sure to be prepared for your appointment.

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
