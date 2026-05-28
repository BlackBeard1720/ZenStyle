<x-staff.layout title="Payment Detail" page-name="PaymentManagement">
  <div x-data="{ pageName: `Payment #{{ $payment->id }}` }">
    <x-staff.partials.breadcrumb />
  </div>

  @php
    $appointment = $payment->appointment;
    $client = $appointment?->client;
  @endphp

  <div class="space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
      <h3 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Payment summary</h3>
      <dl class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-2 lg:grid-cols-3">
        <div><dt class="text-gray-500 dark:text-gray-400">Payment ID</dt><dd class="font-medium text-gray-800 dark:text-white/90">#{{ $payment->id }}</dd></div>
        <div><dt class="text-gray-500 dark:text-gray-400">Amount</dt><dd class="font-medium text-gray-800 dark:text-white/90">${{ number_format($payment->amount, 2) }}</dd></div>
        <div><dt class="text-gray-500 dark:text-gray-400">Payment method</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ strtoupper($payment->payment_method) }}</dd></div>
        <div><dt class="text-gray-500 dark:text-gray-400">Status</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ ucfirst($payment->status) }}</dd></div>
        <div><dt class="text-gray-500 dark:text-gray-400">Paid at</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ $payment->paid_at?->format('d/m/Y H:i') ?? 'N/A' }}</dd></div>
        <div><dt class="text-gray-500 dark:text-gray-400">Transaction code</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ $payment->transaction_code ?: 'N/A' }}</dd></div>
        <div><dt class="text-gray-500 dark:text-gray-400">PayPal order ID</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ $payment->paypal_order_id ?: 'N/A' }}</dd></div>
        <div><dt class="text-gray-500 dark:text-gray-400">PayPal capture ID</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ $payment->paypal_capture_id ?: 'N/A' }}</dd></div>
        <div class="sm:col-span-2 lg:col-span-3"><dt class="text-gray-500 dark:text-gray-400">Note</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ $payment->note ?: 'N/A' }}</dd></div>
      </dl>

      @if($payment->status === 'paid')
        <form method="POST" action="{{ route('staff.payments.refund', $payment) }}" class="mt-4" onsubmit="return confirm('Mark this payment as refunded?')">
          @csrf
          @method('PATCH')
          <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-error-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-error-600">Mark as refunded</button>
        </form>
      @endif
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
      <h3 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Appointment summary</h3>
      <dl class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-2 lg:grid-cols-3">
        <div><dt class="text-gray-500 dark:text-gray-400">Appointment ID</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ $appointment?->id ? '#' . $appointment->id : 'N/A' }}</dd></div>
        <div><dt class="text-gray-500 dark:text-gray-400">Appointment date</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ $appointment?->appointment_date?->format('d/m/Y') ?? 'N/A' }}</dd></div>
        <div><dt class="text-gray-500 dark:text-gray-400">Appointment time</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ $appointment?->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') : 'N/A' }}</dd></div>
        <div><dt class="text-gray-500 dark:text-gray-400">Appointment status</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ $appointment?->status ? ucfirst($appointment->status) : 'N/A' }}</dd></div>
        <div><dt class="text-gray-500 dark:text-gray-400">Total amount</dt><dd class="font-medium text-gray-800 dark:text-white/90">${{ number_format($appointment?->total_amount ?? 0, 2) }}</dd></div>
        <div>
          <dt class="text-gray-500 dark:text-gray-400">Appointment detail</dt>
          <dd><a href="{{ $appointment ? route('staff.appointments.show', $appointment) : '#' }}" class="text-brand-500 hover:underline">View appointment</a></dd>
        </div>
      </dl>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
      <h3 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Customer information</h3>
      <dl class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-3">
        <div><dt class="text-gray-500 dark:text-gray-400">Name</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ $client?->full_name ?? 'N/A' }}</dd></div>
        <div><dt class="text-gray-500 dark:text-gray-400">Phone</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ $client?->phone ?? 'N/A' }}</dd></div>
        <div><dt class="text-gray-500 dark:text-gray-400">Email</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ $client?->email ?? 'N/A' }}</dd></div>
      </dl>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
      <h3 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Services</h3>
      <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800">
        <table class="min-w-full">
          <thead>
          <tr class="border-b border-gray-100 dark:border-gray-800">
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Service name</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Staff</th>
            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400">Price at booking</th>
          </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
          @forelse($appointment?->appointmentServices ?? [] as $appointmentService)
            <tr>
              <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $appointmentService->service?->name ?? 'N/A' }}</td>
              <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $appointmentService->staff?->full_name ?? 'Unassigned' }}</td>
              <td class="px-4 py-3 text-right text-sm text-gray-700 dark:text-gray-300">${{ number_format($appointmentService->price_at_booking, 2) }}</td>
            </tr>
          @empty
            <tr><td colspan="3" class="px-4 py-5 text-center text-sm text-gray-500 dark:text-gray-400">No services found.</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</x-staff.layout>
