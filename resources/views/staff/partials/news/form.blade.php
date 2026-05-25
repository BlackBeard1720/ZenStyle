@php
  $inputClass = 'h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30';
  $textareaClass = 'w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30';
  $selectedImage = old('image', $news->image ?? '');
  $previewImage = $selectedImage ?: ($news->image_url ?? asset('images/default-news.jpg'));
@endphp

<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
  <div>
    <label for="title" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
      Title <span class="text-error-500">*</span>
    </label>
    <input id="title" type="text" name="title" value="{{ old('title', $news->title ?? '') }}" class="{{ $inputClass }}" />
    <x-staff.form.error name="title" />
  </div>

  <div>
    <label for="status" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
      Status <span class="text-error-500">*</span>
    </label>
    <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
      <select
        id="status"
        name="status"
        class="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
        :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
        @change="isOptionSelected = true"
      >
        <option value="active" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected(old('status', $news->status ?? 'active') === 'active')>Active</option>
        <option value="inactive" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected(old('status', $news->status ?? 'active') === 'inactive')>Inactive</option>
      </select>
      <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
        <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </span>
    </div>
    <x-staff.form.error name="status" />
  </div>

  <div class="lg:col-span-2">
    <label for="external_url" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
      Article URL <span class="text-error-500">*</span>
    </label>
    <input
      id="external_url"
      type="url"
      name="external_url"
      value="{{ old('external_url', $news->external_url ?? '') }}"
      placeholder="https://example.com/news-article"
      class="{{ $inputClass }}"
    />
    <x-staff.form.error name="external_url" />
  </div>

  <div class="lg:col-span-2">
    <label for="summary" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Summary</label>
    <textarea id="summary" name="summary" rows="3" maxlength="500" class="{{ $textareaClass }}">{{ old('summary', $news->summary ?? '') }}</textarea>
    <x-staff.form.error name="summary" />
  </div>

  <div class="lg:col-span-2">
    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Image</label>
    <input type="hidden" name="image" id="image" value="{{ $selectedImage }}">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
      <div class="h-40 w-full overflow-hidden rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900 sm:w-64">
        <img id="image-preview" src="{{ $previewImage }}" alt="News image preview" class="h-full w-full object-cover" />
      </div>

      <div class="flex flex-wrap items-center gap-3">
        <button type="button" id="upload-news-image" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
          <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 16.5V3.75m0 0 4.5 4.5M12 3.75l-4.5 4.5"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 16.5v1.75A2.75 2.75 0 0 0 6.5 21h11a2.75 2.75 0 0 0 2.75-2.75V16.5"/>
          </svg>
          Upload image
        </button>
        <button type="button" id="remove-news-image" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
          <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18 18 6M6 6l12 12"/>
          </svg>
          Remove
        </button>
      </div>
    </div>
    <x-staff.form.error name="image" />
  </div>
</div>

@push('scripts')
  <script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const imageInput = document.getElementById('image');
      const imagePreview = document.getElementById('image-preview');
      const uploadButton = document.getElementById('upload-news-image');
      const removeButton = document.getElementById('remove-news-image');
      const defaultImage = {{ \Illuminate\Support\Js::from(asset('images/default-news.jpg')) }};
      const cloudName = {{ \Illuminate\Support\Js::from(config('services.cloudinary.cloud_name')) }};
      const uploadPreset = {{ \Illuminate\Support\Js::from(config('services.cloudinary.upload_preset')) }};

      function updatePreview(url) {
        if (imagePreview) {
          imagePreview.src = url || defaultImage;
        }
      }

      if (removeButton) {
        removeButton.addEventListener('click', function () {
          imageInput.value = '';
          updatePreview('');
        });
      }

      if (uploadButton) {
        uploadButton.addEventListener('click', function () {
          if (!window.cloudinary || !cloudName || !uploadPreset) {
            alert('Cloudinary cloud name or upload preset is missing.');
            return;
          }

          const widget = cloudinary.createUploadWidget({
            cloudName: cloudName,
            uploadPreset: uploadPreset,
            sources: ['local', 'url', 'camera'],
            multiple: false,
            maxFileSize: 5242880,
            clientAllowedFormats: ['jpg', 'jpeg', 'png', 'webp', 'gif'],
          }, function (error, result) {
            if (error || !result || result.event !== 'success') {
              return;
            }

            const imageUrl = result.info.secure_url;
            imageInput.value = imageUrl;
            updatePreview(imageUrl);
          });

          widget.open();
        });
      }
    });
  </script>
@endpush
