<x-staff.layout title="Edit Profile" page-name="profile">
  @php
    $staff = $user->staff;
    $displayName = $staff?->full_name ?? $user->username ?? 'Staff User';
    $avatarValue = old('avatar', $staff?->avatar ?? '');
    $fallbackAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($displayName) . '&background=465FFF&color=fff';
    $avatarPreview = $avatarValue ?: $fallbackAvatar;
    $inputClass = 'h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30';
  @endphp

  <div x-data="{ pageName: `Edit Profile` }"><x-staff.partials.breadcrumb /></div>

  <form method="POST" action="{{ route('staff.profile.update') }}" class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
    @csrf
    @method('PUT')

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-start">
      <div class="h-28 w-28 overflow-hidden rounded-full border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
        <img id="avatar-preview" src="{{ $avatarPreview }}" alt="Avatar" class="h-full w-full object-cover" />
      </div>
      <div class="space-y-3">
        <input type="hidden" name="avatar" id="avatar" value="{{ $avatarValue }}">
        <button type="button" id="upload-avatar" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">Upload avatar</button>
        <button type="button" id="remove-avatar" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">Remove avatar</button>
        <x-staff.form.error name="avatar" />
      </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
      <div><label class="mb-1.5 block text-sm font-medium">Full Name *</label><input name="full_name" value="{{ old('full_name', $staff?->full_name ?? $user->username) }}" class="{{ $inputClass }}" /><x-staff.form.error name="full_name" /></div>
      <div><label class="mb-1.5 block text-sm font-medium">Email</label><input type="email" name="email" value="{{ old('email', $staff?->email) }}" class="{{ $inputClass }}" /><x-staff.form.error name="email" /></div>
      <div><label class="mb-1.5 block text-sm font-medium">Phone</label><input name="phone" value="{{ old('phone', $staff?->phone) }}" class="{{ $inputClass }}" /><x-staff.form.error name="phone" /></div>
      <div><label class="mb-1.5 block text-sm font-medium">Specialization</label><input name="specialization" value="{{ old('specialization', $staff?->specialization) }}" class="{{ $inputClass }}" /><x-staff.form.error name="specialization" /></div>

      <div><label class="mb-1.5 block text-sm font-medium">Username</label><input value="{{ $user->username }}" class="{{ $inputClass }}" readonly /></div>
      <div><label class="mb-1.5 block text-sm font-medium">Role</label><input value="{{ ucfirst($user->role?->role_name ?? 'Staff') }}" class="{{ $inputClass }}" readonly /></div>
      <div><label class="mb-1.5 block text-sm font-medium">Status</label><input value="{{ ucfirst($staff?->status ?? $user->status ?? '-') }}" class="{{ $inputClass }}" readonly /></div>
      <div><label class="mb-1.5 block text-sm font-medium">Hire Date</label><input value="{{ $staff?->hire_date ?? '-' }}" class="{{ $inputClass }}" readonly /></div>
    </div>

    <div class="mt-6 flex gap-3">
      <button class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white">Save</button>
      <a href="{{ route('staff.profile.show') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700">Cancel</a>
    </div>
  </form>

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
