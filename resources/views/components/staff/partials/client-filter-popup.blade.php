<div
  x-show="openFilter"
  x-cloak
  @click.away="openFilter = false"
  class="absolute top-full right-0 mt-2 w-72 rounded-2xl border bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800"
>
  <form method="GET" action="{{ url()->current() }}" class="p-4">
    <h3 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">
      Filter Clients
    </h3>

    <div class="mb-3">
      <label class="text-sm text-gray-600 dark:text-gray-400">Client ID</label>
      <input
        name="id"
        type="text"
        value="{{ request('id') }}"
        class="mt-1 w-full rounded-lg border px-3 py-2 dark:border-gray-600 dark:bg-gray-700 focus:border-brand-500 focus:ring-brand-500"
        placeholder="e.g. 1"
      />
    </div>

    <div class="mb-3">
      <label class="text-sm text-gray-600 dark:text-gray-400">Full Name</label>
      <input
        name="full_name"
        type="text"
        value="{{ request('full_name') }}"
        class="mt-1 w-full rounded-lg border px-3 py-2 dark:border-gray-600 dark:bg-gray-700 focus:border-brand-500 focus:ring-brand-500"
        placeholder="e.g. Nguyen"
      />
    </div>

    <div class="mb-3">
      <label class="text-sm text-gray-600 dark:text-gray-400">Phone</label>
      <input
        name="phone"
        type="text"
        value="{{ request('phone') }}"
        class="mt-1 w-full rounded-lg border px-3 py-2 dark:border-gray-600 dark:bg-gray-700 focus:border-brand-500 focus:ring-brand-500"
        placeholder="e.g. 090"
      />
    </div>

    <div class="mb-4">
      <label class="text-sm text-gray-600 dark:text-gray-400">Status</label>
      <select
        name="status"
        class="mt-1 w-full rounded-lg border px-3 py-2 dark:border-gray-600 dark:bg-gray-700 focus:border-brand-500 focus:ring-brand-500"
      >
        <option value="">All</option>
        <option value="active" @selected(request('status') === 'active')>Active</option>
        <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
      </select>
    </div>

    <div class="flex justify-end gap-2">
      <button
        type="button"
        @click="openFilter = false"
        class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]"
      >
        Cancel
      </button>
      <a
        href="{{ route('staff.clients.index') }}"
        class="inline-flex items-center gap-2 rounded-lg bg-error-50 px-4 py-3 text-sm font-medium text-error-600 shadow-theme-xs transition hover:bg-error-100 dark:bg-error-500/15 dark:text-error-500 dark:hover:bg-error-500/25"
      >
        Reset
      </a>
      <button
        type="submit"
        class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600"
      >
        Apply
      </button>
    </div>
  </form>
</div>
