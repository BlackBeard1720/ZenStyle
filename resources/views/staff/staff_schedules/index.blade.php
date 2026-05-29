<x-staff.layout>

  <div class="p-6 text-gray-900 dark:text-white">

    <div class="mb-6 flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
          Staff Schedules
        </h1>

        <p class="text-sm text-gray-500 dark:text-gray-400">
          Manage employee working schedules
        </p>
      </div>
    </div>

    @if(session('success'))
      <div class="mb-4 rounded-lg border border-green-500/30 bg-green-500/10 p-4 text-green-600 dark:text-green-300">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="mb-4 rounded-lg border border-red-500/30 bg-red-500/10 p-4 text-red-600 dark:text-red-300">
        {{ $errors->first() }}
      </div>
    @endif

    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-[#151c2c]">
      <form method="POST" action="{{ route('staff.schedules.store') }}">
        @csrf

        <div class="grid grid-cols-1 gap-4 md:grid-cols-6">

          <div>
            <label class="mb-1 block text-sm text-gray-700 dark:text-gray-300">
              Staff
            </label>

            <select name="staff_id"
                    required
                    class="h-12 w-full rounded-lg border border-gray-300 bg-gray-50 px-3 text-gray-900 outline-none focus:border-blue-500 dark:border-gray-700 dark:bg-[#0f1726] dark:text-white">
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

            <input type="date"
                   name="work_date"
                   required
                   value="{{ old('work_date') }}"
                   class="h-12 w-full rounded-lg border border-gray-300 bg-gray-50 px-3 text-gray-900 outline-none focus:border-blue-500 dark:border-gray-700 dark:bg-[#0f1726] dark:text-white">
          </div>

          <div>
            <label class="mb-1 block text-sm text-gray-700 dark:text-gray-300">
              Start
            </label>

            <input type="time"
                   name="start_time"
                   value="{{ old('start_time') }}"
                   class="h-12 w-full rounded-lg border border-gray-300 bg-gray-50 px-3 text-gray-900 outline-none focus:border-blue-500 dark:border-gray-700 dark:bg-[#0f1726] dark:text-white">
          </div>

          <div>
            <label class="mb-1 block text-sm text-gray-700 dark:text-gray-300">
              End
            </label>

            <input type="time"
                   name="end_time"
                   value="{{ old('end_time') }}"
                   class="h-12 w-full rounded-lg border border-gray-300 bg-gray-50 px-3 text-gray-900 outline-none focus:border-blue-500 dark:border-gray-700 dark:bg-[#0f1726] dark:text-white">
          </div>

          <div>
            <label class="mb-1 block text-sm text-gray-700 dark:text-gray-300">
              Status
            </label>

            <select name="status"
                    required
                    class="h-12 w-full rounded-lg border border-gray-300 bg-gray-50 px-3 text-gray-900 outline-none focus:border-blue-500 dark:border-gray-700 dark:bg-[#0f1726] dark:text-white">
              <option value="scheduled" @selected(old('status') == 'scheduled')>Scheduled</option>
              <option value="off" @selected(old('status') == 'off')>Off</option>
              <option value="leave" @selected(old('status') == 'leave')>Leave</option>
            </select>
          </div>

          <div class="flex items-end">
            <button type="submit"
                    class="h-12 w-full rounded-lg bg-blue-600 px-4 font-semibold text-white hover:bg-blue-700">
              Save
            </button>
          </div>

        </div>
      </form>
    </div>

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-[#151c2c]">
      <table class="w-full text-left text-sm">

        <thead class="border-b border-gray-200 text-gray-600 dark:border-gray-700 dark:text-gray-400">
        <tr>
          <th class="px-4 py-3">Staff</th>
          <th class="px-4 py-3">Date</th>
          <th class="px-4 py-3">Start</th>
          <th class="px-4 py-3">End</th>
          <th class="px-4 py-3">Status</th>
          <th class="px-4 py-3 text-right">Action</th>
        </tr>
        </thead>

        <tbody>
        @forelse($schedules as $schedule)

          <tr class="border-b border-gray-100 text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-[#1b2436]">

            <td class="px-4 py-4 font-medium">
              {{ $schedule->staff->full_name ?? 'N/A' }}
            </td>

            <td class="px-4 py-4">
              {{ $schedule->work_date?->format('d/m/Y') }}
            </td>

            <td class="px-4 py-4">
              {{ $schedule->start_time ? substr($schedule->start_time, 0, 5) : '-' }}
            </td>

            <td class="px-4 py-4">
              {{ $schedule->end_time ? substr($schedule->end_time, 0, 5) : '-' }}
            </td>

            <td class="px-4 py-4">
              <span class="rounded-full px-3 py-1 text-xs
                @if($schedule->status === 'scheduled') bg-green-500/10 text-green-600 dark:bg-green-500/20 dark:text-green-300
                @elseif($schedule->status === 'off') bg-red-500/10 text-red-600 dark:bg-red-500/20 dark:text-red-300
                @else bg-yellow-500/10 text-yellow-600 dark:bg-yellow-500/20 dark:text-yellow-300
                @endif">
                {{ ucfirst($schedule->status) }}
              </span>
            </td>

            <td class="px-4 py-4 text-right">
              <form method="POST"
                    action="{{ route('staff.schedules.destroy', $schedule) }}"
                    class="inline">
                @csrf
                @method('DELETE')

                <button type="submit"
                        onclick="return confirm('Delete this schedule?')"
                        class="rounded-lg bg-red-500/10 px-3 py-1 text-red-600 hover:bg-red-500/20 dark:bg-red-500/20 dark:text-red-300 dark:hover:bg-red-500/30">
                  Delete
                </button>
              </form>
            </td>

          </tr>

        @empty
          <tr>
            <td colspan="6" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
              No schedules found.
            </td>
          </tr>
        @endforelse
        </tbody>

      </table>
    </div>

    <div class="mt-4">
      {{ $schedules->links() }}
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
