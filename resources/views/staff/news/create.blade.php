<x-staff.layout title="Create News" page-name="NewsCreate">

  <div x-data="{ pageName: `Create News`, imagePreview: null }">
    <x-staff.partials.breadcrumb/>

    <div class="space-y-5 sm:space-y-6">
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-5 py-4 sm:px-6 sm:py-5">
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Create News</h3>
        </div>

        <div class="p-5 sm:p-6">
          <form action="{{ route('staff.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
              <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Title <span class="text-error-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full rounded-lg border px-3 py-2" />
                <x-staff.form.error name="title" />
              </div>

              <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Image</label>
                <div class="flex flex-col gap-3">
                  <button type="button" @click="$refs.newsImage.click()" class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">
                    Select image
                  </button>
                  <input
                    type="file"
                    name="image"
                    accept="image/*"
                    x-ref="newsImage"
                    class="hidden"
                    @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = e => imagePreview = e.target.result; reader.readAsDataURL(file); } else { imagePreview = null; }"
                  />
                </div>
                <template x-if="imagePreview">
                  <div class="mt-3 h-28 w-40 overflow-hidden rounded-lg border border-gray-200 bg-gray-50">
                    <img :src="imagePreview" alt="Image preview" class="h-full w-full object-cover" />
                  </div>
                </template>
                <x-staff.form.error name="image" />
              </div>

              <div class="lg:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Excerpt</label>
                <textarea name="excerpt" rows="3" class="w-full rounded-lg border px-3 py-2">{{ old('excerpt') }}</textarea>
                <x-staff.form.error name="excerpt" />
              </div>

              <div class="lg:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Body <span class="text-error-500">*</span></label>
                <textarea id="body-editor" name="body" rows="8" class="w-full rounded-lg border px-3 py-2">{{ old('body') }}</textarea>
                <x-staff.form.error name="body" />
              </div>

              <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Published At</label>
                <input type="datetime-local" name="published_at" value="{{ old('published_at') }}" class="w-full rounded-lg border px-3 py-2" />
                <x-staff.form.error name="published_at" />
              </div>

              <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="w-full rounded-lg border px-3 py-2">
                  <option value="draft" @selected(old('status')=='draft')>Draft</option>
                  <option value="published" @selected(old('status')=='published')>Published</option>
                </select>
                <x-staff.form.error name="status" />
              </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
              <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-theme-sm font-medium text-white">Create</button>
              <a href="{{ route('staff.news.index') }}" class="text-gray-500">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
  <script src="https://cdn.tiny.cloud/1/{{ config('services.tinymce.api_key') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      if (window.tinymce) {
        tinymce.init({
          selector: '#body-editor',
          height: 320,
          menubar: false,
          plugins: 'lists link image media table paste help wordcount',
          toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
          branding: false,
        });
      }
    });
  </script>
  @endpush
</x-staff.layout>
