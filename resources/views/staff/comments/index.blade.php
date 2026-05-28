<x-staff.layout title="Comments" page-name="CommentManagement">
  <div x-data="{ pageName: `Comments` }">
    <x-staff.partials.breadcrumb/>
  </div>

  <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 sm:px-6 sm:py-5">
      <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Comments</h3>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage service comments from customers.</p>
    </div>

    <div class="p-5 sm:p-6">
      <div class="w-full overflow-x-auto rounded-2xl border border-gray-200 dark:border-gray-800">
        <table class="min-w-full table-fixed">
          <thead>
          <tr class="border-b border-gray-100 dark:border-gray-800">
            <th class="w-16 px-4 py-3 text-left">ID</th><th class="px-4 py-3 text-left">Service name</th><th class="w-40 px-4 py-3 text-left">Name</th><th class="px-4 py-3 text-left">Comment preview</th><th class="w-28 px-4 py-3 text-left">Status</th><th class="w-40 px-4 py-3 text-left">Created at</th><th class="w-28 px-4 py-3 text-right">Actions</th>
          </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
          @forelse($comments as $item)
            <tr>
              <td class="px-4 py-4">#{{ $item->id }}</td>
              <td class="px-4 py-4">{{ $item->service?->name ?? 'N/A' }}</td>
              <td class="px-4 py-4">{{ $item->name }}</td>
              <td class="px-4 py-4">{{ \Illuminate\Support\Str::limit($item->comment, 100) }}</td>
              <td class="px-4 py-4">{{ ucfirst($item->status) }}</td>
              <td class="px-4 py-4">{{ optional($item->created_at)->format('Y-m-d H:i') }}</td>
              <td class="px-4 py-4">
                <div class="flex justify-end gap-2">
                  <a href="{{ route('staff.comments.edit', $item) }}" class="text-blue-600">Edit</a>
                  <form action="{{ route('staff.comments.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this comment?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600" type="submit">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500">No comments found.</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-5">{{ $comments->links() }}</div>
    </div>
  </div>
</x-staff.layout>
