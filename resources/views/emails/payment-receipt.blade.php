<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Receipt</title>
</head>
<body style="margin:0;padding:0;background:#f4f7f6;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
@php
  $appointment = $payment->appointment;
  $client = $appointment?->client;
  $services = $appointment?->appointmentServices ?? collect();

  $paymentMethod = match ($payment->payment_method) {
      'cash' => 'Cash',
      'paypal' => 'PayPal',
      'bank_transfer' => 'Bank Transfer',
      default => ucfirst(str_replace('_', ' ', (string) $payment->payment_method)),
  };

  $receiptNo = 'PAY-' . str_pad((string) $payment->id, 6, '0', STR_PAD_LEFT);
@endphp

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f7f6;padding:24px 0;">
  <tr>
    <td align="center">
      <table width="640" cellpadding="0" cellspacing="0" style="width:640px;max-width:100%;background:#ffffff;border-radius:14px;overflow:hidden;border:1px solid #e5e7eb;">
        <tr>
          <td style="background:#0f766e;padding:24px 28px;color:#ffffff;">
            <h1 style="margin:0;font-size:24px;line-height:1.3;">ZenStyle</h1>
            <p style="margin:6px 0 0;font-size:14px;opacity:.9;">Payment Receipt</p>
          </td>
        </tr>

        <tr>
          <td style="padding:28px;">
            <h2 style="margin:0 0 12px;font-size:22px;color:#111827;">Payment Completed</h2>

            <p style="margin:0 0 14px;font-size:15px;line-height:1.6;">
              Hello {{ $client?->full_name ?? 'Customer' }},
            </p>

            <p style="margin:0 0 18px;font-size:15px;line-height:1.6;">
              Thank you for your payment. Your payment has been completed successfully.
            </p>

            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:18px;border-collapse:collapse;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
              <tr>
                <td colspan="2" style="padding:14px 16px;background:#f9fafb;font-weight:bold;color:#111827;">
                  Receipt Summary
                </td>
              </tr>
              <tr>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;color:#6b7280;">Receipt No.</td>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;text-align:right;">{{ $receiptNo }}</td>
              </tr>
              <tr>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;color:#6b7280;">Appointment ID</td>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;text-align:right;">#{{ $appointment?->id }}</td>
              </tr>
              <tr>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;color:#6b7280;">Payment Date</td>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;text-align:right;">
                  {{ optional($payment->paid_at)->format('d/m/Y H:i') }}
                </td>
              </tr>
              <tr>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;color:#6b7280;">Payment Method</td>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;text-align:right;">{{ $paymentMethod }}</td>
              </tr>
              @if($payment->transaction_code)
                <tr>
                  <td style="padding:12px 16px;border-top:1px solid #e5e7eb;color:#6b7280;">Transaction Code</td>
                  <td style="padding:12px 16px;border-top:1px solid #e5e7eb;text-align:right;">{{ $payment->transaction_code }}</td>
                </tr>
              @endif
              @if($payment->paypal_order_id)
                <tr>
                  <td style="padding:12px 16px;border-top:1px solid #e5e7eb;color:#6b7280;">PayPal Order ID</td>
                  <td style="padding:12px 16px;border-top:1px solid #e5e7eb;text-align:right;">{{ $payment->paypal_order_id }}</td>
                </tr>
              @endif
              <tr>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;color:#6b7280;">Status</td>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;text-align:right;">
                  <strong style="color:#0f766e;">Paid</strong>
                </td>
              </tr>
            </table>

            <h3 style="margin:24px 0 10px;font-size:16px;color:#111827;">Customer Information</h3>

            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
              <tr>
                <td style="padding:12px 16px;color:#6b7280;">Name</td>
                <td style="padding:12px 16px;text-align:right;">{{ $client?->full_name ?? 'N/A' }}</td>
              </tr>
              <tr>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;color:#6b7280;">Phone</td>
                <td style="padding:12px 16px;border-top:1px solid #e5e7eb;text-align:right;">{{ $client?->phone ?? 'N/A' }}</td>
              </tr>
              @if($client?->email)
                <tr>
                  <td style="padding:12px 16px;border-top:1px solid #e5e7eb;color:#6b7280;">Email</td>
                  <td style="padding:12px 16px;border-top:1px solid #e5e7eb;text-align:right;">{{ $client->email }}</td>
                </tr>
              @endif
            </table>

            <h3 style="margin:24px 0 10px;font-size:16px;color:#111827;">Services</h3>
            <p style="margin:0 0 10px;font-size:14px;line-height:1.6;color:#4b5563;">
              Share your experience by reviewing each service you booked.
            </p>

            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
              <tr style="background:#f9fafb;">
                <th align="left" style="padding:12px 14px;font-size:13px;color:#374151;border-bottom:1px solid #e5e7eb;">Service</th>
                <th align="left" style="padding:12px 14px;font-size:13px;color:#374151;border-bottom:1px solid #e5e7eb;">Staff</th>
                <th align="right" style="padding:12px 14px;font-size:13px;color:#374151;border-bottom:1px solid #e5e7eb;">Price</th>
              </tr>

              @forelse($services as $item)
                <tr>
                  <td style="padding:12px 14px;border-bottom:1px solid #f3f4f6;">
                    {{ $item->service?->name ?? 'Service' }}
                    @if($item->service?->duration)
                      <br>
                      <span style="font-size:12px;color:#6b7280;">
                                                {{ $item->service->duration }} minutes
                                            </span>
                    @endif
                    @if($item->service && $item->service->status === 'active' && $item->service->category?->status === 'active')
                      <br>
                      <a href="{{ route('services.show', ['service' => $item->service->id]) }}#comments" style="display:inline-block;margin-top:8px;color:#0f766e;font-size:12px;font-weight:600;text-decoration:underline;">
                        Review this service
                      </a>
                    @endif
                  </td>
                  <td style="padding:12px 14px;border-bottom:1px solid #f3f4f6;">
                    {{ $item->staff?->full_name ?? 'Any staff' }}
                  </td>
                  <td align="right" style="padding:12px 14px;border-bottom:1px solid #f3f4f6;">
                    ${{ number_format((float) $item->price_at_booking, 2) }}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="3" style="padding:14px;color:#6b7280;text-align:center;">
                    No service details available.
                  </td>
                </tr>
              @endforelse
            </table>

            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:18px;">
              <tr>
                <td style="font-size:15px;color:#111827;font-weight:bold;">Total Paid</td>
                <td align="right" style="font-size:22px;color:#0f766e;font-weight:bold;">
                  ${{ number_format((float) $payment->amount, 2) }}
                </td>
              </tr>
            </table>

            @if($payment->note)
              <p style="margin:18px 0 0;font-size:14px;color:#4b5563;">
                <strong>Note:</strong> {{ $payment->note }}
              </p>
            @endif

            <p style="margin:24px 0 0;font-size:14px;line-height:1.6;color:#4b5563;">
              Thank you for choosing ZenStyle. We hope to see you again soon.
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
