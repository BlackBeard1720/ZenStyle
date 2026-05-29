<x-staff.layout title="Attendance" page-name="AttendanceManagement">
  <div x-data="{ pageName: `Attendance` }">
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

    {{-- Record Attendance Panel --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6 shadow-theme-xs">
      <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Record Daily Attendance</h3>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Log employee work hours, check-in, check-out times, and attendance states.</p>

      <form method="POST" action="{{ route('staff.attendance.store') }}" class="mt-5">
        @csrf
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-7 items-end">
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
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Check In</label>
            <input
              type="time"
              name="check_in_time"
              value="{{ old('check_in_time', '09:00') }}"
              class="{{ $inputClass }}"
            />
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Check Out</label>
            <input
              type="time"
              name="check_out_time"
              value="{{ old('check_out_time', '18:00') }}"
              class="{{ $inputClass }}"
            />
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Status</label>
            <div x-data="{ isOptionSelected: true }" class="relative z-20 bg-transparent">
              <select name="status" class="{{ $selectClass }}">
                <option value="present" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected(old('status') == 'present')>Present</option>
                <option value="late" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected(old('status') == 'late')>Late</option>
                <option value="absent" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected(old('status') == 'absent')>Absent</option>
                <option value="leave" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected(old('status') == 'leave')>Leave</option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </div>
          </div>

          <div class="sm:col-span-2">
            <button
              type="submit"
              class="inline-flex h-11 w-full items-center justify-center rounded-lg bg-brand-500 px-5 text-sm font-medium text-white hover:bg-brand-600 shadow-theme-xs"
            >
              Record Attendance
            </button>
          </div>
        </div>
      </form>
    </div>

    {{-- Attendance List Panel --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 sm:px-6 sm:py-5">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Attendance List</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">View and update employee working timelines.</p>
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
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Date</p>
                </th>
                <th class="w-28 px-4 pb-3 pt-4 text-left sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Check In</p>
                </th>
                <th class="w-28 px-4 pb-3 pt-4 text-left sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Check Out</p>
                </th>
                <th class="w-28 px-4 pb-3 pt-4 text-left sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Hours</p>
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
              @forelse($attendances as $attendance)
                @php
                  $badgeClass = match($attendance->status) {
                    'present' => 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500',
                    'late' => 'bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-500',
                    'absent' => 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500',
                    default => 'bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-500', // leave
                  };
                @endphp
                <tr class="align-top hover:bg-gray-50/50 dark:hover:bg-white/[0.01]">
                  <td class="px-4 py-4 sm:px-6">
                    <p class="font-medium text-theme-sm text-gray-800 dark:text-white/90">{{ $attendance->staff->full_name ?? 'N/A' }}</p>
                  </td>
                  <td class="px-4 py-4 sm:px-6">
                    <p class="text-theme-sm text-gray-800 dark:text-white/90">{{ $attendance->work_date?->format('d/m/Y') }}</p>
                  </td>
                  <td class="px-4 py-4 sm:px-6">
                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $attendance->check_in?->format('H:i') ?? '-' }}</p>
                  </td>
                  <td class="px-4 py-4 sm:px-6">
                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $attendance->check_out?->format('H:i') ?? '-' }}</p>
                  </td>
                  <td class="px-4 py-4 sm:px-6">
                    <p class="text-theme-sm font-semibold text-gray-800 dark:text-white/90">{{ $attendance->working_hours }}h</p>
                  </td>
                  <td class="px-4 py-4 sm:px-6">
                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badgeClass }}">
                      {{ ucfirst($attendance->status) }}
                    </span>
                  </td>
                  <td class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-end gap-2 whitespace-nowrap">
                      <button
                        type="button"
                        onclick="toggleEditAttendance({{ $attendance->id }})"
                        class="inline-flex min-w-[76px] items-center justify-center rounded-md border border-gray-300 bg-white px-2.5 py-1 text-center text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                      >
                        Edit
                      </button>

                      <form method="POST" action="{{ route('staff.attendance.destroy', $attendance) }}" class="inline" onsubmit="return confirm('Delete this attendance?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex min-w-[76px] items-center justify-center rounded-md bg-error-500 px-2.5 py-1 text-center text-xs font-medium text-white shadow-theme-xs hover:bg-error-600">
                          Delete
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>

                {{-- Inline Edit Dropdown Form --}}
                <tr id="edit-attendance-{{ $attendance->id }}" class="hidden bg-gray-50/50 dark:bg-white/[0.01] border-b border-gray-100 dark:border-gray-800">
                  <td colspan="7" class="px-4 py-4 sm:px-6">
                    <form method="POST" action="{{ route('staff.attendance.update', $attendance) }}" class="space-y-4">
                      @csrf
                      @method('PUT')

                      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-7 items-end">
                        <div>
                          <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Staff Member</label>
                          <div x-data="{ isOptionSelected: true }" class="relative z-20 bg-transparent">
                            <select name="staff_id" required class="{{ $selectClass }}">
                              @foreach($staff as $item)
                                <option value="{{ $item->id }}" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected($attendance->staff_id == $item->id)>
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
                            value="{{ $attendance->work_date?->format('Y-m-d') }}"
                            class="{{ $inputClass }}"
                          />
                        </div>

                        <div>
                          <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Check In</label>
                          <input
                            type="time"
                            name="check_in_time"
                            value="{{ $attendance->check_in?->format('H:i') }}"
                            class="{{ $inputClass }}"
                          />
                        </div>

                        <div>
                          <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Check Out</label>
                          <input
                            type="time"
                            name="check_out_time"
                            value="{{ $attendance->check_out?->format('H:i') }}"
                            class="{{ $inputClass }}"
                          />
                        </div>

                        <div>
                          <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Status</label>
                          <div x-data="{ isOptionSelected: true }" class="relative z-20 bg-transparent">
                            <select name="status" class="{{ $selectClass }}">
                              <option value="present" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected($attendance->status === 'present')>Present</option>
                              <option value="late" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected($attendance->status === 'late')>Late</option>
                              <option value="absent" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected($attendance->status === 'absent')>Absent</option>
                              <option value="leave" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected($attendance->status === 'leave')>Leave</option>
                            </select>
                            <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                              <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg>
                            </span>
                          </div>
                        </div>

                        <div class="sm:col-span-2">
                          <button
                            type="submit"
                            class="inline-flex h-11 w-full items-center justify-center rounded-lg bg-brand-500 px-5 text-sm font-medium text-white hover:bg-brand-600 shadow-theme-xs"
                          >
                            Update
                          </button>
                        </div>
                      </div>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                    No attendance records found.
                  </td>
                </tr>
              @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <div class="mt-5">
          {{ $attendances->links() }}
        </div>
      </div>
    </div>
  </div>

  <script>
    function toggleEditAttendance(id) {
      const row = document.getElementById('edit-attendance-' + id);
      if (row) {
        row.classList.toggle('hidden');
      }
    }
  </script>

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
