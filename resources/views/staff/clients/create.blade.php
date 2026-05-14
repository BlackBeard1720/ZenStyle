<x-staff.layout
  title="eCommerce Dashboard | TailAdmin - Tailwind CSS Admin Dashboard Template"
  page-name="ecommerce"
>
  <!-- Breadcrumb Start -->
  <div x-data="{ pageName: `Clients management`}">
    <x-staff.partials.breadcrumb />
  </div>
  <!-- Breadcrumb End -->

  <div class="grid grid-cols-1 gap-6">
    <div class="col-span-1 xl:col-span-2">
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-100 px-5 py-4 sm:px-6 sm:py-5 dark:border-gray-800">
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Client details
          </h3>
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Add a customer profile before booking an appointment.
          </p>
        </div>

        <form method="POST" action="{{ route('staff.clients.store') }}" class="space-y-6 p-5 sm:p-6" novalidate>
          @csrf

          <!-- Full name -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              Full name <span class="text-error-500">*</span>
            </label>
            <input
              type="text"
              name="full_name"
              value="{{ old('full_name') }}"
              placeholder="Enter full name"
              class="dark:bg-dark-900 shadow-theme-xs focus:ring-brand-500/10 h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30
                @error('full_name') border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800 @else border-gray-300 focus:border-brand-300 dark:focus:border-brand-800 dark:border-gray-700 @enderror"
            />
            <x-staff.form.error name="full_name" />
          </div>

          <!-- Phone -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              Phone <span class="text-error-500">*</span>
            </label>
            <input
              type="text"
              name="phone"
              value="{{ old('phone') }}"
              placeholder="e.g. 0901234567"
              class="dark:bg-dark-900 shadow-theme-xs focus:ring-brand-500/10 h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30
                @error('phone') border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800 @else border-gray-300 focus:border-brand-300 dark:focus:border-brand-800 dark:border-gray-700 @enderror"
            />
            <x-staff.form.error name="phone" />
          </div>

          <!-- Email -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              Email
            </label>
            <input
              type="email"
              name="email"
              value="{{ old('email') }}"
              placeholder="Leave empty if not available"
              class="dark:bg-dark-900 shadow-theme-xs focus:ring-brand-500/10 h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30
                @error('email') border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800 @else border-gray-300 focus:border-brand-300 dark:focus:border-brand-800 dark:border-gray-700 @enderror"
            />
            <x-staff.form.error name="email" />
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              Date of birth
            </label>
            <input
              type="date"
              name="dob"
              value="{{ old('dob') }}"
              max="{{ now()->format('Y-m-d') }}"
              class="dark:bg-dark-900 shadow-theme-xs focus:ring-brand-500/10 h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90
      @error('dob') border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800 @else border-gray-300 focus:border-brand-300 dark:focus:border-brand-800 dark:border-gray-700 @enderror"
            />
            <x-staff.form.error name="dob" />
          </div>

          <!-- Preferences -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              Preferences
            </label>
            <textarea
              name="preferences"
              rows="4"
              placeholder="Notes, allergies, preferred stylist, etc."
              class="dark:bg-dark-900 shadow-theme-xs focus:ring-brand-500/10 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30
                @error('preferences') border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800 @else border-gray-300 focus:border-brand-300 dark:focus:border-brand-800 dark:border-gray-700 @enderror"
            >{{ old('preferences') }}</textarea>
            <x-staff.form.error name="preferences" />
          </div>

          <!-- Status -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              Status <span class="text-error-500">*</span>
            </label>
            <div class="relative z-20 bg-transparent" x-data="{ isOptionSelected: true }">
              <select
                name="status"
                class="dark:bg-dark-900 shadow-theme-xs focus:ring-brand-500/10 h-11 w-full appearance-none rounded-lg border bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90
                  @error('status') border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800 @else border-gray-300 focus:border-brand-300 dark:focus:border-brand-800 dark:border-gray-700 @enderror"
                @change="isOptionSelected = true"
              >
                <option value="active" @selected(old('status', 'active') === 'active')>Active</option>
                <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </div>
            <x-staff.form.error name="status" />
          </div>

          <!-- Actions -->
          <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-5 dark:border-gray-800">
            <a
              href="{{ route('staff.clients.index') }}"
              class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-center text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700"
            >
              Cancel
            </a>
            <button
              type="submit"
              class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-center text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600"
            >
              Save client
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-staff.layout>
