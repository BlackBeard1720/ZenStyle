<div
    x-show="openFilter"
    x-cloak
    @click.away="openFilter = false"
    class="absolute top-full right-0 mt-2 w-72 rounded-2xl border bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800"
>
    <form method="GET" action="{{ url()->current() }}" class="p-4">
        <h3 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">
            Filter Users
        </h3>

        <!-- ID -->
        <div class="mb-3">
            <label class="text-sm text-gray-600 dark:text-gray-400">User ID</label>
            <input
                name="id"
                type="text"
                value="{{ request('id') }}"
                class="w-full mt-1 rounded-lg border px-3 py-2 dark:bg-gray-700 dark:border-gray-600 focus:border-brand-500 focus:ring-brand-500"
                placeholder="e.g. 1001"
            />
        </div>

        <!-- NAME -->
        <div class="mb-4">
            <label class="text-sm text-gray-600 dark:text-gray-400">Username</label>
            <input
                name="username"
                type="text"
                value="{{ request('username') }}"
                class="w-full mt-1 rounded-lg border px-3 py-2 dark:bg-gray-700 dark:border-gray-600 focus:border-brand-500 focus:ring-brand-500"
                placeholder="e.g. Alex"
            />
        </div>

        <!-- ACTIONS -->
        <div class="flex justify-end gap-2">
            <button
                type="button"
                @click="openFilter = false"
                class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]"
            >
                Cancel
            </button>
            <a
              href="{{ url()->current() }}"
              class="inline-flex items-center gap-2 rounded-lg border border-error-300 px-4 py-3 text-sm font-medium text-error-600 shadow-theme-xs transition hover:bg-error-50 dark:bg-error-500/15 dark:text-error-500 dark:hover:bg-error-500/25"
            >
              Reset
            </a>
            <button
                type="submit"
                class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600"
            >
                Apply
            </button>
        </div>
    </form>
</div>
