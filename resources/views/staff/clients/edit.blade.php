<x-staff.layout
  title="eCommerce Dashboard | TailAdmin - Tailwind CSS Admin Dashboard Template"
  page-name="ecommerce"
>
  <div x-data="{ pageName: `Edit client`}">
    <x-staff.partials.breadcrumb />
  </div>

  <div class="grid grid-cols-1 gap-6">
    <div class="col-span-1 xl:col-span-2">
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-100 px-5 py-4 sm:px-6 sm:py-5 dark:border-gray-800">
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Edit client details
          </h3>
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Update this customer profile (ID: {{ $client->id }}).
          </p>
        </div>

        <form
          method="POST"
          action="{{ route('staff.clients.update', $client) }}"
          class="space-y-6 p-5 sm:p-6"
          novalidate
        >
          @csrf
          @method('PUT')

          <!-- Full name -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              Full name <span class="text-error-500">*</span>
            </label>
            <input
              type="text"
              name="full_name"
              value="{{ old('full_name', $client->full_name) }}"
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
              value="{{ old('phone', $client->phone) }}"
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
              value="{{ old('email', $client->email) }}"
              placeholder="Leave empty if not available"
              class="dark:bg-dark-900 shadow-theme-xs focus:ring-brand-500/10 h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30
                @error('email') border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800 @else border-gray-300 focus:border-brand-300 dark:focus:border-brand-800 dark:border-gray-700 @enderror"
            />
            <x-staff.form.error name="email" />
          </div>

          <!-- DOB -->
          <!-- DOB -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              Date of birth
            </label>
            <div class="relative">
              <input
                type="date"
                name="dob"
                value="{{ old('dob', optional($client->dob)->format('Y-m-d')) }}"
                max="{{ now()->format('Y-m-d') }}"
                placeholder="Select date"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30
      @error('dob') border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800 @else focus:border-brand-300 dark:focus:border-brand-800 @enderror"
                onclick="this.showPicker()"
              />

                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M6.66659 1.5415C7.0808 1.5415 7.41658 1.87729 7.41658 2.2915V2.99984H12.5833V2.2915C12.5833 1.87729 12.919 1.5415 13.3333 1.5415C13.7475 1.5415 14.0833 1.87729 14.0833 2.2915V2.99984L15.4166 2.99984C16.5212 2.99984 17.4166 3.89527 17.4166 4.99984V7.49984V15.8332C17.4166 16.9377 16.5212 17.8332 15.4166 17.8332H4.58325C3.47868 17.8332 2.58325 16.9377 2.58325 15.8332V7.49984V4.99984C2.58325 3.89527 3.47868 2.99984 4.58325 2.99984L5.91659 2.99984V2.2915C5.91659 1.87729 6.25237 1.5415 6.66659 1.5415ZM6.66659 4.49984H4.58325C4.30711 4.49984 4.08325 4.7237 4.08325 4.99984V6.74984H15.9166V4.99984C15.9166 4.7237 15.6927 4.49984 15.4166 4.49984H13.3333H6.66659ZM15.9166 8.24984H4.08325V15.8332C4.08325 16.1093 4.30711 16.3332 4.58325 16.3332H15.4166C15.6927 16.3332 15.9166 16.1093 15.9166 15.8332V8.24984Z"
                    fill="currentColor"
                  />
                </svg>
              </span>
            </div>
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
            >{{ old('preferences', $client->preferences) }}</textarea>
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
                <option value="active" @selected(old('status', $client->status) === 'active')>Active</option>
                <option value="inactive" @selected(old('status', $client->status) === 'inactive')>Inactive</option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </div>
            <x-staff.form.error name="status" />
          </div>

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
              Update client
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-staff.layout>
