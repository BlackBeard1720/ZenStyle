<x-staff.layout title="Comments" page-name="CommentManagement">
  <div x-data="{ pageName: `Comments` }">
    <x-staff.partials.breadcrumb />
  </div>

  <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 sm:px-6 sm:py-5">
      <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Comments</h3>
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage service comments from customers.</p>
        </div>
      </div>
    </div>

    <div class="p-5 sm:p-6">
      {{-- Search and Filter Form --}}
      <form method="GET" action="{{ route('staff.comments.index') }}" class="mb-5 grid grid-cols-1 gap-4 md:grid-cols-4">
        <input
          type="text"
          name="keyword"
          value="{{ request('keyword') }}"
          placeholder="Search ID, name, service, comment..."
          class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
        />

        <div x-data="{ isOptionSelected: {{ request('status') ? 'true' : 'false' }} }" class="relative z-20 bg-transparent">
          <select
            name="status"
            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
            @change="isOptionSelected = true"
          >
            <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">All statuses</option>
            @foreach(['pending' => 'Pending', 'approved' => 'Approved', 'hidden' => 'Hidden'] as $value => $label)
              <option value="{{ $value }}" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
          </select>
          <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
        </div>

        <button type="submit" class="inline-flex h-11 items-center justify-center rounded-lg bg-brand-500 px-4 text-sm font-medium text-white hover:bg-brand-600 shadow-theme-xs">
          Search
        </button>
        <a href="{{ route('staff.comments.index') }}" class="inline-flex h-11 items-center justify-center rounded-lg border border-gray-300 px-4 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800">
          Reset
        </a>
      </form>

      {{-- Table --}}
      <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="w-full overflow-x-auto">
          <table class="min-w-full table-fixed">
            <thead>
            <tr class="border-b border-gray-100 dark:border-gray-800">
              <th class="w-20 px-4 pb-3 pt-4 text-left sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">ID</p>
              </th>
              <th class="w-52 px-4 pb-3 pt-4 text-left sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Service Name</p>
              </th>
              <th class="w-44 px-4 pb-3 pt-4 text-left sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Author</p>
              </th>
              <th class="px-4 pb-3 pt-4 text-left sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Comment</p>
              </th>
              <th class="w-32 px-4 pb-3 pt-4 text-left sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
              </th>
              <th class="w-40 px-4 pb-3 pt-4 text-left sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Created At</p>
              </th>
              <th class="w-44 px-4 pb-3 pt-4 text-right sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Actions</p>
              </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($comments as $item)
              @php
                $badgeClass = match($item->status) {
                  'approved' => 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500',
                  'hidden' => 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500',
                  default => 'bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-500', // pending
                };
              @endphp
              <tr class="align-top">
                <td class="px-4 py-4 sm:px-6">
                  <p class="text-theme-sm text-gray-500 dark:text-gray-400">#{{ $item->id }}</p>
                </td>
                <td class="px-4 py-4 sm:px-6">
                  <p class="font-medium text-theme-sm text-gray-800 dark:text-white/90">{{ $item->service?->name ?? 'N/A' }}</p>
                </td>
                <td class="px-4 py-4 sm:px-6">
                  <p class="text-theme-sm text-gray-800 dark:text-white/90 font-medium">{{ $item->name }}</p>
                </td>
                <td class="px-4 py-4 sm:px-6">
                  <p class="text-theme-sm text-gray-700 dark:text-gray-300 break-words leading-relaxed max-w-md">{{ $item->comment }}</p>
                </td>
                <td class="px-4 py-4 sm:px-6">
                  <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badgeClass }}">
                    {{ ucfirst($item->status) }}
                  </span>
                </td>
                <td class="px-4 py-4 sm:px-6">
                  <p class="text-theme-sm text-gray-800 dark:text-white/90">{{ optional($item->created_at)->format('d/m/Y') }}</p>
                  <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">{{ optional($item->created_at)->format('H:i') }}</p>
                </td>
                <td class="px-4 py-4 sm:px-6">
                  <div class="flex items-center justify-end gap-2 whitespace-nowrap">
                    @if($item->status !== 'approved')
                      <form action="{{ route('staff.comments.approve', $item) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex min-w-[76px] items-center justify-center rounded-md border border-gray-300 bg-white px-2.5 py-1 text-center text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                          Approve
                        </button>
                      </form>
                    @endif
                    <x-staff.confirm-action
                      action="{{ route('staff.comments.destroy', $item) }}"
                      method="DELETE"
                      title="Delete Comment"
                      message="Delete this comment?"
                      variant="danger"
                      buttonText="Delete"
                      buttonClass="inline-flex min-w-[76px] items-center justify-center rounded-md bg-error-500 px-2.5 py-1 text-center text-xs font-medium text-white shadow-theme-xs hover:bg-error-600"
                    />
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                  No comments found.
                </td>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="mt-5">
        {{ $comments->links() }}
      </div>
    </div>
  </div>
</x-staff.layout>
