<x-staff.layout>

  <div class="p-6 text-white">

    <div class="mb-6 flex items-center justify-between">

      <div>
        <h1 class="text-2xl font-bold">
          Staff Schedules
        </h1>

        <p class="text-sm text-gray-400">
          Manage employee working schedules
        </p>
      </div>

    </div>

    @if(session('success'))
      <div class="mb-4 rounded-lg bg-green-500/20 p-4 text-green-300">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="mb-4 rounded-lg bg-red-500/20 p-4 text-red-300">
        {{ $errors->first() }}
      </div>
    @endif

    <div class="mb-6 rounded-2xl border border-gray-700 bg-[#151c2c] p-5">

      <form method="POST"
            action="{{ route('staff.schedules.store') }}">

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
              Start
            </label>

            <input type="time"
                   name="start_time"
                   class="w-full rounded-lg border border-gray-700 bg-[#0f1726] px-3 py-2 text-white">
          </div>

          <div>
            <label class="mb-1 block text-sm text-gray-300">
              End
            </label>

            <input type="time"
                   name="end_time"
                   class="w-full rounded-lg border border-gray-700 bg-[#0f1726] px-3 py-2 text-white">
          </div>

          <div>
            <label class="mb-1 block text-sm text-gray-300">
              Status
            </label>

            <select name="status"
                    class="w-full rounded-lg border border-gray-700 bg-[#0f1726] px-3 py-2 text-white">

              <option value="scheduled">
                Scheduled
              </option>

              <option value="off">
                Off
              </option>

              <option value="leave">
                Leave
              </option>

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
          <th class="px-4 py-3">Start</th>
          <th class="px-4 py-3">End</th>
          <th class="px-4 py-3">Status</th>
          <th class="px-4 py-3">Action</th>
        </tr>

        </thead>

        <tbody>

        @forelse($schedules as $schedule)

          <tr class="border-b border-gray-800">

            <td class="px-4 py-4">
              {{ $schedule->staff->full_name }}
            </td>

            <td class="px-4 py-4">
              {{ $schedule->work_date->format('d/m/Y') }}
            </td>

            <td class="px-4 py-4">
              {{ $schedule->start_time }}
            </td>

            <td class="px-4 py-4">
              {{ $schedule->end_time }}
            </td>

            <td class="px-4 py-4">
              {{ ucfirst($schedule->status) }}
            </td>

            <td class="px-4 py-4">

              <form method="POST"
                    action="{{ route('staff.schedules.destroy', $schedule) }}">

                @csrf
                @method('DELETE')

                <button class="rounded-lg bg-red-500/20 px-3 py-1 text-red-300">

                  Delete

                </button>

              </form>

            </td>

          </tr>

        @empty

          <tr>

            <td colspan="6"
                class="px-4 py-6 text-center text-gray-400">

              No schedules found.

            </td>

          </tr>

        @endforelse

        </tbody>

      </table>

    </div>

  </div>

</x-staff.layout>
