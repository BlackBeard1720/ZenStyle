<x-staff.layout title="Payrolls" page-name="PayrollManagement">
  <div x-data="{ pageName: `Payrolls` }">
    <x-staff.partials.breadcrumb />
  </div>

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

    {{-- Generate Payroll Panel --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6 shadow-theme-xs">
      <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Generate Monthly Payroll</h3>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Calculate base salary plus service commission from paid appointments.</p>

      <form method="POST" action="{{ route('staff.payrolls.generate') }}" class="mt-5">
        @csrf
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 md:grid-cols-4 items-end">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Month</label>
            <div x-data="{ isOptionSelected: true }" class="relative z-20 bg-transparent">
              <select
                name="month"
                class="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
              >
                @for($i = 1; $i <= 12; $i++)
                  <option value="{{ $i }}" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected($month == $i)>
                    Month {{ $i }}
                  </option>
                @endfor
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </div>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Year</label>
            <input
              type="number"
              name="year"
              value="{{ $year }}"
              required
              class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
            />
          </div>

          <div class="sm:col-span-1 md:col-span-2">
            <button
              type="submit"
              class="inline-flex h-11 items-center justify-center rounded-lg bg-brand-500 px-5 text-sm font-medium text-white hover:bg-brand-600 shadow-theme-xs"
            >
              Generate Payroll
            </button>
          </div>
        </div>
      </form>
    </div>

    {{-- Payroll List Panel --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 sm:px-6 sm:py-5">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Payroll List</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Browse and manage generated staff payrolls.</p>
          </div>

          {{-- Filter Form --}}
          <form method="GET" action="{{ route('staff.payrolls.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="relative z-20 bg-transparent min-w-[7rem]">
              <select
                name="month"
                class="h-10 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-3 py-1.5 pr-9 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
              >
                @for($i = 1; $i <= 12; $i++)
                  <option value="{{ $i }}" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected($month == $i)>
                    Month {{ $i }}
                  </option>
                @endfor
              </select>
              <span class="pointer-events-none absolute top-1/2 right-3 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                <svg class="stroke-current" width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </div>

            <input
              type="number"
              name="year"
              value="{{ $year }}"
              class="h-10 w-24 rounded-lg border border-gray-300 bg-transparent px-3 py-1.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
            />

            <button type="submit" class="inline-flex h-10 items-center justify-center rounded-lg bg-gray-100 px-4 text-sm font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 border border-gray-300 dark:border-gray-700">
              Filter
            </button>
          </form>
        </div>
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
                <th class="w-24 px-4 pb-3 pt-4 text-left sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Month</p>
                </th>
                <th class="w-24 px-4 pb-3 pt-4 text-left sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Year</p>
                </th>
                <th class="w-36 px-4 pb-3 pt-4 text-left sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Base Salary</p>
                </th>
                <th class="w-36 px-4 pb-3 pt-4 text-left sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Commission</p>
                </th>
                <th class="w-36 px-4 pb-3 pt-4 text-left sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Total Salary</p>
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
              @forelse($payrolls as $payroll)
                @php
                  $badgeClass = match($payroll->status) {
                    'paid' => 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500',
                    'confirmed' => 'bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-500',
                    default => 'bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-500', // draft
                  };
                @endphp
                <tr class="align-top hover:bg-gray-50/50 dark:hover:bg-white/[0.01]">
                  <td class="px-4 py-4 sm:px-6">
                    <p class="font-medium text-theme-sm text-gray-800 dark:text-white/90">{{ $payroll->staff->full_name ?? 'N/A' }}</p>
                  </td>
                  <td class="px-4 py-4 sm:px-6">
                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $payroll->month }}</p>
                  </td>
                  <td class="px-4 py-4 sm:px-6">
                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $payroll->year }}</p>
                  </td>
                  <td class="px-4 py-4 sm:px-6">
                    <p class="text-theme-sm text-gray-800 dark:text-white/90">${{ number_format($payroll->base_salary, 2) }}</p>
                  </td>
                  <td class="px-4 py-4 sm:px-6">
                    <p class="text-theme-sm text-brand-600 dark:text-brand-400 font-medium">${{ number_format($payroll->commission, 2) }}</p>
                  </td>
                  <td class="px-4 py-4 sm:px-6">
                    <p class="text-theme-sm text-success-600 dark:text-success-400 font-semibold">${{ number_format($payroll->total_salary, 2) }}</p>
                  </td>
                  <td class="px-4 py-4 sm:px-6">
                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badgeClass }}">
                      {{ ucfirst($payroll->status) }}
                    </span>
                  </td>
                  <td class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-end gap-2 whitespace-nowrap">
                      @if($payroll->status === 'draft')
                        <form method="POST" action="{{ route('staff.payrolls.confirm', $payroll) }}" class="inline">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="inline-flex min-w-[76px] items-center justify-center rounded-md bg-brand-500 px-2.5 py-1 text-center text-xs font-medium text-white shadow-theme-xs hover:bg-brand-600">
                            Confirm
                          </button>
                        </form>
                      @endif

                      @if($payroll->status === 'confirmed')
                        <form method="POST" action="{{ route('staff.payrolls.paid', $payroll) }}" class="inline">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="inline-flex min-w-[76px] items-center justify-center rounded-md bg-success-500 px-2.5 py-1 text-center text-xs font-medium text-white shadow-theme-xs hover:bg-success-600">
                            Paid
                          </button>
                        </form>
                      @endif

                      <x-staff.confirm-action
                        action="{{ route('staff.payrolls.destroy', $payroll) }}"
                        method="DELETE"
                        title="Delete Payroll"
                        message="Delete this payroll?"
                        variant="danger"
                        buttonText="Delete"
                        buttonClass="inline-flex min-w-[76px] items-center justify-center rounded-md bg-error-500 px-2.5 py-1 text-center text-xs font-medium text-white shadow-theme-xs hover:bg-error-600"
                      />
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                    No payroll records found.
                  </td>
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
  </div>
</x-staff.layout>
