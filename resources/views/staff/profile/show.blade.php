<x-staff.layout title="User Profile" page-name="profile">
  @php
    $staff = $user->staff;
    $displayName = $staff?->full_name ?? $user->username ?? 'Staff User';
    $roleName = $user->role?->role_name ? ucfirst($user->role->role_name) : 'Staff';
    $accountEmail = $user->email;
    $staffEmail = $staff?->email;
    $profilePhone = $staff?->phone;
    $status = $staff?->status ?? $user->status;
    $avatarValue = old('avatar', $staff?->avatar ?? '');
    $fallbackAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($displayName) . '&background=465FFF&color=fff';
    $avatarUrl = $staff?->avatar ?: $fallbackAvatar;
    $inputClass = 'h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30';
  @endphp

  <div x-data="{ pageName: `User Profile`, isProfileInfoModal: {{ $errors->any() ? 'true' : 'false' }} }">
    <x-staff.partials.breadcrumb />

    <!-- Filters and Success Message -->
    @if(session('success'))
      <div class="mb-6 rounded-lg bg-success-50 p-4 border border-success-200 text-success-700 dark:bg-success-500/10 dark:border-success-500/20 dark:text-success-400">
        {{ session('success') }}
      </div>
    @endif

    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
      <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-7">User Profile</h3>

      <div class="mb-6 rounded-2xl border border-gray-200 p-5 dark:border-gray-800 lg:p-6">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
          <div class="flex w-full flex-col items-center gap-6 xl:flex-row">
            <div class="h-20 w-20 overflow-hidden rounded-full border border-gray-200 dark:border-gray-800 shrink-0">
              <img src="{{ $avatarUrl }}" alt="{{ $displayName }}" class="h-full w-full object-cover" />
            </div>

            <div>
              <h4 class="mb-2 text-center text-lg font-semibold text-gray-800 dark:text-white/90 xl:text-left">{{ $displayName }}</h4>
              <div class="flex flex-col items-center gap-1 text-center xl:flex-row xl:gap-3 xl:text-left">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $roleName }}</p>
                <div class="hidden h-3.5 w-px bg-gray-300 dark:bg-gray-700 xl:block"></div>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $accountEmail }}</p>
              </div>
            </div>
          </div>

          <button @click="isProfileInfoModal = true" class="flex w-full items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 lg:inline-flex lg:w-auto shrink-0">
            <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M15.0911 2.78206C14.2125 1.90338 12.7878 1.90338 11.9092 2.78206L4.57524 10.116C4.26682 10.4244 4.0547 10.8158 3.96468 11.2426L3.31231 14.3352C3.25997 14.5833 3.33653 14.841 3.51583 15.0203C3.69512 15.1996 3.95286 15.2761 4.20096 15.2238L7.29355 14.5714C7.72031 14.4814 8.11172 14.2693 8.42013 13.9609L15.7541 6.62695C16.6327 5.74827 16.6327 4.32365 15.7541 3.44497L15.0911 2.78206ZM12.9698 3.84272C13.2627 3.54982 13.7376 3.54982 14.0305 3.84272L14.6934 4.50563C14.9863 4.79852 14.9863 5.2734 14.6934 5.56629L14.044 6.21573L12.3204 4.49215L12.9698 3.84272ZM11.2597 5.55281L5.6359 11.1766C5.53309 11.2794 5.46238 11.4099 5.43238 11.5522L5.01758 13.5185L6.98394 13.1037C7.1262 13.0737 7.25666 13.003 7.35947 12.9002L12.9833 7.27639L11.2597 5.55281Z" fill=""/>
            </svg>
            Edit Profile
          </button>
        </div>
      </div>

      <div class="mb-6 rounded-2xl border border-gray-200 p-5 dark:border-gray-800 lg:p-6">
        <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">Personal Information</h4>
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7 2xl:gap-x-32">
          <div><p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Username</p><p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->username }}</p></div>
          <div><p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Full Name</p><p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $displayName }}</p></div>
          <div><p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Account Email</p><p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $accountEmail }}</p></div>
          @if($staffEmail)
          <div><p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Staff Contact Email</p><p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $staffEmail }}</p></div>
          @endif
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

    <!-- Edit Profile Modal -->
    <div
      x-show="isProfileInfoModal"
      class="fixed inset-0 z-99999 flex items-center justify-center bg-black/50 p-4 transition-opacity"
      style="display: none;"
    >
      <div
        @click.outside="isProfileInfoModal = false"
        class="relative w-full max-w-lg rounded-2xl bg-white p-6 shadow-theme-lg dark:bg-gray-900 sm:p-8"
      >
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Edit Profile</h3>
          <button @click="isProfileInfoModal = false" class="text-gray-500 hover:text-gray-800 dark:hover:text-white/90">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

        <form method="POST" action="{{ route('staff.profile.update') }}">
          @csrf
          @method('PUT')
          
          <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-start">
            <div class="h-24 w-24 overflow-hidden rounded-full border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900 shrink-0">
              <img id="avatar-preview" src="{{ $avatarValue ?: $fallbackAvatar }}" alt="Avatar" class="h-full w-full object-cover" />
            </div>
            <div class="space-y-3">
              <input type="hidden" name="avatar" id="avatar" value="{{ $avatarValue }}">
              <button type="button" id="upload-avatar" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">Upload avatar</button>
              <button type="button" id="remove-avatar" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">Remove</button>
              <x-staff.form.error name="avatar" />
            </div>
          </div>

          <div class="space-y-5">
            <div>
              <label class="mb-1.5 block text-sm font-medium text-gray-800 dark:text-white/90">Phone</label>
              <input name="phone" value="{{ old('phone', $profilePhone) }}" class="{{ $inputClass }}" />
              <x-staff.form.error name="phone" />
            </div>
          </div>

          <div class="mt-8 flex justify-end gap-3">
            <button type="button" @click="isProfileInfoModal = false" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">Cancel</button>
            <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @push('scripts')
    <script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.getElementById('avatar-preview');
        const uploadButton = document.getElementById('upload-avatar');
        const removeButton = document.getElementById('remove-avatar');
        const fallbackAvatar = {{ \Illuminate\Support\Js::from($fallbackAvatar) }};
        const cloudName = {{ \Illuminate\Support\Js::from(config('services.cloudinary.cloud_name')) }};
        const uploadPreset = {{ \Illuminate\Support\Js::from(config('services.cloudinary.upload_preset')) }};

        function setAvatar(url) { avatarPreview.src = url || fallbackAvatar; }
        removeButton?.addEventListener('click', function () { avatarInput.value = ''; setAvatar(''); });

        uploadButton?.addEventListener('click', function () {
          if (!window.cloudinary || !cloudName || !uploadPreset) { alert('Cloudinary cloud name or upload preset is missing.'); return; }
          const widget = cloudinary.createUploadWidget({
            cloudName, uploadPreset, sources: ['local', 'url', 'camera'], multiple: false,
            maxFileSize: 5242880, clientAllowedFormats: ['jpg', 'jpeg', 'png', 'webp'],
          }, function (error, result) {
            if (error || !result || result.event !== 'success') return;
            avatarInput.value = result.info.secure_url;
            setAvatar(result.info.secure_url);
          });
          widget.open();
        });
      });
    </script>
  @endpush
</x-staff.layout>
