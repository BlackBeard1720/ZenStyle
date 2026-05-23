<x-staff.layout title="Checkout" page-name="Appointments">
  <div class="p-6">
    <h1 class="text-xl font-semibold text-gray-800 dark:text-white">
      Checkout Appointment #{{ $appointment->id }}
    </h1>

    <p class="mt-4 text-gray-600 dark:text-gray-300">
      Client: {{ $appointment->client?->full_name ?? '-' }}
    </p>

    <p class="mt-2 text-gray-600 dark:text-gray-300">
      Total: {{ number_format($appointment->total_amount) }} VND
    </p>

    <a href="{{ route('staff.appointments.show', $appointment) }}"
       class="mt-6 inline-flex rounded-lg border px-4 py-2 text-sm">
      Back to appointment
    </a>
  </div>
</x-staff.layout>
