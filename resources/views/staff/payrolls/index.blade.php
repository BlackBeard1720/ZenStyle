<x-staff.layout>

  <div class="p-6 text-gray-900 dark:text-white">
    <div class="mb-6 flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
          Payrolls
        </h1>

        <p class="text-sm text-gray-500 dark:text-gray-400">
          Base salary + service commission from paid appointments
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
      <form method="POST" action="{{ route('staff.payrolls.generate') }}">
        @csrf

        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
          <div>
            <label class="mb-1 block text-sm text-gray-700 dark:text-gray-300">Month</label>
            <select name="month"
                    class="h-12 w-full rounded-lg border border-gray-300 bg-gray-50 px-3 text-gray-900 outline-none focus:border-blue-500 dark:border-gray-700 dark:bg-[#0f1726] dark:text-white">
              @for($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" @selected($month == $i)>
                  Month {{ $i }}
                </option>
              @endfor
            </select>
          </div>

          <div>
            <label class="mb-1 block text-sm text-gray-700 dark:text-gray-300">Year</label>
            <input type="number"
                   name="year"
                   value="{{ $year }}"
                   class="h-12 w-full rounded-lg border border-gray-300 bg-gray-50 px-3 text-gray-900 outline-none focus:border-blue-500 dark:border-gray-700 dark:bg-[#0f1726] dark:text-white">
          </div>

          <div class="flex items-end">
            <button type="submit"
                    class="h-12 rounded-lg bg-blue-600 px-4 font-semibold text-white hover:bg-blue-700">
              Generate Payroll
            </button>
          </div>
        </div>
      </form>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-[#151c2c]">
      <div class="mb-4 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
          Payroll List
        </h2>

        <form method="GET" action="{{ route('staff.payrolls.index') }}" class="flex gap-2">
          <select name="month"
                  class="h-10 rounded-lg border border-gray-300 bg-gray-50 px-3 text-gray-900 outline-none focus:border-blue-500 dark:border-gray-700 dark:bg-[#0f1726] dark:text-white">
            @for($i = 1; $i <= 12; $i++)
              <option value="{{ $i }}" @selected($month == $i)>
                {{ $i }}
              </option>
            @endfor
          </select>

          <input type="number"
                 name="year"
                 value="{{ $year }}"
                 class="h-10 w-24 rounded-lg border border-gray-300 bg-gray-50 px-3 text-gray-900 outline-none focus:border-blue-500 dark:border-gray-700 dark:bg-[#0f1726] dark:text-white">

          <button class="h-10 rounded-lg bg-gray-100 px-4 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
            Filter
          </button>
        </form>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
          <thead class="border-b border-gray-200 text-gray-600 dark:border-gray-700 dark:text-gray-400">
          <tr>
            <th class="px-4 py-3">Staff</th>
            <th class="px-4 py-3">Month</th>
            <th class="px-4 py-3">Year</th>
            <th class="px-4 py-3">Base Salary</th>
            <th class="px-4 py-3">Commission</th>
            <th class="px-4 py-3">Total Salary</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3 text-right">Actions</th>
          </tr>
          </thead>

          <tbody>
          @forelse($payrolls as $payroll)
            <tr class="border-b border-gray-100 text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-[#1b2436]">
              <td class="px-4 py-4 font-medium">
                {{ $payroll->staff->full_name ?? 'N/A' }}
              </td>

              <td class="px-4 py-4">
                {{ $payroll->month }}
              </td>

              <td class="px-4 py-4">
                {{ $payroll->year }}
              </td>

              <td class="px-4 py-4">
                ${{ number_format($payroll->base_salary, 2) }}
              </td>

              <td class="px-4 py-4 text-blue-600 dark:text-blue-300">
                ${{ number_format($payroll->commission, 2) }}
              </td>

              <td class="px-4 py-4 font-bold text-green-600 dark:text-green-400">
                ${{ number_format($payroll->total_salary, 2) }}
              </td>

              <td class="px-4 py-4">
                <span class="rounded-full px-3 py-1 text-xs
                  @if($payroll->status === 'paid') bg-green-500/10 text-green-600 dark:bg-green-500/20 dark:text-green-300
                  @elseif($payroll->status === 'confirmed') bg-blue-500/10 text-blue-600 dark:bg-blue-500/20 dark:text-blue-300
                  @else bg-yellow-500/10 text-yellow-600 dark:bg-yellow-500/20 dark:text-yellow-300
                  @endif">
                  {{ ucfirst($payroll->status) }}
                </span>
              </td>

              <td class="px-4 py-4 text-right">
                @if($payroll->status === 'draft')
                  <form method="POST"
                        action="{{ route('staff.payrolls.confirm', $payroll) }}"
                        class="inline">
                    @csrf
                    @method('PATCH')

                    <button class="rounded-lg bg-blue-500/10 px-3 py-1 text-blue-600 hover:bg-blue-500/20 dark:bg-blue-500/20 dark:text-blue-300 dark:hover:bg-blue-500/30">
                      Confirm
                    </button>
                  </form>
                @endif

                @if($payroll->status === 'confirmed')
                  <form method="POST"
                        action="{{ route('staff.payrolls.paid', $payroll) }}"
                        class="inline">
                    @csrf
                    @method('PATCH')

                    <button class="rounded-lg bg-green-500/10 px-3 py-1 text-green-600 hover:bg-green-500/20 dark:bg-green-500/20 dark:text-green-300 dark:hover:bg-green-500/30">
                      Paid
                    </button>
                  </form>
                @endif

                <form method="POST"
                      action="{{ route('staff.payrolls.destroy', $payroll) }}"
                      class="inline">
                  @csrf
                  @method('DELETE')

                  <button onclick="return confirm('Delete this payroll?')"
                          class="rounded-lg bg-red-500/10 px-3 py-1 text-red-600 hover:bg-red-500/20 dark:bg-red-500/20 dark:text-red-300 dark:hover:bg-red-500/30">
                    Delete
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                No payrolls found.
              </td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-4">
        {{ $payrolls->links() }}
      </div>
    </div>
  </div>

  <style>
    input,
    select {
      color-scheme: light;
    }

    .dark input,
    .dark select {
      color-scheme: dark;
    }
  </style>

</x-staff.layout>
