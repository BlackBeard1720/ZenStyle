<x-staff.layout title="Appointment Detail" page-name="Appointments">
  <div x-data="{ pageName: `Appointment #{{ $appointment->id }}` }">
    <x-staff.partials.breadcrumb />
  </div>

  @php
    $badgeClass = match($appointment->status) {
      'confirmed' => 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500',
      'cancelled' => 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500',
      'completed' => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300',
      default => 'bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-500',
    };
  @endphp

  <div class="space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-4 dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between sm:px-6 sm:py-5">
        <div>
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Appointment #{{ $appointment->id }}</h3>
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ $appointment->appointment_date?->format('d/m/Y') }}
            at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
          </p>
        </div>
        <span class="inline-flex w-fit rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badgeClass }}">{{ ucfirst($appointment->status) }}</span>
      </div>

      <div class="grid grid-cols-1 gap-6 p-5 sm:p-6 lg:grid-cols-2">
        <div>
          <h4 class="mb-3 text-sm font-semibold text-gray-800 dark:text-white/90">Client</h4>
          <dl class="space-y-2 text-sm">
            <div><dt class="text-gray-500 dark:text-gray-400">Name</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ $appointment->client?->full_name ?? '-' }}</dd></div>
            <div><dt class="text-gray-500 dark:text-gray-400">Phone</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ $appointment->client?->phone ?? '-' }}</dd></div>
            <div><dt class="text-gray-500 dark:text-gray-400">Email</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ $appointment->client?->email ?: '-' }}</dd></div>
          </dl>
        </div>

        <div>
          <h4 class="mb-3 text-sm font-semibold text-gray-800 dark:text-white/90">Summary</h4>
          <dl class="space-y-2 text-sm">
            <div><dt class="text-gray-500 dark:text-gray-400">Date</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ $appointment->appointment_date?->format('d/m/Y') }}</dd></div>
            <div><dt class="text-gray-500 dark:text-gray-400">Time</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</dd></div>
            <div><dt class="text-gray-500 dark:text-gray-400">Total amount</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ number_format($appointment->total_amount) }} VND</dd></div>
          </dl>
        </div>

        <div class="lg:col-span-2">
          <h4 class="mb-3 text-sm font-semibold text-gray-800 dark:text-white/90">Services</h4>
          <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800">
            <table class="min-w-full">
              <thead>
              <tr class="border-b border-gray-100 dark:border-gray-800">
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Service</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Staff</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400">Price</th>
              </tr>
              </thead>
              <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
              @foreach($appointment->appointmentServices as $appointmentService)
                <tr>
                  <td class="px-4 py-3 text-sm font-medium text-gray-800 dark:text-white/90">{{ $appointmentService->service?->service_name ?? '-' }}</td>
                  <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $appointmentService->staff?->full_name ?? 'Unassigned' }}</td>
                  <td class="px-4 py-3 text-right text-sm text-gray-500 dark:text-gray-400">{{ number_format($appointmentService->price_at_booking) }} VND</td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <div class="lg:col-span-2">
          <h4 class="mb-3 text-sm font-semibold text-gray-800 dark:text-white/90">Notes</h4>
          <p class="rounded-lg border border-gray-200 p-4 text-sm text-gray-600 dark:border-gray-800 dark:text-gray-300">{{ $appointment->notes ?: '-' }}</p>
        </div>
      </div>
    </div>

    <div class="flex flex-wrap items-center justify-end gap-3">
      <a href="{{ route('staff.appointments.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">Back</a>
      @if($appointment->canBeEdited())
        <a href="{{ route('staff.appointments.edit', $appointment) }}" class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">Edit</a>
      @endif
      @if($appointment->canBeCancelled())
        <form method="POST" action="{{ route('staff.appointments.cancel', $appointment) }}" onsubmit="return confirm('Cancel this appointment?')">
          @csrf
          @method('PATCH')
          <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-error-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-error-600">Cancel Appointment</button>
        </form>
      @endif
    </div>
  </div>
</x-staff.layout>
