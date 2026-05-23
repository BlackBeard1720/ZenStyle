<div
  class="rounded-2xl border border-gray-200 bg-white px-5 pt-5 pb-5 sm:px-6 sm:pt-6 dark:border-gray-800 dark:bg-white/[0.03]"
>
  <div class="mb-6 flex flex-col gap-5 sm:flex-row sm:justify-between">
    <div class="w-full">
      <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
        Statistics
      </h3>
      <p class="text-theme-sm mt-1 text-gray-500 dark:text-gray-400">
        Target you’ve set for each month
      </p>
    </div>

    <div class="flex flex-wrap items-center gap-3 sm:justify-end">
      <div class="flex flex-wrap items-center gap-2">
        <button id="quick-7" class="text-theme-sm rounded-md px-3 py-2 font-medium bg-gray-50">Last 7</button>
        <button id="quick-30" class="text-theme-sm rounded-md px-3 py-2 font-medium bg-gray-50">Last 30</button>
        <button id="quick-month" class="text-theme-sm rounded-md px-3 py-2 font-medium bg-gray-50">Month</button>
        <button id="quick-year" class="text-theme-sm rounded-md px-3 py-2 font-medium bg-gray-50">Year</button>
      </div>
      <div class="flex flex-wrap items-center gap-2">
        <div class="relative">
          <input
            id="dashboard-date-range"
            class="datepicker text-theme-sm shadow-theme-xs h-10 w-52 rounded-lg border border-gray-200 bg-white py-2.5 pr-4 pl-10 font-medium text-gray-700 focus:ring-0 focus:outline-none focus-visible:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
            placeholder="Select dates"
            data-class="flatpickr-right"
            readonly="readonly"
          />
          <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
            <svg
              class="fill-gray-700 dark:fill-gray-400"
              width="20"
              height="20"
              viewBox="0 0 20 20"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M6.66683 1.54199C7.08104 1.54199 7.41683 1.87778 7.41683 2.29199V3.00033H12.5835V2.29199C12.5835 1.87778 12.9193 1.54199 13.3335 1.54199C13.7477 1.54199 14.0835 1.87778 14.0835 2.29199V3.00033L15.4168 3.00033C16.5214 3.00033 17.4168 3.89576 17.4168 5.00033V7.50033V15.8337C17.4168 16.9382 16.5214 17.8337 15.4168 17.8337H4.5835C3.47893 17.8337 2.5835 16.9382 2.5835 15.8337V7.50033V5.00033C2.5835 3.89576 3.47893 3.00033 4.5835 3.00033L5.91683 3.00033V2.29199C5.91683 1.87778 6.25262 1.54199 6.66683 1.54199ZM6.66683 4.50033H4.5835C4.30735 4.50033 4.0835 4.72418 4.0835 5.00033V6.75033H15.9168V5.00033C15.9168 4.72418 15.693 4.50033 15.4168 4.50033H13.3335H6.66683ZM15.9168 8.25033H4.0835V15.8337C4.0835 16.1098 4.30735 16.3337 4.5835 16.3337H15.4168C15.693 16.3337 15.9168 16.1098 15.9168 15.8337V8.25033Z"
                fill=""
              />
            </svg>
          </div>
        </div>
        <select id="dashboard-group" class="h-10 rounded-md border border-gray-200 bg-white px-3 text-theme-sm font-medium text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
          <option value="day">Day</option>
          <option value="month" selected>Month</option>
          <option value="year">Year</option>
        </select>
      </div>
    </div>
    </div>
  </div>
  <div class="custom-scrollbar max-w-full overflow-x-auto">
    <div id="chartThree" class="-ml-4 min-w-[700px] pl-2"></div>
  </div>
</div>
