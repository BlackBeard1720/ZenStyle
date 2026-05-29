<x-staff.layout title="Staff Schedules" page-name="StaffScheduleManagement">
  <div x-data="{ pageName: `Staff Schedules` }">
    <x-staff.partials.breadcrumb />
  </div>

  @php
    $inputClass = 'h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30';
    $selectClass = 'h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90';
  @endphp

  <div class="space-y-6">
    {{-- Success and Error Messages --}}
    @if(session('success'))
      <div class="rounded-xl border border-success-500/30 bg-success-500/10 px-4 py-3 text-sm text-success-600 dark:text-success-300">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="rounded-xl border border-error-500/30 bg-error-500/10 px-4 py-3 text-sm text-error-600 dark:text-error-300">
        {{ $errors->first() }}
      </div>
    @endif

    {{-- Create Schedule Panel --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6 shadow-theme-xs">
      <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Add Working Schedule</h3>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Configure weekly/daily working shifts, off-days, and leaves for staff.</p>

      <form method="POST" action="{{ route('staff.schedules.store') }}" class="mt-5">
        @csrf
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-6 items-end">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Staff Member</label>
            <div x-data="{ isOptionSelected: old('staff_id') ? true : false }" class="relative z-20 bg-transparent">
              <select name="staff_id" required class="{{ $selectClass }}" @change="isOptionSelected = true">
                <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Select staff</option>
                @foreach($staff as $item)
                  <option value="{{ $item->id }}" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected(old('staff_id') == $item->id)>
                    {{ $item->full_name }}
                  </option>
                @endforeach
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </div>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Work Date</label>
            <input
              type="date"
              name="work_date"
              required
              value="{{ old('work_date', date('Y-m-d')) }}"
              class="{{ $inputClass }}"
            />
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Start Time</label>
            <input
              type="time"
              name="start_time"
              value="{{ old('start_time', '09:00') }}"
              class="{{ $inputClass }}"
            />
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">End Time</label>
            <input
              type="time"
              name="end_time"
              value="{{ old('end_time', '18:00') }}"
              class="{{ $inputClass }}"
            />
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Status</label>
            <div x-data="{ isOptionSelected: true }" class="relative z-20 bg-transparent">
              <select name="status" required class="{{ $selectClass }}">
                <option value="scheduled" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected(old('status') == 'scheduled')>Scheduled</option>
                <option value="off" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected(old('status') == 'off')>Off</option>
                <option value="leave" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected(old('status') == 'leave')>Leave</option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </div>
          </div>

          <div>
            <button
              type="submit"
              class="inline-flex h-11 w-full items-center justify-center rounded-lg bg-brand-500 px-5 text-sm font-medium text-white hover:bg-brand-600 shadow-theme-xs"
            >
              Save Schedule
            </button>
          </div>
        </div>
      </form>
    </div>

    {{-- Schedules List Panel --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 sm:px-6 sm:py-5">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Schedules List</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Browse and manage current active staff schedules.</p>
      </div>

      <div class="p-5 sm:p-6">
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
          <div class="w-full overflow-x-auto">
            <table class="min-w-full table-fixed">
              <thead>
              <tr class="border-b border-gray-100 dark:border-gray-800">
                <th class="w-52 px-4 pb-3 pt-4 text-left sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Staff Member</p>
                </th>
                <th class="w-36 px-4 pb-3 pt-4 text-left sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Work Date</p>
                </th>
                <th class="w-28 px-4 pb-3 pt-4 text-left sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Start Time</p>
                </th>
                <th class="w-28 px-4 pb-3 pt-4 text-left sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">End Time</p>
                </th>
                <th class="w-32 px-4 pb-3 pt-4 text-left sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                </th>
                <th class="px-4 pb-3 pt-4 text-right sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Actions</p>
                </th>
              </tr>
              </thead>
              <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
              @forelse($schedules as $schedule)
                @php
                  $badgeClass = match($schedule->status) {
                    'scheduled' => 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500',
                    'off' => 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500',
                    default => 'bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-500', // leave
                  };
                @endphp
                <tr class="align-top hover:bg-gray-50/50 dark:hover:bg-white/[0.01]">
                  <td class="px-4 py-4 sm:px-6">
                    <p class="font-medium text-theme-sm text-gray-800 dark:text-white/90">{{ $schedule->staff->full_name ?? 'N/A' }}</p>
                  </td>
                  <td class="px-4 py-4 sm:px-6">
                    <p class="text-theme-sm text-gray-800 dark:text-white/90">{{ $schedule->work_date?->format('d/m/Y') }}</p>
                  </td>
                  <td class="px-4 py-4 sm:px-6">
                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $schedule->start_time ? substr($schedule->start_time, 0, 5) : '-' }}</p>
                  </td>
                  <td class="px-4 py-4 sm:px-6">
                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $schedule->end_time ? substr($schedule->end_time, 0, 5) : '-' }}</p>
                  </td>
                  <td class="px-4 py-4 sm:px-6">
                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badgeClass }}">
                      {{ ucfirst($schedule->status) }}
                    </span>
                  </td>
                  <td class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-end gap-2 whitespace-nowrap">
                      <form method="POST" action="{{ route('staff.schedules.destroy', $schedule) }}" class="inline" onsubmit="return confirm('Delete this schedule?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex min-w-[76px] items-center justify-center rounded-md bg-error-500 px-2.5 py-1 text-center text-xs font-medium text-white shadow-theme-xs hover:bg-error-600">
                          Delete
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                    No schedule records found.
                  </td>
                </tr>
              @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <div class="mt-5">
          {{ $schedules->links() }}
        </div>
      </div>
    </div>
  </div>

  <style>
    input[type="date"],
    input[type="time"],
    select {
      color-scheme: light;
      cursor: pointer;
    }

    .dark input[type="date"],
    .dark input[type="time"],
    .dark select {
      color-scheme: dark;
    }

    .dark input[type="date"]::-webkit-calendar-picker-indicator,
    .dark input[type="time"]::-webkit-calendar-picker-indicator {
      filter: invert(1);
      cursor: pointer;
    }
  </style>
</x-staff.layout>
