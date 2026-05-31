<x-staff.layout title="Categories" page-name="CategoryManagement">
  <div x-data="{ pageName: `Categories` }">
    <x-staff.partials.breadcrumb />
  </div>

  <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 sm:px-6 sm:py-5">
      <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Categories</h3>
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage service categories used by salon services.</p>
        </div>
        @can('manage-categories')
          <a href="{{ route('staff.categories.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-theme-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
            </svg>
            Create Category
          </a>
        @endcan
      </div>
    </div>

    <div class="p-5 sm:p-6">
      <form method="GET" action="{{ route('staff.categories.index') }}" class="mb-5 grid grid-cols-1 gap-4 md:grid-cols-4">
        <input
          type="text"
          name="keyword"
          value="{{ request('keyword') }}"
          placeholder="Name, description"
          class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
        >

        <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
          <select
            name="status"
            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
            @change="isOptionSelected = true"
          >
            <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">All statuses</option>
            <option value="active" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected(request('status') === 'active')>Active</option>
            <option value="inactive" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected(request('status') === 'inactive')>Inactive</option>
          </select>
          <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
        </div>

        <button type="submit" class="inline-flex h-11 items-center justify-center rounded-lg bg-brand-500 px-4 text-sm font-medium text-white hover:bg-brand-600">Search</button>
        <a href="{{ route('staff.categories.index') }}" class="inline-flex h-11 items-center justify-center rounded-lg border border-gray-300 px-4 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800">Reset</a>
      </form>

      <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="w-full overflow-x-auto">
          <table class="min-w-full table-fixed">
            <thead>
            <tr class="border-b border-gray-100 dark:border-gray-800">
              <th class="w-20 px-4 pb-3 pt-4 text-left sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">ID</p>
              </th>
              <th class="w-64 px-4 pb-3 pt-4 text-left sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Category</p>
              </th>
              <th class="px-4 pb-3 pt-4 text-left sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Description</p>
              </th>
              <th class="w-32 px-4 pb-3 pt-4 text-left sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Services</p>
              </th>
              <th class="w-32 px-4 pb-3 pt-4 text-left sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
              </th>
              <th class="w-28 px-4 pb-3 pt-4 text-right sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Actions</p>
              </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($categories as $category)
              @php
                $badgeClass = $category->status === 'active'
                  ? 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500'
                  : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300';
              @endphp
              <tr class="align-top">
                <td class="px-4 py-4 sm:px-6">
                  <p class="text-theme-sm text-gray-500 dark:text-gray-400">#{{ $category->id }}</p>
                </td>
                <td class="px-4 py-4 sm:px-6">
                  <p class="truncate font-medium text-theme-sm text-gray-800 dark:text-white/90">{{ $category->name }}</p>
                </td>
                <td class="px-4 py-4 sm:px-6">
                  <p class="line-clamp-2 text-theme-sm text-gray-500 dark:text-gray-400">{{ \Illuminate\Support\Str::limit($category->description, 120) ?: '-' }}</p>
                </td>
                <td class="px-4 py-4 sm:px-6">
                  <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $category->services_count }}</p>
                </td>
                <td class="px-4 py-4 sm:px-6">
                  <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badgeClass }}">{{ ucfirst($category->status) }}</span>
                </td>
                <td class="px-4 py-4 sm:px-6">
                  <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('staff.categories.show', $category) }}" title="View category" class="text-gray-500 hover:text-brand-600 dark:text-gray-400">
                      <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                    </a>
                    @can('manage-categories')
                      <a href="{{ route('staff.categories.edit', $category) }}" title="Edit category" class="text-gray-500 hover:text-blue-600 dark:text-gray-400">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487 18.55 2.8a1.875 1.875 0 0 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 7.125 16.875 4.5"/></svg>
                      </a>
                      <x-staff.confirm-action
                        action="{{ route('staff.categories.destroy', $category) }}"
                        method="DELETE"
                        title="Delete Category"
                        message="Delete this category? Categories with services will be marked inactive instead."
                        variant="danger"
                      >
                        <button type="button" title="Delete category" aria-label="Delete category" class="text-gray-500 hover:text-error-600 dark:text-gray-400">
                          <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21.75H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                          </svg>
                        </button>
                      </x-staff.confirm-action>
                    @endcan
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">No categories found.</td>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="mt-5">
        {{ $categories->links() }}
      </div>
    </div>
  </div>
</x-staff.layout>
