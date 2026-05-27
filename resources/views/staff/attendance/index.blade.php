<x-staff.layout>

  <div class="p-6 text-white">

    <div class="mb-6">

      <h1 class="text-2xl font-bold">
        Attendance
      </h1>

      <p class="text-sm text-gray-400">
        Employee attendance management
      </p>

    </div>

    <div class="mb-6 rounded-2xl border border-gray-700 bg-[#151c2c] p-5">

      <form method="POST"
            action="{{ route('staff.attendance.store') }}">

        @csrf

        <div class="grid grid-cols-1 gap-4 md:grid-cols-6">

          <div>

            <label class="mb-1 block text-sm text-gray-300">
              Staff
            </label>

            <select name="staff_id"
                    class="w-full rounded-lg border border-gray-700 bg-[#0f1726] px-3 py-2 text-white">

              @foreach($staff as $item)

                <option value="{{ $item->id }}">
                  {{ $item->full_name }}
                </option>

              @endforeach

            </select>

          </div>

          <div>

            <label class="mb-1 block text-sm text-gray-300">
              Work Date
            </label>

            <input type="date"
                   name="work_date"
                   class="w-full rounded-lg border border-gray-700 bg-[#0f1726] px-3 py-2 text-white">

          </div>

          <div>

            <label class="mb-1 block text-sm text-gray-300">
              Check In
            </label>

            <input type="datetime-local"
                   name="check_in"
                   class="w-full rounded-lg border border-gray-700 bg-[#0f1726] px-3 py-2 text-white">

          </div>

          <div>

            <label class="mb-1 block text-sm text-gray-300">
              Check Out
            </label>

            <input type="datetime-local"
                   name="check_out"
                   class="w-full rounded-lg border border-gray-700 bg-[#0f1726] px-3 py-2 text-white">

          </div>

          <div>

            <label class="mb-1 block text-sm text-gray-300">
              Status
            </label>

            <select name="status"
                    class="w-full rounded-lg border border-gray-700 bg-[#0f1726] px-3 py-2 text-white">

              <option value="present">Present</option>
              <option value="late">Late</option>
              <option value="absent">Absent</option>
              <option value="leave">Leave</option>

            </select>

          </div>

          <div class="flex items-end">

            <button class="w-full rounded-lg bg-blue-600 px-4 py-2 hover:bg-blue-700">

              Save

            </button>

          </div>

        </div>

      </form>

    </div>

    <div class="overflow-hidden rounded-2xl border border-gray-700 bg-[#151c2c]">

      <table class="w-full text-left text-sm">

        <thead class="border-b border-gray-700 text-gray-400">

        <tr>
          <th class="px-4 py-3">Staff</th>
          <th class="px-4 py-3">Date</th>
          <th class="px-4 py-3">Check In</th>
          <th class="px-4 py-3">Check Out</th>
          <th class="px-4 py-3">Hours</th>
          <th class="px-4 py-3">Status</th>
        </tr>

        </thead>

        <tbody>

        @foreach($attendances as $attendance)

          <tr class="border-b border-gray-800">

            <td class="px-4 py-4">
              {{ $attendance->staff->full_name }}
            </td>

            <td class="px-4 py-4">
              {{ $attendance->work_date->format('d/m/Y') }}
            </td>

            <td class="px-4 py-4">
              {{ $attendance->check_in }}
            </td>

            <td class="px-4 py-4">
              {{ $attendance->check_out }}
            </td>

            <td class="px-4 py-4">
              {{ $attendance->working_hours }} h
            </td>

            <td class="px-4 py-4">
              {{ ucfirst($attendance->status) }}
            </td>

          </tr>

        @endforeach

        </tbody>

      </table>

    </div>

  </div>

</x-staff.layout>
