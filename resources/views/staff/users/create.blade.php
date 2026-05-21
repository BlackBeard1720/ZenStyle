<x-staff.layout
    title="Create Staff Account"
    page-name="StaffAccount"
>
  <!-- Breadcrumb Start -->
  <div x-data="{ pageName: `Create Staff Account`}">
    <x-staff.partials.breadcrumb />
  </div>
  <!-- Breadcrumb End -->

  <!-- ====== Form Elements Section Start -->
  <div class="grid grid-cols-1 gap-6">
    <div class="col-span-1 xl:col-span-2">
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-100 dark:border-gray-800">
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Staff Account Details
          </h3>
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Fill in the information to add a new staff member to the system.
          </p>
        </div>

        <form method="POST" action="{{ route('staff.users.store') }}" class="p-5 sm:p-6 space-y-6"
              novalidate
              id="createUserForm">
          @csrf

          <!-- Username Field -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              Username <span class="text-error-500">*</span>
            </label>
            <input type="text" name="username" value="{{ old('username') }}" placeholder="Enter username"
                   class="dark:bg-dark-900 shadow-theme-xs focus:ring-brand-500/10 h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30
                            @error('username') border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800 @else border-gray-300 focus:border-brand-300 dark:focus:border-brand-800 dark:border-gray-700 @enderror"
            />
            <x-staff.form.error name="username" />
          </div>

          <!-- Email Field -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              Email <span class="text-error-500">*</span>
            </label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="info@example.com"
                   class="dark:bg-dark-900 shadow-theme-xs focus:ring-brand-500/10 h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30
                            @error('email') border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800 @else border-gray-300 focus:border-brand-300 dark:focus:border-brand-800 dark:border-gray-700 @enderror"
            />
            <x-staff.form.error name="email" />
          </div>

          <!-- Password Field (with Alpine.js Toggle) -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              Password <span class="text-error-500">*</span>
            </label>
            <div x-data="{ showPassword: false }" class="relative">
              <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="Min. 6 characters"
                     minlength="6"
                     class="dark:bg-dark-900 shadow-theme-xs focus:ring-brand-500/10 h-11 w-full appearance-none rounded-lg border bg-transparent bg-none px-4 py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30
                                @error('password') border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800 @else border-gray-300 focus:border-brand-300 dark:focus:border-brand-800 dark:border-gray-700 @enderror"
              />
              <span @click="showPassword = !showPassword"
                    class="absolute top-1/2 right-4 z-30 -translate-y-1/2 cursor-pointer">
                                <!-- Eye Closed Icon -->
                                <svg x-show="!showPassword" class="fill-gray-500 dark:fill-gray-400" width="20"
                                     height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M10.0002 13.8619C7.23361 13.8619 4.86803 12.1372 3.92328 9.70241C4.86804 7.26761 7.23361 5.54297 10.0002 5.54297C12.7667 5.54297 15.1323 7.26762 16.0771 9.70243C15.1323 12.1372 12.7667 13.8619 10.0002 13.8619ZM10.0002 4.04297C6.48191 4.04297 3.49489 6.30917 2.4155 9.4593C2.3615 9.61687 2.3615 9.78794 2.41549 9.94552C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C13.5184 15.3619 16.5055 13.0957 17.5849 9.94555C17.6389 9.78797 17.6389 9.6169 17.5849 9.45932C16.5055 6.30919 13.5184 4.04297 10.0002 4.04297ZM9.99151 7.84413C8.96527 7.84413 8.13333 8.67606 8.13333 9.70231C8.13333 10.7286 8.96527 11.5605 9.99151 11.5605H10.0064C11.0326 11.5605 11.8646 10.7286 11.8646 9.70231C11.8646 8.67606 11.0326 7.84413 10.0064 7.84413H9.99151Z"/>
                                </svg>
                <!-- Eye Opened Icon -->
                                <svg x-cloak x-show="showPassword" class="fill-gray-500 dark:fill-gray-400" width="20"
                                     height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M4.63803 3.57709C4.34513 3.2842 3.87026 3.2842 3.57737 3.57709C3.28447 3.86999 3.28447 4.34486 3.57737 4.63775L4.85323 5.91362C3.74609 6.84199 2.89363 8.06395 2.4155 9.45936C2.3615 9.61694 2.3615 9.78801 2.41549 9.94558C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C11.255 15.3619 12.4422 15.0737 13.4994 14.5598L15.3625 16.4229C15.6554 16.7158 16.1302 16.7158 16.4231 16.4229C16.716 16.13 16.716 15.6551 16.4231 15.3622L4.63803 3.57709ZM12.3608 13.4212L10.4475 11.5079C10.3061 11.5423 10.1584 11.5606 10.0064 11.5606H9.99151C8.96527 11.5606 8.13333 10.7286 8.13333 9.70237C8.13333 9.5461 8.15262 9.39434 8.18895 9.24933L5.91885 6.97923C5.03505 7.69015 4.34057 8.62704 3.92328 9.70247C4.86803 12.1373 7.23361 13.8619 10.0002 13.8619C10.8326 13.8619 11.6287 13.7058 12.3608 13.4212ZM16.0771 9.70249C15.7843 10.4569 15.3552 11.1432 14.8199 11.7311L15.8813 12.7925C16.6329 11.9813 17.2187 11.0143 17.5849 9.94561C17.6389 9.78803 17.6389 9.61696 17.5849 9.45938C16.5055 6.30925 13.5184 4.04303 10.0002 4.04303C9.13525 4.04303 8.30244 4.17999 7.52218 4.43338L8.75139 5.66259C9.1556 5.58413 9.57311 5.54303 10.0002 5.54303C12.7667 5.54303 15.1323 7.26768 16.0771 9.70249Z"/>
                                </svg>
                            </span>
            </div>
            <x-staff.form.error name="password" />
          </div>

          <!-- Role ID Field -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              Role <span class="text-error-500">*</span>
            </label>
            <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
              <select name="role_id"
                      class="dark:bg-dark-900 shadow-theme-xs focus:ring-brand-500/10 h-11 w-full appearance-none rounded-lg border bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30
                                @error('role_id') border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800 @else border-gray-300 focus:border-brand-300 dark:focus:border-brand-800 dark:border-gray-700 @enderror"
                      :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                      @change="isOptionSelected = true">
                <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" disabled selected>Select
                  Role
                </option>
                <option value="1"
                        class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected(old('role_id') == '1')>Admin
                </option>
                <option value="2"
                        class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected(old('role_id') == '2')>
                  Receptionist
                </option>
                <option value="3"
                        class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" @selected(old('role_id') == '3')>
                  Stylist
                </option>
              </select>
              <span
                class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
            </div>
            <x-staff.form.error name="role_id" />
          </div>

          <!-- Form Actions -->
          <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-5 dark:border-gray-800">
            <a href="{{ route('staff.users.index') }}"
               class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-center text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
              Cancel
            </a>
            <button type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-center text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
              Save Staff Account
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
  <!-- ====== Form Elements Section End -->
