62 <x-staff.layout
  title="User Profile"
  page-name="profile"
>
  @php
    $profile = $user->staff ?? $user->client;
    $displayName = $profile?->full_name ?? $user->username ?? 'Staff User';
    $roleName = $user->role?->role_name ? ucfirst($user->role->role_name) : 'Staff';
    $profileEmail = $profile?->email ?? $user->email;
    $profilePhone = $profile?->phone ?? $user->phone;
    $status = $profile?->status ?? $user->status;
  @endphp

  <div x-data="{ pageName: `User Profile` }">
    <x-staff.partials.breadcrumb />
  </div>

  <div x-data="{ isProfileInfoModal: false, isProfileAddressModal: false }">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
      <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-7">
        User Profile
      </h3>

      <div class="mb-6 rounded-2xl border border-gray-200 p-5 dark:border-gray-800 lg:p-6">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
          <div class="flex w-full flex-col items-center gap-6 xl:flex-row">
            <div class="h-20 w-20 overflow-hidden rounded-full border border-gray-200 dark:border-gray-800">
              <img src="https://ui-avatars.com/api/?name={{ urlencode($displayName) }}&background=465FFF&color=fff" alt="{{ $displayName }}" />
            </div>

            <div>
              <h4 class="mb-2 text-center text-lg font-semibold text-gray-800 dark:text-white/90 xl:text-left">
                {{ $displayName }}
              </h4>
              <div class="flex flex-col items-center gap-1 text-center xl:flex-row xl:gap-3 xl:text-left">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $roleName }}</p>
                <div class="hidden h-3.5 w-px bg-gray-300 dark:bg-gray-700 xl:block"></div>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $profileEmail ?? '-' }}</p>
              </div>
            </div>
          </div>

          @can('manage-staff-users')
            <a
              href="{{ route('staff.users.edit', $user) }}"
              class="flex w-full items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 lg:inline-flex lg:w-auto"
            >
              <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.0911 2.78206C14.2125 1.90338 12.7878 1.90338 11.9092 2.78206L4.57524 10.116C4.26682 10.4244 4.0547 10.8158 3.96468 11.2426L3.31231 14.3352C3.25997 14.5833 3.33653 14.841 3.51583 15.0203C3.69512 15.1996 3.95286 15.2761 4.20096 15.2238L7.29355 14.5714C7.72031 14.4814 8.11172 14.2693 8.42013 13.9609L15.7541 6.62695C16.6327 5.74827 16.6327 4.32365 15.7541 3.44497L15.0911 2.78206ZM12.9698 3.84272C13.2627 3.54982 13.7376 3.54982 14.0305 3.84272L14.6934 4.50563C14.9863 4.79852 14.9863 5.2734 14.6934 5.56629L14.044 6.21573L12.3204 4.49215L12.9698 3.84272ZM11.2597 5.55281L5.6359 11.1766C5.53309 11.2794 5.46238 11.4099 5.43238 11.5522L5.01758 13.5185L6.98394 13.1037C7.1262 13.0737 7.25666 13.003 7.35947 12.9002L12.9833 7.27639L11.2597 5.55281Z" fill="" />
              </svg>
              Edit
            </a>
          @endcan
        </div>
      </div>

      <div class="mb-6 rounded-2xl border border-gray-200 p-5 dark:border-gray-800 lg:p-6">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
          <div>
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">
              Personal Information
            </h4>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7 2xl:gap-x-32">
              <div>
                <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Username</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->username }}</p>
              </div>
              <div>
                <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Full Name</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $displayName }}</p>
              </div>
              <div>
                <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Email Address</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $profileEmail ?? '-' }}</p>
              </div>
              <div>
                <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Phone</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $profilePhone ?? '-' }}</p>
              </div>
              <div>
                <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Role</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $roleName }}</p>
              </div>
              <div>
                <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Status</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ ucfirst($status ?? '-') }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="rounded-2xl border border-gray-200 p-5 dark:border-gray-800 lg:p-6">
        <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">
          Account Details
        </h4>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7 2xl:gap-x-32">
          <div>
            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Account ID</p>
            <p class="text-sm font-medium text-gray-800 dark:text-white/90">#{{ $user->id }}</p>
          </div>
          <div>
            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Created At</p>
            <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->created_at?->format('d/m/Y H:i') ?? '-' }}</p>
          </div>
          <div>
            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Specialization</p>
            <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->staff?->specialization ?? '-' }}</p>
          </div>
          <div>
            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Hire Date</p>
            <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->staff?->hire_date ?? '-' }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-staff.layout>
