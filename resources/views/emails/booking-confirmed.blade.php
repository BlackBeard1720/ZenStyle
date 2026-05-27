@php
    $customerName = $appointment->client?->full_name ?? 'Customer';
    $customerPhone = $appointment->client?->phone ?? 'N/A';
    $customerEmail = $appointment->client?->email;

    $appointmentDate = $appointment->appointment_date
        ? \Illuminate\Support\Carbon::parse($appointment->appointment_date)->format('d/m/Y')
        : 'N/A';

    $appointmentTime = $appointment->appointment_time
        ? \Illuminate\Support\Carbon::parse($appointment->appointment_time)->format('H:i')
        : 'N/A';

    $staffName = $appointment->appointmentServices?->first()?->staff?->full_name ?? 'Any available staff';
    $status = $appointment->status ? ucfirst((string) $appointment->status) : 'Pending';
    $notes = trim((string) ($appointment->notes ?? ''));

    $serviceItems = $appointment->appointmentServices ?? collect();

    $formatMoney = static fn ($amount) => '$' . number_format((float) ($amount ?? 0), 2, '.', ',');
    $totalAmount = $formatMoney($appointment->total_amount);

    $supportEmail = config('mail.from.address');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZenStyle Appointment Confirmation</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f7f6;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background-color:#f4f7f6;padding:24px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="max-width:640px;background-color:#ffffff;border-radius:10px;overflow:hidden;border:1px solid #e5e7eb;">
                <tr>
                    <td style="background-color:#0f766e;padding:24px 28px;color:#ffffff;">
                        <p style="margin:0;font-size:24px;font-weight:700;letter-spacing:0.4px;">ZenStyle</p>
                        <p style="margin:8px 0 0 0;font-size:14px;opacity:0.95;">Appointment Booking Confirmation</p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:24px 28px;">
                        <p style="margin:0 0 14px 0;font-size:16px;line-height:1.6;">Hello {{ $customerName }},</p>
                        <p style="margin:0 0 18px 0;font-size:15px;line-height:1.6;color:#374151;">Your appointment has been booked successfully.</p>

                        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #d1fae5;border-radius:8px;background-color:#f0fdfa;margin-bottom:18px;">
                            <tr>
                                <td style="padding:16px 18px;">
                                    <p style="margin:0 0 12px 0;font-size:15px;font-weight:700;color:#065f46;">Appointment Summary</p>

                                    <p style="margin:0 0 7px 0;font-size:14px;"><strong>Appointment ID:</strong> #{{ $appointment->id }}</p>
                                    <p style="margin:0 0 7px 0;font-size:14px;"><strong>Customer name:</strong> {{ $customerName }}</p>
                                    <p style="margin:0 0 7px 0;font-size:14px;"><strong>Phone:</strong> {{ $customerPhone }}</p>
                                    @if (! empty($customerEmail))
                                        <p style="margin:0 0 7px 0;font-size:14px;"><strong>Email:</strong> {{ $customerEmail }}</p>
                                    @endif
                                    <p style="margin:0 0 7px 0;font-size:14px;"><strong>Appointment date:</strong> {{ $appointmentDate }}</p>
                                    <p style="margin:0 0 7px 0;font-size:14px;"><strong>Appointment time:</strong> {{ $appointmentTime }}</p>
                                    <p style="margin:0 0 7px 0;font-size:14px;"><strong>Staff:</strong> {{ $staffName }}</p>
                                    <p style="margin:0 0 7px 0;font-size:14px;"><strong>Status:</strong> {{ $status }}</p>
                                    @if ($notes !== '')
                                        <p style="margin:0;font-size:14px;line-height:1.6;"><strong>Notes:</strong> {{ $notes }}</p>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #e5e7eb;border-radius:8px;background-color:#ffffff;margin-bottom:18px;">
                            <tr>
                                <td style="padding:16px 18px;">
                                    <p style="margin:0 0 12px 0;font-size:15px;font-weight:700;color:#111827;">Selected Services</p>
                                    @if ($serviceItems->isNotEmpty())
                                        @foreach ($serviceItems as $item)
                                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;border-bottom:1px solid #f3f4f6;padding-bottom:10px;">
                                                <tr>
                                                    <td style="font-size:14px;line-height:1.5;color:#374151;">
                                                        <strong>{{ $item->service?->name ?? 'Service unavailable' }}</strong><br>
                                                        @if (! empty($item->service?->duration))
                                                            Duration: {{ $item->service->duration }} min<br>
                                                        @endif
                                                        Price: {{ $formatMoney($item->price_at_booking) }}
                                                    </td>
                                                </tr>
                                            </table>
                                        @endforeach
                                    @else
                                        <p style="margin:0;font-size:14px;color:#6b7280;">No services were attached to this appointment.</p>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #e5e7eb;border-radius:8px;background-color:#ffffff;margin-bottom:18px;">
                            <tr>
                                <td style="padding:16px 18px;">
                                    <p style="margin:0 0 8px 0;font-size:15px;font-weight:700;color:#111827;">Total Amount</p>
                                    <p style="margin:0;font-size:16px;font-weight:700;color:#0f766e;">{{ $totalAmount }}</p>
                                </td>
                            </tr>
                        </table>

                        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #e5e7eb;border-radius:8px;background-color:#ffffff;">
                            <tr>
                                <td style="padding:16px 18px;">
                                    <p style="margin:0 0 8px 0;font-size:15px;font-weight:700;color:#111827;">Salon Information</p>
                                    <p style="margin:0 0 6px 0;font-size:14px;line-height:1.6;"><strong>Salon name:</strong> ZenStyle</p>
                                    <p style="margin:0;font-size:14px;line-height:1.6;color:#4b5563;">Our staff may contact you if any schedule adjustment is needed before your appointment.</p>
                                </td>
                            </tr>
                        </table>

                        <p style="margin:20px 0 0 0;font-size:14px;line-height:1.7;color:#374151;">Thank you for choosing ZenStyle.</p>
                        <p style="margin:10px 0 0 0;font-size:13px;line-height:1.7;color:#6b7280;">
                            @if (! empty($supportEmail))
                                Need support? Contact us at {{ $supportEmail }}.
                            @else
                                Need support? Please reply to this email and our team will assist you.
                            @endif
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
