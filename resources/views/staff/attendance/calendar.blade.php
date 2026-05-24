<x-staff.layout title="Attendance Calendar" page-name="AttendanceCalendar">
  <div x-data="{ pageName: `Attendance Calendar` }">
    <x-staff.partials.breadcrumb />
  </div>

  <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 sm:px-6 sm:py-5">
      <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Attendance Calendar</h3>
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Monthly staff attendance overview.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
          <span class="inline-flex items-center gap-2">
            <span class="h-2.5 w-2.5 rounded-full bg-success-500"></span>
            Present
          </span>
          <span class="inline-flex items-center gap-2">
            <span class="h-2.5 w-2.5 rounded-full bg-orange-500"></span>
            Late
          </span>
          <span class="inline-flex items-center gap-2">
            <span class="h-2.5 w-2.5 rounded-full bg-error-500"></span>
            Absent
          </span>
          <span class="inline-flex items-center gap-2">
            <span class="h-2.5 w-2.5 rounded-full bg-brand-500"></span>
            Leave
          </span>
        </div>
      </div>
    </div>

    <div
      id="calendar"
      class="min-h-screen"
      data-attendance-calendar="true"
      data-events-url="{{ route('staff.attendance.events') }}"
      data-store-url="{{ route('staff.attendance.store') }}"
      data-update-url-template="{{ route('staff.attendance.update', ['attendance' => '__ID__']) }}"
      data-csrf-token="{{ csrf_token() }}"
    ></div>
  </div>

  <div
    class="fixed inset-0 z-99999 hidden items-center justify-center overflow-y-auto p-5"
    id="attendanceModal"
  >
    <div class="attendance-modal-close fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"></div>

    <div class="relative flex w-full max-w-[760px] flex-col overflow-y-auto rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-11">
      <button
        type="button"
        class="attendance-modal-close transition-color absolute right-5 top-5 z-999 flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-700 dark:bg-white/[0.05] dark:text-gray-400 dark:hover:bg-white/[0.07] dark:hover:text-gray-300 sm:h-11 sm:w-11"
        aria-label="Close"
      >
        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M6.04289 16.5418C5.65237 16.9323 5.65237 17.5655 6.04289 17.956C6.43342 18.3465 7.06658 18.3465 7.45711 17.956L11.9987 13.4144L16.5408 17.9565C16.9313 18.347 17.5645 18.347 17.955 17.9565C18.3455 17.566 18.3455 16.9328 17.955 16.5423L13.4129 12.0002L17.955 7.45808C18.3455 7.06756 18.3455 6.43439 17.955 6.04387C17.5645 5.65335 16.9313 5.65335 16.5408 6.04387L11.9987 10.586L7.45711 6.04439C7.06658 5.65386 6.43342 5.65386 6.04289 6.04439C5.65237 6.43491 5.65237 7.06808 6.04289 7.4586L10.5845 12.0002L6.04289 16.5418Z" fill="" />
        </svg>
      </button>

      <div class="flex flex-col px-2">
        <div>
          <h5
            class="mb-2 font-semibold text-gray-800 text-theme-xl dark:text-white/90 lg:text-2xl"
            id="attendanceModalTitle"
          >
            Add Attendance
          </h5>
        </div>

        <div
          id="attendance-modal-error"
          class="mt-5 hidden rounded-lg border border-error-200 bg-error-50 px-4 py-3 text-sm text-error-600 dark:border-error-500/30 dark:bg-error-500/15 dark:text-error-500"
        ></div>

        <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2">
          <input type="hidden" id="attendance-id" />

          <div class="sm:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400" for="attendance-staff-id">
              Staff
            </label>
            <div class="relative z-20 bg-transparent">
              <select
                id="attendance-staff-id"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              >
                <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Select staff</option>
                @foreach($staff as $staffMember)
                  <option value="{{ $staffMember->id }}" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                    {{ $staffMember->full_name }}
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
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400" for="attendance-work-date">
              Work Date
            </label>
            <input
              id="attendance-work-date"
              type="date"
              class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800"
            />
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400" for="attendance-status">
              Status
            </label>
            <div class="relative z-20 bg-transparent">
              <select
                id="attendance-status"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              >
                <option value="present" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Present</option>
                <option value="late" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Late</option>
                <option value="absent" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Absent</option>
                <option value="leave" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Leave</option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </div>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400" for="attendance-check-in">
              Check In
            </label>
            <input
              id="attendance-check-in"
              type="time"
              class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800"
            />
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400" for="attendance-check-out">
              Check Out
            </label>
            <input
              id="attendance-check-out"
              type="time"
              class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800"
            />
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400" for="attendance-working-hours">
              Working Hours
            </label>
            <input
              id="attendance-working-hours"
              type="number"
              min="0"
              max="24"
              step="0.25"
              class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800"
            />
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400" for="attendance-overtime-hours">
              Overtime Hours
            </label>
            <input
              id="attendance-overtime-hours"
              type="number"
              min="0"
              max="24"
              step="0.25"
              class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800"
            />
          </div>

          <div class="sm:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400" for="attendance-note">
              Note
            </label>
            <textarea
              id="attendance-note"
              rows="3"
              class="dark:bg-dark-900 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800"
            ></textarea>
          </div>
        </div>

        <div class="mt-6 flex items-center gap-3 sm:justify-end">
          <button
            type="button"
            class="attendance-modal-close flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] sm:w-auto"
          >
            Close
          </button>
          <button
            type="button"
            id="attendance-save-button"
            class="flex w-full justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 sm:w-auto"
          >
            Save Attendance
          </button>
        </div>
      </div>
    </div>
  </div>
</x-staff.layout>
