<x-staff.layout title="Staff Profile Details" page-name="StaffProfileManagement">
  <div x-data="{ pageName: `Staff Profile Details` }"><x-staff.partials.breadcrumb /></div>

  <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-start">
      <div class="h-28 w-28 overflow-hidden rounded-full border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900 shrink-0">
        <img src="{{ $staff->avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($staff->full_name) . '&background=465FFF&color=fff' }}" alt="Avatar" class="h-full w-full object-cover" />
      </div>
      <div class="space-y-1">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $staff->full_name }}</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $staff->specialization ?: 'No specialization' }}</p>
        <span class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium {{ $staff->status === 'active' ? 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500' : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500' }}">
          {{ $staff->status === 'active' ? 'Active' : 'Inactive' }}
        </span>
      </div>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <div>
        <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">Linked Account Username</span>
        <p class="mt-1 text-sm text-gray-800 dark:text-white/90">{{ $staff->user->username ?? '-' }}</p>
      </div>

      <div>
        <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">System Role</span>
        <p class="mt-1 text-sm text-gray-800 dark:text-white/90">{{ ucfirst($staff->user?->role?->role_name ?? '-') }}</p>
      </div>

      <div>
        <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">Email</span>
        <p class="mt-1 text-sm text-gray-800 dark:text-white/90">{{ $staff->email ?: '-' }}</p>
      </div>

      <div>
        <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">Phone</span>
        <p class="mt-1 text-sm text-gray-800 dark:text-white/90">{{ $staff->phone ?: '-' }}</p>
      </div>

      <div>
        <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">Salary</span>
        <p class="mt-1 text-sm text-gray-800 dark:text-white/90">{{ $staff->salary ? '$' . number_format($staff->salary, 2) : '-' }}</p>
      </div>

      <div>
        <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">Hire Date</span>
        <p class="mt-1 text-sm text-gray-800 dark:text-white/90">{{ $staff->hire_date ? \Carbon\Carbon::parse($staff->hire_date)->format('M d, Y') : '-' }}</p>
      </div>
    </div>

    <div class="mt-8 flex gap-3">
      <a href="{{ route('staff.staff-profiles.edit', $staff->id) }}" class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">Edit Profile</a>
      <a href="{{ route('staff.staff-profiles.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">Back to List</a>
    </div>
  </div>
</x-staff.layout>
