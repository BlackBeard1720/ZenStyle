<x-staff.layout
  title="User detail"
  page-name="UserManagement"
>
  <div x-data="{ pageName: `User detail`}">
    <x-staff.partials.breadcrumb />
  </div>

  <div class="mb-5 flex flex-wrap items-center justify-end gap-2">
    <a
      href="{{ route('staff.users.index') }}"
      class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700"
    >
      Back
    </a>
    <a
      href="{{ route('staff.users.edit', $user) }}"
      class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600"
    >
      Edit
    </a>
  </div>

  <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-100 px-5 py-4 sm:px-6 sm:py-5 dark:border-gray-800">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Account information</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">User account details and access state.</p>
      </div>

      <dl class="space-y-4 p-5 sm:p-6">
        <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID</dt>
          <dd class="text-sm text-gray-800 dark:text-white/90">{{ $user->id }}</dd>
        </div>
        <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Username</dt>
          <dd class="text-sm text-gray-800 dark:text-white/90">{{ $user->username }}</dd>
        </div>
        <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
          <dd class="text-sm text-gray-800 dark:text-white/90">{{ $user->email }}</dd>
        </div>
        <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
          <dd class="text-sm text-gray-800 dark:text-white/90">{{ $user->phone ?? '-' }}</dd>
        </div>
        <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Role</dt>
          <dd class="text-sm text-gray-800 dark:text-white/90">{{ $user->role?->role_name ? ucfirst($user->role->role_name) : '-' }}</dd>
        </div>
        <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
          <dd>
            @php $isActive = $user->status === 'active'; @endphp
            <span class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium
              {{ $isActive
                  ? 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500'
                  : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500'
              }}">
              {{ $isActive ? 'Active' : 'Inactive' }}
            </span>
          </dd>
        </div>
        <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created at</dt>
          <dd class="text-sm text-gray-800 dark:text-white/90">{{ $user->created_at?->format('d/m/Y H:i') ?? '-' }}</dd>
        </div>
        <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Updated at</dt>
          <dd class="text-sm text-gray-800 dark:text-white/90">{{ $user->updated_at?->format('d/m/Y H:i') ?? '-' }}</dd>
        </div>
      </dl>
    </div>

    @if($user->staff)
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-100 px-5 py-4 sm:px-6 sm:py-5 dark:border-gray-800">
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Staff profile</h3>
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Operational details linked to this account.</p>
        </div>

        <dl class="space-y-4 p-5 sm:p-6">
          <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Full name</dt>
            <dd class="text-sm text-gray-800 dark:text-white/90">{{ $user->staff->full_name }}</dd>
          </div>
          <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
            <dd class="text-sm text-gray-800 dark:text-white/90">{{ $user->staff->phone ?? '-' }}</dd>
          </div>
          <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
            <dd class="text-sm text-gray-800 dark:text-white/90">{{ $user->staff->email ?? '-' }}</dd>
          </div>
          <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Specialization</dt>
            <dd class="text-sm text-gray-800 dark:text-white/90">{{ $user->staff->specialization ?? '-' }}</dd>
          </div>
          <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Hire date</dt>
            <dd class="text-sm text-gray-800 dark:text-white/90">{{ $user->staff->hire_date ?? '-' }}</dd>
          </div>
          <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
            <dd class="text-sm text-gray-800 dark:text-white/90">{{ ucfirst($user->staff->status ?? '-') }}</dd>
          </div>
        </dl>
      </div>
    @else
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-100 px-5 py-4 sm:px-6 sm:py-5 dark:border-gray-800">
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Staff profile</h3>
        </div>

        <div class="p-5 sm:p-6">
          <p class="text-sm text-gray-500 dark:text-gray-400">No staff profile linked to this account.</p>
        </div>
      </div>
    @endif

    @if($user->client)
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-100 px-5 py-4 sm:px-6 sm:py-5 dark:border-gray-800">
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Client profile</h3>
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Customer profile linked to this account.</p>
        </div>

        <dl class="space-y-4 p-5 sm:p-6">
          <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Client ID</dt>
            <dd class="text-sm text-gray-800 dark:text-white/90">{{ $user->client->id }}</dd>
          </div>
          <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Full name</dt>
            <dd class="text-sm text-gray-800 dark:text-white/90">{{ $user->client->full_name }}</dd>
          </div>
          <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
            <dd class="text-sm text-gray-800 dark:text-white/90">{{ $user->client->phone ?? '-' }}</dd>
          </div>
          <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
            <dd class="text-sm text-gray-800 dark:text-white/90">{{ $user->client->email ?? '-' }}</dd>
          </div>
          <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date of birth</dt>
            <dd class="text-sm text-gray-800 dark:text-white/90">{{ $user->client->dob ?? '-' }}</dd>
          </div>
          <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Loyalty points</dt>
            <dd class="text-sm text-gray-800 dark:text-white/90">{{ $user->client->loyalty_points ?? 0 }}</dd>
          </div>
        </dl>
      </div>
    @endif
  </div>
</x-staff.layout>
