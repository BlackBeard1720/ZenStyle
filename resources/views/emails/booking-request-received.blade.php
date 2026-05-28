<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Appointment Request Received</title>
</head>
<body style="margin:0;padding:0;background:#f4f7f6;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f7f6;padding:24px 0;">
  <tr>
    <td align="center">
      <table width="600" cellpadding="0" cellspacing="0" style="width:600px;max-width:100%;background:#ffffff;border-radius:14px;overflow:hidden;border:1px solid #e5e7eb;">
        <tr>
          <td style="background:#0f766e;padding:24px 28px;color:#ffffff;">
            <h1 style="margin:0;font-size:24px;line-height:1.3;">ZenStyle</h1>
            <p style="margin:6px 0 0;font-size:14px;opacity:.9;">Appointment Request Received</p>
          </td>
        </tr>

        <tr>
          <td style="padding:28px;">
            <h2 style="margin:0 0 12px;font-size:22px;color:#111827;">Appointment Request Received</h2>

            <p style="margin:0 0 14px;font-size:15px;line-height:1.6;">
              Hello {{ $appointment->client?->full_name ?? 'Customer' }},
            </p>

            <p style="margin:0 0 14px;font-size:15px;line-height:1.6;">
              We have received your appointment request.
            </p>

            <p style="margin:0 0 16px;font-size:15px;line-height:1.6;">
              Your appointment is currently pending confirmation from ZenStyle.
              Our staff will review your request and notify you once it has been confirmed.
            </p>

            <div style="margin:18px 0;padding:14px 16px;background:#fff7ed;border:1px solid #fed7aa;border-radius:10px;color:#9a3412;font-size:14px;line-height:1.5;">
              <strong>Please note:</strong> your appointment is not confirmed yet.
            </div>

            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px;border-collapse:collapse;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
              <tr>
                <td colspan="2" style="padding:14px 16px;background:#f9fafb;font-weight:bold;color:#111827;">
                  Request Summary
                </td>
              </tr>
              <tr>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;color:#6b7280;">Appointment ID</td>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;text-align:right;">#{{ $appointment->id }}</td>
              </tr>
              <tr>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;color:#6b7280;">Date</td>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;text-align:right;">
                  {{ optional($appointment->appointment_date)->format('d/m/Y') }}
                </td>
              </tr>
              <tr>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;color:#6b7280;">Time</td>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;text-align:right;">
                  {{ $appointment->appointment_time }}
                </td>
              </tr>
              <tr>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;color:#6b7280;">Status</td>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;text-align:right;">
                  Pending
                </td>
              </tr>
            </table>

            @if($appointment->appointmentServices->isNotEmpty())
              <h3 style="margin:24px 0 10px;font-size:16px;color:#111827;">Requested Services</h3>

              <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
                <tr style="background:#f9fafb;">
                  <th align="left" style="padding:12px 14px;font-size:13px;color:#374151;border-bottom:1px solid #e5e7eb;">Service</th>
                  <th align="right" style="padding:12px 14px;font-size:13px;color:#374151;border-bottom:1px solid #e5e7eb;">Price</th>
                </tr>

                @foreach($appointment->appointmentServices as $item)
                  <tr>
                    <td style="padding:12px 14px;border-bottom:1px solid #f3f4f6;">
                      {{ $item->service?->name ?? 'Service' }}
                      @if($item->service?->duration)
                        <br>
                        <span style="font-size:12px;color:#6b7280;">
                                                    {{ $item->service->duration }} minutes
                                                </span>
                      @endif
                    </td>
                    <td align="right" style="padding:12px 14px;border-bottom:1px solid #f3f4f6;">
                      ${{ number_format((float) $item->price_at_booking, 2) }}
                    </td>
                  </tr>
                @endforeach
              </table>
            @endif

            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:18px;">
              <tr>
                <td style="font-size:15px;color:#111827;font-weight:bold;">Estimated Total</td>
                <td align="right" style="font-size:18px;color:#0f766e;font-weight:bold;">
                  ${{ number_format((float) $appointment->total_amount, 2) }}
                </td>
              </tr>
            </table>

            <p style="margin:24px 0 0;font-size:14px;line-height:1.6;color:#4b5563;">
              Thank you for choosing ZenStyle. We will contact you again once your appointment has been confirmed.
            </p>
          </td>
        </tr>

        <tr>
          <td style="padding:18px 28px;background:#f9fafb;color:#6b7280;font-size:12px;text-align:center;">
            © {{ date('Y') }} ZenStyle. All rights reserved.
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
