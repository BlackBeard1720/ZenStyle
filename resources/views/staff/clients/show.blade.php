<x-staff.layout
  title="Client detail"
  page-name="ClientManagement"
>
  <div x-data="{ pageName: `Client detail`}">
    <x-staff.partials.breadcrumb />
  </div>

  <div class="mb-5 flex flex-wrap items-center justify-end gap-2">
    <a
      href="{{ route('staff.clients.index') }}"
      class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700"
    >
      Back
    </a>
    <a
      href="{{ route('staff.clients.edit', $client) }}"
      class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600"
    >
      Edit
    </a>
  </div>

  <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
    <!-- Client info -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-100 px-5 py-4 sm:px-6 sm:py-5 dark:border-gray-800">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Client information</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Profile used for booking and reception.</p>
      </div>
      <dl class="space-y-4 p-5 sm:p-6">
        <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID</dt>
          <dd class="text-sm text-gray-800 dark:text-white/90">{{ $client->id }}</dd>
        </div>
        <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Full name</dt>
          <dd class="text-sm text-gray-800 dark:text-white/90">{{ $client->full_name }}</dd>
        </div>
        <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
          <dd class="text-sm text-gray-800 dark:text-white/90">{{ $client->phone }}</dd>
        </div>
        <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
          <dd class="text-sm text-gray-800 dark:text-white/90">{{ $client->email ?? '—' }}</dd>
        </div>
        <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date of birth</dt>
          <dd class="text-sm text-gray-800 dark:text-white/90">
            {{ $client->dob ? \Illuminate\Support\Carbon::parse($client->dob)->format('d/m/Y') : '—' }}
          </dd>
        </div>
        <div class="flex flex-col gap-1 sm:flex-row sm:justify-between sm:items-start">
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Preferences</dt>
          <dd class="max-w-md text-right text-sm text-gray-800 dark:text-white/90">{{ $client->preferences ?? '—' }}</dd>
        </div>
        <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Loyalty points</dt>
          <dd class="text-sm text-gray-800 dark:text-white/90">{{ $client->loyalty_points ?? 0 }}</dd>
        </div>
        <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Linked account</dt>
          <dd class="text-sm text-gray-800 dark:text-white/90">
            {{ $client->user?->username ?? '—' }}
          </dd>
        </div>
        <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created at</dt>
          <dd class="text-sm text-gray-800 dark:text-white/90">{{ $client->created_at?->format('d/m/Y H:i') ?? '—' }}</dd>
        </div>
      </dl>
    </div>

    <!-- Appointment history -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] lg:col-span-2">
      <div class="border-b border-gray-100 px-5 py-4 sm:px-6 sm:py-5 dark:border-gray-800">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Appointment history</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Past and upcoming visits for this client.</p>
      </div>

      <div class="p-5 sm:p-6">
        @forelse($client->appointments as $appointment)
          @if ($loop->first)
            <div class="overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-800">
              <div class="w-full overflow-x-auto">
                <table class="min-w-full">
                  <thead>
                  <tr class="border-b border-gray-100 dark:border-gray-800">
                    <th class="px-4 pb-3 pt-4 text-left sm:px-6">
                      <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Appointment ID</p>
                    </th>
                    <th class="px-4 pb-3 pt-4 text-left sm:px-6">
                      <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Date</p>
                    </th>
                    <th class="px-4 pb-3 pt-4 text-left sm:px-6">
                      <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Start time</p>
                    </th>
                    <th class="px-4 pb-3 pt-4 text-left sm:px-6">
                      <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Status</p>
                    </th>
                    <th class="px-4 pb-3 pt-4 text-left sm:px-6">
                      <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Total amount</p>
                    </th>
                  </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                  @endif
                  <tr>
                    <td class="px-4 pb-3 pt-4 sm:px-6">
                      <p class="text-theme-sm text-gray-700 dark:text-gray-300">{{ $appointment->id }}</p>
                    </td>
                    <td class="px-4 pb-3 pt-4 sm:px-6">
                      <p class="text-theme-sm text-gray-700 dark:text-gray-300">
                        {{ $appointment->appointment_date ?? '—' }}
                      </p>
                    </td>
                    <td class="px-4 pb-3 pt-4 sm:px-6">
                      <p class="text-theme-sm text-gray-700 dark:text-gray-300">
                        {{ $appointment->appointment_time ?? $appointment->start_time ?? '—' }}
                      </p>
                    </td>
                    <td class="px-4 pb-3 pt-4 sm:px-6">
                      <p class="text-theme-sm text-gray-700 dark:text-gray-300">{{ $appointment->status ?? '—' }}</p>
                    </td>
                    <td class="px-4 pb-3 pt-4 sm:px-6">
                      <p class="text-theme-sm text-gray-700 dark:text-gray-300">
                        @isset($appointment->total_amount)
                          {{ number_format((float) $appointment->total_amount, 0, ',', '.') }}
                        @else
                          —
                        @endisset
                      </p>
                    </td>
                  </tr>
                  @if ($loop->last)
                  </tbody>
                </table>
              </div>
            </div>
          @endif
        @empty
          <p class="text-sm text-gray-500 dark:text-gray-400">No appointments yet.</p>
        @endforelse
      </div>
    </div>
  </div>
</x-staff.layout>
