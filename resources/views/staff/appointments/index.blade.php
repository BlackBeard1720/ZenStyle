<x-staff.layout title="Appointments" page-name="Appointments">
  <div x-data="{ pageName: `Appointments` }">
    <x-staff.partials.breadcrumb />
  </div>

  <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 sm:px-6 sm:py-5">
      <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Appointments</h3>
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage client appointments.</p>
        </div>
        <a href="{{ route('staff.appointments.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-theme-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
          <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
          </svg>
          Create Appointment
        </a>
      </div>
    </div>

    <div class="p-5 sm:p-6">
      <form method="GET" action="{{ route('staff.appointments.index') }}" class="mb-5 grid grid-cols-1 gap-4 md:grid-cols-5">
        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="ID, name, phone, email" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
        <input type="date" name="appointment_date" value="{{ request('appointment_date') }}" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
        <select name="status" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
          <option value="">All statuses</option>
          @foreach(['pending' => 'Pending', 'confirmed' => 'Confirmed', 'cancelled' => 'Cancelled', 'completed' => 'Completed'] as $value => $label)
            <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
          @endforeach
        </select>
        <button type="submit" class="inline-flex h-11 items-center justify-center rounded-lg bg-brand-500 px-4 text-sm font-medium text-white hover:bg-brand-600">Search</button>
        <a href="{{ route('staff.appointments.index') }}" class="inline-flex h-11 items-center justify-center rounded-lg border border-gray-300 px-4 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800">Reset</a>
      </form>

      <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="w-full overflow-x-auto">
          <table class="min-w-full">
            <thead>
            <tr class="border-b border-gray-100 dark:border-gray-800">
              @foreach(['ID', 'Client', 'Phone', 'Date', 'Time', 'Services', 'Staff', 'Total', 'Status', 'Actions'] as $heading)
                <th class="px-4 pb-3 pt-4 text-left sm:px-6 {{ $heading === 'Actions' ? 'text-right' : '' }}">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">{{ $heading }}</p>
                </th>
              @endforeach
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($appointments as $appointment)
              @php
                $badgeClass = match($appointment->status) {
                  'confirmed' => 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500',
                  'cancelled' => 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500',
                  'completed' => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300',
                  default => 'bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-500',
                };
                $serviceNames = $appointment->appointmentServices->pluck('service.service_name')->filter();
                $staffNames = $appointment->appointmentServices->pluck('staff.full_name')->filter()->unique();
              @endphp
              <tr>
                <td class="px-4 py-4 sm:px-6"><p class="text-theme-sm text-gray-500 dark:text-gray-400">#{{ $appointment->id }}</p></td>
                <td class="px-4 py-4 sm:px-6"><p class="font-medium text-theme-sm text-gray-800 dark:text-white/90">{{ $appointment->client?->full_name ?? '-' }}</p></td>
                <td class="px-4 py-4 sm:px-6"><p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $appointment->client?->phone ?? '-' }}</p></td>
                <td class="px-4 py-4 sm:px-6"><p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $appointment->appointment_date?->format('d/m/Y') }}</p></td>
                <td class="px-4 py-4 sm:px-6"><p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</p></td>
                <td class="px-4 py-4 sm:px-6"><p class="max-w-48 text-theme-sm text-gray-500 dark:text-gray-400">{{ $serviceNames->take(2)->join(', ') ?: '-' }}@if($serviceNames->count() > 2) +{{ $serviceNames->count() - 2 }} more @endif</p></td>
                <td class="px-4 py-4 sm:px-6"><p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $staffNames->join(', ') ?: 'Unassigned' }}</p></td>
                <td class="px-4 py-4 sm:px-6"><p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ number_format($appointment->total_amount) }} VND</p></td>
                <td class="px-4 py-4 sm:px-6"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badgeClass }}">{{ ucfirst($appointment->status) }}</span></td>
                <td class="px-4 py-4 sm:px-6">
                  <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('staff.appointments.show', $appointment) }}" title="View appointment" class="text-gray-500 hover:text-brand-600 dark:text-gray-400">
                      <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                    </a>
                    <a href="{{ route('staff.appointments.edit', $appointment) }}" title="Edit appointment" class="text-gray-500 hover:text-blue-600 dark:text-gray-400">
                      <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487 18.55 2.8a1.875 1.875 0 0 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 7.125 16.875 4.5"/></svg>
                    </a>
                    @if($appointment->canBeCancelled())
                      <form method="POST" action="{{ route('staff.appointments.cancel', $appointment) }}" onsubmit="return confirm('Cancel this appointment?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" title="Cancel appointment" class="text-gray-500 hover:text-error-600 dark:text-gray-400">
                          <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                        </button>
                      </form>
                    @endif
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="10" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">No appointments found.</td>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="mt-5">
        {{ $appointments->links() }}
      </div>
    </div>
  </div>
</x-staff.layout>
