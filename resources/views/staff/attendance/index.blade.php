<x-staff.layout>

  <div class="p-6 text-gray-900 dark:text-white">
    <div class="mb-6 flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
          Attendance
        </h1>

        <p class="text-sm text-gray-500 dark:text-gray-400">
          Employee attendance management
        </p>
      </div>
    </div>

    @if(session('success'))
      <div class="mb-4 rounded-lg border border-green-500/30 bg-green-500/10 px-4 py-3 text-green-600 dark:text-green-300">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="mb-4 rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3 text-red-600 dark:text-red-300">
        {{ $errors->first() }}
      </div>
    @endif

    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-[#151c2c]">
      <form method="POST" action="{{ route('staff.attendance.store') }}">
        @csrf

        <div class="grid grid-cols-1 gap-4 md:grid-cols-7">
          <div>
            <label class="mb-1 block text-sm text-gray-700 dark:text-gray-300">
              Staff
            </label>

            <select
              name="staff_id"
              required
              class="h-12 w-full rounded-lg border border-gray-300 bg-gray-50 px-3 text-gray-900 outline-none focus:border-blue-500 dark:border-gray-700 dark:bg-[#0f1726] dark:text-white"
            >
              <option value="">Select staff</option>
              @foreach($staff as $item)
                <option value="{{ $item->id }}" @selected(old('staff_id') == $item->id)>
                  {{ $item->full_name }}
                </option>
              @endforeach
            </select>
          </div>

          <div>
            <label class="mb-1 block text-sm text-gray-700 dark:text-gray-300">
              Work Date
            </label>

            <input
              type="date"
              name="work_date"
              required
              value="{{ old('work_date') }}"
              class="h-12 w-full rounded-lg border border-gray-300 bg-gray-50 px-3 text-gray-900 outline-none focus:border-blue-500 dark:border-gray-700 dark:bg-[#0f1726] dark:text-white"
            >
          </div>

          <div>
            <label class="mb-1 block text-sm text-gray-700 dark:text-gray-300">
              Check In
            </label>

            <input
              type="time"
              name="check_in_time"
              value="{{ old('check_in_time') }}"
              class="h-12 w-full rounded-lg border border-gray-300 bg-gray-50 px-3 text-gray-900 outline-none focus:border-blue-500 dark:border-gray-700 dark:bg-[#0f1726] dark:text-white"
            >
          </div>

          <div>
            <label class="mb-1 block text-sm text-gray-700 dark:text-gray-300">
              Check Out
            </label>

            <input
              type="time"
              name="check_out_time"
              value="{{ old('check_out_time') }}"
              class="h-12 w-full rounded-lg border border-gray-300 bg-gray-50 px-3 text-gray-900 outline-none focus:border-blue-500 dark:border-gray-700 dark:bg-[#0f1726] dark:text-white"
            >
          </div>

          <div>
            <label class="mb-1 block text-sm text-gray-700 dark:text-gray-300">
              Status
            </label>

            <select
              name="status"
              class="h-12 w-full rounded-lg border border-gray-300 bg-gray-50 px-3 text-gray-900 outline-none focus:border-blue-500 dark:border-gray-700 dark:bg-[#0f1726] dark:text-white"
            >
              <option value="present" @selected(old('status') == 'present')>Present</option>
              <option value="late" @selected(old('status') == 'late')>Late</option>
              <option value="absent" @selected(old('status') == 'absent')>Absent</option>
              <option value="leave" @selected(old('status') == 'leave')>Leave</option>
            </select>
          </div>

          <div class="flex items-end md:col-span-2">
            <button
              type="submit"
              class="h-12 w-full rounded-lg bg-blue-600 px-4 font-semibold text-white hover:bg-blue-700"
            >
              Save
            </button>
          </div>
        </div>
      </form>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-[#151c2c]">
      <div class="mb-4 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
          Attendance List
        </h2>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
          <thead class="border-b border-gray-200 text-gray-600 dark:border-gray-700 dark:text-gray-400">
          <tr>
            <th class="px-4 py-3">Staff</th>
            <th class="px-4 py-3">Date</th>
            <th class="px-4 py-3">Check In</th>
            <th class="px-4 py-3">Check Out</th>
            <th class="px-4 py-3">Hours</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3 text-right">Actions</th>
          </tr>
          </thead>

          <tbody>
          @forelse($attendances as $attendance)
            <tr class="border-b border-gray-100 text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-[#1b2436]">
              <td class="px-4 py-4 font-medium">
                {{ $attendance->staff->full_name ?? 'N/A' }}
              </td>

              <td class="px-4 py-4">
                {{ $attendance->work_date?->format('d/m/Y') }}
              </td>

              <td class="px-4 py-4">
                {{ $attendance->check_in?->format('H:i') ?? '-' }}
              </td>

              <td class="px-4 py-4">
                {{ $attendance->check_out?->format('H:i') ?? '-' }}
              </td>

              <td class="px-4 py-4">
                {{ $attendance->working_hours }} h
              </td>

              <td class="px-4 py-4">
                  <span class="rounded-full px-3 py-1 text-xs
                    @if($attendance->status === 'present') bg-green-500/10 text-green-600 dark:bg-green-500/20 dark:text-green-300
                    @elseif($attendance->status === 'late') bg-yellow-500/10 text-yellow-600 dark:bg-yellow-500/20 dark:text-yellow-300
                    @elseif($attendance->status === 'absent') bg-red-500/10 text-red-600 dark:bg-red-500/20 dark:text-red-300
                    @else bg-blue-500/10 text-blue-600 dark:bg-blue-500/20 dark:text-blue-300
                    @endif">
                    {{ ucfirst($attendance->status) }}
                  </span>
              </td>

              <td class="px-4 py-4 text-right">
                <button
                  type="button"
                  onclick="toggleEditAttendance({{ $attendance->id }})"
                  class="rounded-lg bg-yellow-500/10 px-3 py-1 text-yellow-600 hover:bg-yellow-500/20 dark:bg-yellow-500/20 dark:text-yellow-300 dark:hover:bg-yellow-500/30"
                >
                  Edit
                </button>

                <form
                  method="POST"
                  action="{{ route('staff.attendance.destroy', $attendance) }}"
                  class="inline"
                >
                  @csrf
                  @method('DELETE')

                  <button
                    type="submit"
                    onclick="return confirm('Delete this attendance?')"
                    class="rounded-lg bg-red-500/10 px-3 py-1 text-red-600 hover:bg-red-500/20 dark:bg-red-500/20 dark:text-red-300 dark:hover:bg-red-500/30"
                  >
                    Delete
                  </button>
                </form>
              </td>
            </tr>

            <tr
              id="edit-attendance-{{ $attendance->id }}"
              class="hidden border-b border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-[#101827]"
            >
              <td colspan="7" class="px-4 py-4">
                <form method="POST" action="{{ route('staff.attendance.update', $attendance) }}">
                  @csrf
                  @method('PUT')

                  <div class="grid grid-cols-1 gap-4 md:grid-cols-7">
                    <select
                      name="staff_id"
                      required
                      class="h-12 rounded-lg border border-gray-300 bg-white px-3 text-gray-900 outline-none focus:border-blue-500 dark:border-gray-700 dark:bg-[#0f1726] dark:text-white"
                    >
                      @foreach($staff as $item)
                        <option value="{{ $item->id }}" @selected($attendance->staff_id == $item->id)>
                          {{ $item->full_name }}
                        </option>
                      @endforeach
                    </select>

                    <input
                      type="date"
                      name="work_date"
                      required
                      value="{{ $attendance->work_date?->format('Y-m-d') }}"
                      class="h-12 rounded-lg border border-gray-300 bg-white px-3 text-gray-900 outline-none focus:border-blue-500 dark:border-gray-700 dark:bg-[#0f1726] dark:text-white"
                    >

                    <input
                      type="time"
                      name="check_in_time"
                      value="{{ $attendance->check_in?->format('H:i') }}"
                      class="h-12 rounded-lg border border-gray-300 bg-white px-3 text-gray-900 outline-none focus:border-blue-500 dark:border-gray-700 dark:bg-[#0f1726] dark:text-white"
                    >

                    <input
                      type="time"
                      name="check_out_time"
                      value="{{ $attendance->check_out?->format('H:i') }}"
                      class="h-12 rounded-lg border border-gray-300 bg-white px-3 text-gray-900 outline-none focus:border-blue-500 dark:border-gray-700 dark:bg-[#0f1726] dark:text-white"
                    >

                    <select
                      name="status"
                      required
                      class="h-12 rounded-lg border border-gray-300 bg-white px-3 text-gray-900 outline-none focus:border-blue-500 dark:border-gray-700 dark:bg-[#0f1726] dark:text-white"
                    >
                      <option value="present" @selected($attendance->status === 'present')>Present</option>
                      <option value="late" @selected($attendance->status === 'late')>Late</option>
                      <option value="absent" @selected($attendance->status === 'absent')>Absent</option>
                      <option value="leave" @selected($attendance->status === 'leave')>Leave</option>
                    </select>

                    <button
                      type="submit"
                      class="h-12 rounded-lg bg-blue-600 px-4 font-semibold text-white hover:bg-blue-700 md:col-span-2"
                    >
                      Update
                    </button>
                  </div>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                No attendance records found.
              </td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-4">
        {{ $attendances->links() }}
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
