<x-staff.layout title="Category Detail" page-name="CategoryManagement">
  <div x-data="{ pageName: `Category #{{ $category->id }}` }">
    <x-staff.partials.breadcrumb />
  </div>

  @php
    $badgeClass = $category->status === 'active'
      ? 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500'
      : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300';
  @endphp

  <div class="space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-4 dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between sm:px-6 sm:py-5">
        <div>
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ $category->name }}</h3>
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Category #{{ $category->id }}</p>
        </div>
        <span class="inline-flex w-fit rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badgeClass }}">{{ ucfirst($category->status) }}</span>
      </div>

      <div class="grid grid-cols-1 gap-6 p-5 sm:p-6 lg:grid-cols-2">
        <div>
          <h4 class="mb-3 text-sm font-semibold text-gray-800 dark:text-white/90">Usage</h4>
          <dl class="space-y-2 text-sm">
            <div><dt class="text-gray-500 dark:text-gray-400">Services</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ $category->services_count }}</dd></div>
            <div><dt class="text-gray-500 dark:text-gray-400">Updated at</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ optional($category->updated_at)->format('Y-m-d H:i') }}</dd></div>
          </dl>
        </div>

        <div class="lg:col-span-2">
          <h4 class="mb-3 text-sm font-semibold text-gray-800 dark:text-white/90">Description</h4>
          <p class="rounded-lg border border-gray-200 p-4 text-sm text-gray-600 dark:border-gray-800 dark:text-gray-300">{{ $category->description ?: '-' }}</p>
        </div>
      </div>
    </div>

    <div class="flex flex-wrap items-center justify-end gap-3">
      <a href="{{ route('staff.categories.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">Back</a>
      @can('manage-categories')
        <a href="{{ route('staff.categories.edit', $category) }}" class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">Edit</a>
        <x-staff.confirm-action
          action="{{ route('staff.categories.destroy', $category) }}"
          method="DELETE"
          title="Delete Category"
          message="Delete this category? Categories with services will be marked inactive instead."
          variant="danger"
          buttonText="Delete"
          buttonClass="inline-flex items-center justify-center rounded-lg bg-error-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-error-600"
        />
      @endcan
    </div>
  </div>
</x-staff.layout>