</x-staff.layout>

@push('scripts')
  <script>
    $(document).ready(function () {
      $('#createUserForm').validate({
        // 1. Rules matching your Laravel StoreUserRequest
        rules: {
          username: {
            required: true
          },
          email: {
            required: true,
            email: true
          },
          password: {
            required: true,
            minlength: 6
          },
          role_id: {
            required: true
          }
        },

        // 2. Custom English Messages
        messages: {
          username: {
            required: "Please enter a username."
          },
          email: {
            required: "Please enter an email address.",
            email: "Please enter a valid email format."
          },
          password: {
            required: "Please provide a password.",
            minlength: "Your password must be at least 6 characters long."
          },
          role_id: {
            required: "Please select a role."
          }
        },

        // 3. Customize the HTML element for the error message
        errorElement: 'p',

        // 4. Handle exact placement of the error message
        errorPlacement: function (error, element) {
          // Add Tailadmin specific error text classes to the <p> tag
          error.addClass('text-theme-xs text-error-500 mt-1.5');

          // If the input is inside a relative div (like password toggle or select arrow),
          // we must place the error outside that wrapper so it doesn't break UI layout.
          if (element.parent().hasClass('relative')) {
            error.insertAfter(element.parent());
          } else {
            error.insertAfter(element);
          }
        },

        // 5. Highlight input with Tailwind error classes
        highlight: function (element) {
          $(element)
            .removeClass('border-gray-300 focus:border-brand-300 dark:border-gray-700 dark:focus:border-brand-800')
            .addClass('border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800');
        },

        // 6. Unhighlight input (Revert to default Tailwind classes)
        unhighlight: function (element) {
          $(element)
            .removeClass('border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800')
            .addClass('border-gray-300 focus:border-brand-300 dark:border-gray-700 dark:focus:border-brand-800');
        }
      });

      // Trigger validation on Select change (since Alpine/Select sometimes bypasses default blur events)
      $('select[name="role_id"]').on('change', function () {
        $(this).valid();
      });
    });
  </script>
@endpush
