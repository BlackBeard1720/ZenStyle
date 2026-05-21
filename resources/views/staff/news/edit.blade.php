<x-staff.layout title="Edit News" page-name="NewsManagement">
  <div x-data="{ pageName: `Edit News #{{ $news->id }}` }">
    <x-staff.partials.breadcrumb />
  </div>

  <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 sm:px-6 sm:py-5">
      <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Edit News #{{ $news->id }}</h3>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Update article content, publishing status, and cover image.</p>
    </div>

    <form method="POST" action="{{ route('staff.news.update', $news) }}" class="news-form space-y-6 p-5 sm:p-6" novalidate>
      @csrf
      @method('PUT')
      @include('staff.partials.news.form', ['news' => $news])

      <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-5 dark:border-gray-800">
        <a href="{{ route('staff.news.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
          Back
        </a>
        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
          Update News
        </button>
      </div>
    </form>
  </div>
</x-staff.layout>
