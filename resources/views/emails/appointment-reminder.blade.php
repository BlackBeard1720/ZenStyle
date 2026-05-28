@php
    $customerName = $appointment->client?->full_name ?? 'Customer';

    $appointmentDate = $appointment->appointment_date
        ? \Illuminate\Support\Carbon::parse($appointment->appointment_date)->format('d/m/Y')
        : 'N/A';

    $appointmentTime = $appointment->appointment_time
        ? \Illuminate\Support\Carbon::parse($appointment->appointment_time)->format('H:i')
        : 'N/A';

    $serviceItems = $appointment->appointmentServices ?? collect();
    $formatMoney = static fn ($amount) => '$' . number_format((float) ($amount ?? 0), 2, '.', ',');
    $totalAmount = $formatMoney($appointment->total_amount);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZenStyle Appointment Reminder</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f7f6;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background-color:#f4f7f6;padding:24px 12px;">
    <tr><td align="center">
        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="max-width:640px;background-color:#ffffff;border-radius:10px;overflow:hidden;border:1px solid #e5e7eb;">
            <tr><td style="background-color:#0f766e;padding:24px 28px;color:#ffffff;">
                <p style="margin:0;font-size:24px;font-weight:700;letter-spacing:0.4px;">ZenStyle</p>
                <p style="margin:8px 0 0 0;font-size:14px;opacity:0.95;">Appointment Reminder</p>
            </td></tr>
            <tr><td style="padding:24px 28px;">
                <p style="margin:0 0 14px 0;font-size:24px;font-weight:700;color:#111827;">Your Appointment Is Coming Up</p>
                <p style="margin:0 0 14px 0;font-size:16px;line-height:1.6;">Hello {{ $customerName }},</p>
                <p style="margin:0 0 18px 0;font-size:15px;line-height:1.6;color:#374151;">This is a friendly reminder for your upcoming appointment at ZenStyle.</p>

                <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #d1fae5;border-radius:8px;background-color:#f0fdfa;margin-bottom:18px;">
                    <tr><td style="padding:16px 18px;">
                        <p style="margin:0 0 12px 0;font-size:15px;font-weight:700;color:#065f46;">Appointment Summary</p>
                        <p style="margin:0 0 7px 0;font-size:14px;"><strong>Appointment ID:</strong> #{{ $appointment->id }}</p>
                        <p style="margin:0 0 7px 0;font-size:14px;"><strong>Appointment date:</strong> {{ $appointmentDate }}</p>
                        <p style="margin:0 0 7px 0;font-size:14px;"><strong>Appointment time:</strong> {{ $appointmentTime }}</p>
                        <p style="margin:0;font-size:14px;"><strong>Status:</strong> Confirmed</p>
                    </td></tr>
                </table>

                <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;border:1px solid #e5e7eb;margin-bottom:18px;">
                    <tr style="background-color:#f9fafb;">
                        <th style="text-align:left;padding:10px;border:1px solid #e5e7eb;font-size:13px;">Service</th>
                        <th style="text-align:left;padding:10px;border:1px solid #e5e7eb;font-size:13px;">Staff</th>
                        <th style="text-align:left;padding:10px;border:1px solid #e5e7eb;font-size:13px;">Price at booking</th>
                        <th style="text-align:left;padding:10px;border:1px solid #e5e7eb;font-size:13px;">Duration</th>
                    </tr>
                    @forelse ($serviceItems as $item)
                        <tr>
                            <td style="padding:10px;border:1px solid #e5e7eb;font-size:14px;">{{ $item->service?->name ?? 'Service unavailable' }}</td>
                            <td style="padding:10px;border:1px solid #e5e7eb;font-size:14px;">{{ $item->staff?->full_name ?? 'Any available staff' }}</td>
                            <td style="padding:10px;border:1px solid #e5e7eb;font-size:14px;">{{ $formatMoney($item->price_at_booking) }}</td>
                            <td style="padding:10px;border:1px solid #e5e7eb;font-size:14px;">{{ $item->service?->duration ? $item->service->duration . ' min' : 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="padding:10px;border:1px solid #e5e7eb;font-size:14px;color:#6b7280;">No services were attached to this appointment.</td></tr>
                    @endforelse
                </table>

                <p style="margin:0 0 12px 0;font-size:15px;font-weight:700;color:#111827;">Estimated total amount: <span style="color:#0f766e;">{{ $totalAmount }}</span></p>
                <p style="margin:0 0 10px 0;font-size:14px;line-height:1.7;color:#374151;">Please arrive 5–10 minutes early so our staff can prepare your service.</p>
                <p style="margin:0;font-size:14px;line-height:1.7;color:#374151;">Thank you for choosing ZenStyle.</p>
            </td></tr>
        </table>
    </td></tr>
</table>
</body>
</html>
