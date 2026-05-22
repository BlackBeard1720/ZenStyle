<h2>ZenStyle xác nhận đặt lịch thành công</h2>

<p>Xin chào {{ $appointment->client?->full_name ?? 'quý khách' }},</p>

<p>Lịch hẹn của bạn đã được đặt thành công.</p>

<p><strong>Mã lịch hẹn:</strong> #{{ $appointment->id }}</p>
<p><strong>Ngày hẹn:</strong> {{ optional($appointment->appointment_date)->format('d/m/Y') }}</p>
<p><strong>Giờ hẹn:</strong> {{ $appointment->appointment_time ?? '' }}</p>

<p>Cảm ơn bạn đã sử dụng dịch vụ của ZenStyle.</p>
