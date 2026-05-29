<x-staff.layout title="Edit Comment" page-name="CommentManagement">
  <div x-data="{ pageName: `Edit Comment #{{ $comment->id }}` }">
    <x-staff.partials.breadcrumb />
  </div>

  @php
    $inputClass = 'h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30';
    $textareaClass = 'w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30';
  @endphp

  <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 sm:px-6 sm:py-5">
      <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Edit Comment #{{ $comment->id }}</h3>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Service: <span class="font-medium text-brand-500">{{ $comment->service?->name ?? 'N/A' }}</span></p>
    </div>

    <form method="POST" action="{{ route('staff.comments.update', $comment) }}" class="space-y-6 p-5 sm:p-6" novalidate>
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 gap-6">
        {{-- Author Name --}}
        <div>
          <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
            Author Name <span class="text-error-500">*</span>
          </label>
          <input
            id="name"
            type="text"
            name="name"
            maxlength="100"
            value="{{ old('name', $comment->name) }}"
            class="{{ $inputClass }}"
            required
          />
          <x-staff.form.error name="name" />
        </div>

        {{-- Status --}}
        <div>
          <label for="status" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
            Status <span class="text-error-500">*</span>
          </label>
          <div x-data="{ isOptionSelected: true }" class="relative z-20 bg-transparent">
            <select
              id="status"
              name="status"
              class="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
              :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
              @change="isOptionSelected = true"
            >
              @foreach(['pending' => 'Pending', 'approved' => 'Approved', 'hidden' => 'Hidden'] as $value => $label)
                <option value="{{ $value }}" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected(old('status', $comment->status) === $value)>{{ $label }}</option>
              @endforeach
            </select>
            <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
              <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
          </div>
          <x-staff.form.error name="status" />
        </div>

        {{-- Comment Text --}}
        <div>
          <label for="comment" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
            Comment Content <span class="text-error-500">*</span>
          </label>
          <textarea
            id="comment"
            name="comment"
            rows="5"
            class="{{ $textareaClass }}"
            required
          >{{ old('comment', $comment->comment) }}</textarea>
          <x-staff.form.error name="comment" />
        </div>
      </div>

      {{-- Action Buttons --}}
      <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-5 dark:border-gray-800">
        <a href="{{ route('staff.comments.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
          Cancel
        </a>
        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
          Update Comment
        </button>
      </div>
    </form>
  </div>
</x-staff.layout>
