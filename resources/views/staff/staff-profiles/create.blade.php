<x-staff.layout title="Add Staff Profile" page-name="StaffProfileManagement">
  @php
    $inputClass = 'h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30';
  @endphp

  <div x-data="{ pageName: `Add Staff Profile` }"><x-staff.partials.breadcrumb /></div>

  <form method="POST" action="{{ route('staff.staff-profiles.store') }}" class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
    @csrf

    <!-- Avatar Upload Section -->
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-start">
      <div class="h-28 w-28 overflow-hidden rounded-full border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900 shrink-0">
        <img id="avatar-preview" src="{{ old('avatar') ?: 'https://ui-avatars.com/api/?name=User&background=465FFF&color=fff' }}" alt="Avatar" class="h-full w-full object-cover" />
      </div>
      <div class="space-y-3">
        <input type="hidden" name="avatar" id="avatar" value="{{ old('avatar') }}">
        <button type="button" id="upload-avatar" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">Upload avatar</button>
        <button type="button" id="remove-avatar" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">Remove avatar</button>
        <x-staff.form.error name="avatar" />
      </div>
    </div>

    <!-- Form Fields -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
      <!-- User Account Selection -->
      <div class="lg:col-span-2">
        <label class="mb-1.5 block text-sm font-medium">Link User Account *</label>
        <select name="user_id" class="{{ $inputClass }} bg-white dark:bg-gray-900">
          <option value="">Select a user account...</option>
          @foreach($availableUsers as $u)
            <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>
              {{ $u->username }} ({{ $u->email }}) - {{ ucfirst($u->role->role_name) }}
            </option>
          @endforeach
        </select>
        <x-staff.form.error name="user_id" />
        @if($availableUsers->isEmpty())
          <p class="mt-1 text-sm text-error-500">No available internal users found. All eligible users might already have a profile.</p>
        @endif
      </div>

      <div>
        <label class="mb-1.5 block text-sm font-medium">Full Name *</label>
        <input name="full_name" value="{{ old('full_name') }}" class="{{ $inputClass }}" required />
        <x-staff.form.error name="full_name" />
      </div>

      <div>
        <label class="mb-1.5 block text-sm font-medium">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="{{ $inputClass }}" />
        <x-staff.form.error name="email" />
      </div>

      <div>
        <label class="mb-1.5 block text-sm font-medium">Phone</label>
        <input name="phone" value="{{ old('phone') }}" class="{{ $inputClass }}" />
        <x-staff.form.error name="phone" />
      </div>

      <div>
        <label class="mb-1.5 block text-sm font-medium">Specialization</label>
        <input name="specialization" value="{{ old('specialization') }}" class="{{ $inputClass }}" placeholder="e.g. Senior Stylist, Manager" />
        <x-staff.form.error name="specialization" />
      </div>

      <div>
        <label class="mb-1.5 block text-sm font-medium">Salary</label>
        <input type="number" step="0.01" min="0" name="salary" value="{{ old('salary') }}" class="{{ $inputClass }}" placeholder="e.g. 5000.00" />
        <x-staff.form.error name="salary" />
      </div>

      <div>
        <label class="mb-1.5 block text-sm font-medium">Hire Date</label>
        <input type="date" name="hire_date" value="{{ old('hire_date') }}" class="{{ $inputClass }}" />
        <x-staff.form.error name="hire_date" />
      </div>

      <div>
        <label class="mb-1.5 block text-sm font-medium">Status *</label>
        <select name="status" class="{{ $inputClass }} bg-white dark:bg-gray-900" required>
          <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
          <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <x-staff.form.error name="status" />
      </div>
    </div>

    <div class="mt-6 flex gap-3">
      <button class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">Save Profile</button>
      <a href="{{ route('staff.staff-profiles.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">Cancel</a>
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
        const defaultAvatar = 'https://ui-avatars.com/api/?name=User&background=465FFF&color=fff';
        const cloudName = {{ \Illuminate\Support\Js::from(config('services.cloudinary.cloud_name')) }};
        const uploadPreset = {{ \Illuminate\Support\Js::from(config('services.cloudinary.upload_preset')) }};

        function setAvatar(url) { avatarPreview.src = url || defaultAvatar; }
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
