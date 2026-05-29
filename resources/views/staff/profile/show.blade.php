<x-staff.layout title="User Profile" page-name="profile">
  @php
    $staff = $user->staff;
    $displayName = $staff?->full_name ?? $user->username ?? 'Staff User';
    $roleName = $user->role?->role_name ? ucfirst($user->role->role_name) : 'Staff';
    $profileEmail = $staff?->email ?? $user->email;
    $profilePhone = $staff?->phone;
    $status = $staff?->status ?? $user->status;
    $avatarUrl = $staff?->avatar ?: ('https://ui-avatars.com/api/?name=' . urlencode($displayName) . '&background=465FFF&color=fff');
  @endphp

  <div x-data="{ pageName: `User Profile` }">
    <x-staff.partials.breadcrumb />
  </div>

  <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
    <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-7">User Profile</h3>

    <div class="mb-6 rounded-2xl border border-gray-200 p-5 dark:border-gray-800 lg:p-6">
      <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
        <div class="flex w-full flex-col items-center gap-6 xl:flex-row">
          <div class="h-20 w-20 overflow-hidden rounded-full border border-gray-200 dark:border-gray-800">
            <img src="{{ $avatarUrl }}" alt="{{ $displayName }}" class="h-full w-full object-cover" />
          </div>

          <div>
            <h4 class="mb-2 text-center text-lg font-semibold text-gray-800 dark:text-white/90 xl:text-left">{{ $displayName }}</h4>
            <div class="flex flex-col items-center gap-1 text-center xl:flex-row xl:gap-3 xl:text-left">
              <p class="text-sm text-gray-500 dark:text-gray-400">{{ $roleName }}</p>
              <div class="hidden h-3.5 w-px bg-gray-300 dark:bg-gray-700 xl:block"></div>
              <p class="text-sm text-gray-500 dark:text-gray-400">{{ $profileEmail ?? '-' }}</p>
            </div>
          </div>
        </div>

        <a href="{{ route('staff.profile.edit') }}" class="flex w-full items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 lg:inline-flex lg:w-auto">
          Edit Profile
        </a>
      </div>
    </div>

    <div class="mb-6 rounded-2xl border border-gray-200 p-5 dark:border-gray-800 lg:p-6">
      <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">Personal Information</h4>
      <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7 2xl:gap-x-32">
        <div><p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Username</p><p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->username }}</p></div>
        <div><p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Full Name</p><p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $displayName }}</p></div>
        <div><p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Email Address</p><p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $profileEmail ?? '-' }}</p></div>
        <div><p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Phone</p><p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $profilePhone ?? '-' }}</p></div>
        <div><p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Role</p><p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $roleName }}</p></div>
        <div><p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Status</p><p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ ucfirst($status ?? '-') }}</p></div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 p-5 dark:border-gray-800 lg:p-6">
      <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">Account Details</h4>
      <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7 2xl:gap-x-32">
        <div><p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Account ID</p><p class="text-sm font-medium text-gray-800 dark:text-white/90">#{{ $user->id }}</p></div>
        <div><p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Created At</p><p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->created_at?->format('d/m/Y H:i') ?? '-' }}</p></div>
        <div><p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Hire Date</p><p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $staff?->hire_date ?? '-' }}</p></div>
      </div>
    </div>
  </div>
</x-staff.layout>
