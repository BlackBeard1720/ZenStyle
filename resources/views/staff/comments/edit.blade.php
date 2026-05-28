<x-staff.layout title="Edit Comment" page-name="CommentManagement">
  <div x-data="{ pageName: `Comments` }"><x-staff.partials.breadcrumb/></div>
  <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Edit Comment #{{ $comment->id }}</h3>
    <p class="mt-1 text-sm text-gray-500">Service: {{ $comment->service?->name ?? 'N/A' }}</p>
    <form method="POST" action="{{ route('staff.comments.update', $comment) }}" class="mt-6 space-y-4">
      @csrf @method('PUT')
      <div>
        <label class="mb-1 block text-sm">Name</label>
        <input type="text" name="name" value="{{ old('name', $comment->name) }}" class="w-full rounded-lg border px-3 py-2">
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
      </div>
      <div>
        <label class="mb-1 block text-sm">Comment</label>
        <textarea name="comment" rows="5" class="w-full rounded-lg border px-3 py-2">{{ old('comment', $comment->comment) }}</textarea>
        @error('comment') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
      </div>
      <div>
        <label class="mb-1 block text-sm">Status</label>
        <select name="status" class="w-full rounded-lg border px-3 py-2">
          @foreach(['pending','approved','hidden'] as $status)
            <option value="{{ $status }}" @selected(old('status', $comment->status) === $status)>{{ ucfirst($status) }}</option>
          @endforeach
        </select>
        @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
      </div>
      <div class="flex gap-3"><button class="rounded-lg bg-brand-500 px-4 py-2 text-white">Save</button><a href="{{ route('staff.comments.index') }}" class="rounded-lg border px-4 py-2">Cancel</a></div>
    </form>
  </div>
</x-staff.layout>
