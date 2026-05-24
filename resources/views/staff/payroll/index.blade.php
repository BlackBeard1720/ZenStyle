@php
  $years = range(now()->year - 2, now()->year + 1);

  if (! in_array($year, $years, true)) {
      $years[] = $year;
      sort($years);
  }
@endphp

<x-staff.layout title="Payroll Management" page-name="PayrollManagement">
  <div x-data="{ pageName: `Payroll Management` }">
    <x-staff.partials.breadcrumb />
  </div>

  <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 sm:px-6 sm:py-5">
      <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Payroll Management</h3>
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Calculate staff salary from monthly attendance.</p>
        </div>
      </div>
    </div>

    <div class="p-5 sm:p-6">
      <form method="GET" action="{{ route('staff.payroll.index') }}" class="mb-5 grid grid-cols-1 gap-4 md:grid-cols-5">
        <div x-data="{ isOptionSelected: true }" class="relative z-20 bg-transparent">
          <select
            name="month"
            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            @change="isOptionSelected = true"
          >
            @foreach(range(1, 12) as $monthOption)
              <option value="{{ $monthOption }}" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected($month === $monthOption)>
                Month {{ $monthOption }}
              </option>
            @endforeach
          </select>
          <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
        </div>

        <div x-data="{ isOptionSelected: true }" class="relative z-20 bg-transparent">
          <select
            name="year"
            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            @change="isOptionSelected = true"
          >
            @foreach($years as $yearOption)
              <option value="{{ $yearOption }}" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected($year === $yearOption)>
                {{ $yearOption }}
              </option>
            @endforeach
          </select>
          <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
        </div>

        <button type="submit" class="inline-flex h-11 items-center justify-center rounded-lg bg-brand-500 px-4 text-sm font-medium text-white hover:bg-brand-600">Filter</button>
        @can('manage-payroll')
          <button
            type="submit"
            formaction="{{ route('staff.payroll.generate') }}"
            formmethod="POST"
            name="_token"
            value="{{ csrf_token() }}"
            class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-success-500 px-4 text-sm font-medium text-white hover:bg-success-600"
          >
            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.75v14.5M4.75 12h14.5"/>
            </svg>
            Generate
          </button>
        @endcan
        <a href="{{ route('staff.payroll.index') }}" class="inline-flex h-11 items-center justify-center rounded-lg border border-gray-300 px-4 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800">Reset</a>
      </form>

      <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="w-full overflow-x-auto">
          <table class="min-w-[1260px] table-fixed">
            <thead>
            <tr class="border-b border-gray-100 dark:border-gray-800">
              <th class="w-56 px-4 pb-3 pt-4 text-left sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Staff name</p>
              </th>
              <th class="w-36 px-4 pb-3 pt-4 text-left">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Base Salary</p>
              </th>
              <th class="w-40 px-4 pb-3 pt-4 text-left">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Standard Work Days</p>
              </th>
              <th class="w-36 px-4 pb-3 pt-4 text-left">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Actual Work Days</p>
              </th>
              <th class="w-36 px-4 pb-3 pt-4 text-left">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Bonus</p>
              </th>
              <th class="w-36 px-4 pb-3 pt-4 text-left">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Deduction</p>
              </th>
              <th class="w-40 px-4 pb-3 pt-4 text-left">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Net Salary</p>
              </th>
              <th class="w-32 px-4 pb-3 pt-4 text-left">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
              </th>
              <th class="w-52 px-4 pb-3 pt-4 text-right sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Actions</p>
              </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($payrolls as $payroll)
              @php
                $statusClasses = [
                  'draft' => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300',
                  'confirmed' => 'bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-500',
                  'paid' => 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500',
                ];
                $statusClass = $statusClasses[$payroll->status] ?? $statusClasses['draft'];
                $updateFormId = 'payroll-update-' . $payroll->id;
              @endphp

              <tr class="align-top">
                <td class="px-4 py-4 sm:px-6">
                  <div class="min-w-0">
                    <p class="truncate font-medium text-theme-sm text-gray-800 dark:text-white/90">{{ $payroll->staff?->full_name ?? 'Staff #' . $payroll->staff_id }}</p>
                    <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">{{ $payroll->staff?->email ?? '-' }}</p>
                  </div>
                </td>
                <td class="px-4 py-4">
                  <p class="whitespace-nowrap text-theme-sm text-gray-500 dark:text-gray-400">{{ number_format((float) $payroll->base_salary) }} VND</p>
                </td>
                <td class="px-4 py-4">
                  <input
                    form="{{ $updateFormId }}"
                    type="number"
                    name="standard_work_days"
                    min="1"
                    value="{{ $payroll->standard_work_days }}"
                    class="h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                  >
                </td>
                <td class="px-4 py-4">
                  <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $payroll->actual_work_days }}</p>
                </td>
                <td class="px-4 py-4">
                  <input
                    form="{{ $updateFormId }}"
                    type="number"
                    name="bonus"
                    min="0"
                    step="1000"
                    value="{{ (float) $payroll->bonus }}"
                    class="h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                  >
                </td>
                <td class="px-4 py-4">
                  <input
                    form="{{ $updateFormId }}"
                    type="number"
                    name="deduction"
                    min="0"
                    step="1000"
                    value="{{ (float) $payroll->deduction }}"
                    class="h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                  >
                </td>
                <td class="px-4 py-4">
                  <p class="whitespace-nowrap font-medium text-theme-sm text-gray-800 dark:text-white/90">{{ number_format((float) $payroll->net_salary) }} VND</p>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusClass }}">{{ ucfirst($payroll->status) }}</span>
                </td>
                <td class="px-4 py-4 sm:px-6">
                  <div class="flex flex-wrap items-center justify-end gap-2">
                    @can('manage-payroll')
                      <form id="{{ $updateFormId }}" action="{{ route('staff.payroll.update', $payroll) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex h-9 items-center justify-center rounded-lg bg-brand-500 px-3 text-xs font-medium text-white hover:bg-brand-600">Save</button>
                      </form>

                      @if($payroll->status !== 'confirmed')
                        <form action="{{ route('staff.payroll.confirm', $payroll) }}" method="POST">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="inline-flex h-9 items-center justify-center rounded-lg border border-gray-300 px-3 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800">Confirm</button>
                        </form>
                      @endif

                      @if($payroll->status !== 'paid')
                        <form action="{{ route('staff.payroll.paid', $payroll) }}" method="POST">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="inline-flex h-9 items-center justify-center rounded-lg bg-success-500 px-3 text-xs font-medium text-white hover:bg-success-600">Paid</button>
                        </form>
                      @endif
                    @endcan
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">No payroll found for this month.</td>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="mt-5">
        {{ $payrolls->links() }}
      </div>
    </div>
  </div>
</x-staff.layout>
