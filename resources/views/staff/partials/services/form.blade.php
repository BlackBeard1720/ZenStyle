@php
  $inputClass = 'h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30';
  $textareaClass = 'w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30';
@endphp

<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
  <div>
    <label for="service_name" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
      Service name <span class="text-error-500">*</span>
    </label>
    <input id="service_name" type="text" name="service_name" value="{{ old('service_name', $service->service_name ?? '') }}" class="{{ $inputClass }}" />
    <x-staff.form.error name="service_name" />
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
        <option value="active" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected(old('status', $service->status ?? 'active') === 'active')>Active</option>
        <option value="inactive" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected(old('status', $service->status ?? 'active') === 'inactive')>Inactive</option>
      </select>
      <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
        <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </span>
    </div>
    <x-staff.form.error name="status" />
  </div>

  <div>
    <label for="price" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
      Price <span class="text-error-500">*</span>
    </label>
    <input id="price" type="number" name="price" min="0" step="0.01" value="{{ old('price', $service->price ?? 0) }}" class="{{ $inputClass }}" />
    <x-staff.form.error name="price" />
  </div>

  <div>
    <label for="duration_minutes" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
      Duration minutes <span class="text-error-500">*</span>
    </label>
    <input id="duration_minutes" type="number" name="duration_minutes" min="1" step="1" value="{{ old('duration_minutes', $service->duration_minutes ?? 60) }}" class="{{ $inputClass }}" />
    <x-staff.form.error name="duration_minutes" />
  </div>

  <div class="lg:col-span-2">
    <label for="description" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Description</label>
    <textarea id="description" name="description" rows="5" class="{{ $textareaClass }}">{{ old('description', $service->description ?? '') }}</textarea>
    <x-staff.form.error name="description" />
  </div>
</div>
