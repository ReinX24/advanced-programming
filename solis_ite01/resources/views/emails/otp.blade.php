{{-- resources/views/emails/otp.blade.php --}}

<x-mail::message>
# Your One-Time Password (OTP)

Hello!

You recently requested a One-Time Password (OTP) for your login to **{{ config('app.name') }}**.
Please use the following code to proceed:

<x-mail::panel>
# {{ $otp }}
</x-mail::panel>

This OTP is valid for **5 minutes**. For your security, please do not share this code with anyone.

If you did not request this OTP, please ignore this email. Your account remains secure.

Thanks,
{{ config('app.name') }} Team

<x-mail::subcopy>
If you're having trouble with the button above, copy and paste the URL below into your web browser: [{{ url('/') }}]({{ url('/') }})
</x-mail::subcopy>
</x-mail::message>
