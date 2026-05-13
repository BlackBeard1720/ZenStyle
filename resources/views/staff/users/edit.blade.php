<x-staff.layout
    title="eCommerce Dashboard | TailAdmin - Tailwind CSS Admin Dashboard Template"
    page-name="ecommerce"
>
  <!-- ===== BREADCRUMB: Hiển thị tiêu đề trang "Edit User" ===== -->
  <div x-data="{ pageName: `Edit User`}">
    <x-staff.partials.breadcrumb />
  </div>

  <!-- ===== PHẦN BIỂU MẪU CHỈNH SỬA NGƯỜI DÙNG ===== -->
  <div class="grid grid-cols-1 gap-6">
    <div class="col-span-1 xl:col-span-2">
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Header của form -->
        <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-100 dark:border-gray-800">
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Edit User Details
          </h3>
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Update the information for this staff member.
          </p>
        </div>

        <!-- Form chỉnh sửa: Gửi PUT request đến endpoint staff.users.update với ID người dùng
             Validation được xử lý server-side, client-side dùng jQuery Validate plugin -->
        <form method="POST" action="{{ route('staff.users.update', $user->id) }}" class="p-5 sm:p-6 space-y-6"
              novalidate
              id="editUserForm">
          @csrf
          @method('PUT')

          <!-- ===== TRƯỜNG TÊN NGƯỜI DÙNG (USERNAME) ===== -->
          <!-- Hiển thị username hiện tại; tự động điền giá trị cũ nếu validation lỗi -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              Username <span class="text-error-500">*</span>
            </label>
            <!-- Trường bắt buộc, styling Tailwind kèm error class khi validation thất bại -->
            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                   placeholder="Enter username" required
                   class="dark:bg-dark-900 shadow-theme-xs focus:ring-brand-500/10 h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30
                            @error('username') border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800 @else border-gray-300 focus:border-brand-300 dark:focus:border-brand-800 dark:border-gray-700 @enderror"
            />
            @error('username')
            <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
            @enderror
          </div>

          <!-- ===== TRƯỜNG EMAIL ===== -->
          <!-- Hiển thị email hiện tại; tự động điền giá trị cũ nếu validation lỗi
               Server validate định dạng email và tính duy nhất -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              Email <span class="text-error-500">*</span>
            </label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="info@example.com"
                   required
                   class="dark:bg-dark-900 shadow-theme-xs focus:ring-brand-500/10 h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30
                            @error('email') border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800 @else border-gray-300 focus:border-brand-300 dark:focus:border-brand-800 dark:border-gray-700 @enderror"
            />
            @error('email')
            <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
            @enderror
          </div>

          <!-- ===== TRƯỜNG MẬT KHẨU (CÓ TOGGLE HIỂN THỊ/ẨN) ===== -->
          <!-- Trường tùy chọn - người dùng có thể bỏ trống để giữ nguyên mật khẩu hiện tại
               Alpine.js toggle giữa input type password/text khi click icon mắt
               Minimum 6 ký tự nếu thay đổi mật khẩu -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              Password
            </label>
            <div x-data="{ showPassword: false }" class="relative">
              <input :type="showPassword ? 'text' : 'password'" name="password"
                     placeholder="Leave blank to keep current password" minlength="6"
                     class="dark:bg-dark-900 shadow-theme-xs focus:ring-brand-500/10 h-11 w-full appearance-none rounded-lg border bg-transparent bg-none px-4 py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30
                                @error('password') border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800 @else border-gray-300 focus:border-brand-300 dark:focus:border-brand-800 dark:border-gray-700 @enderror"
              />
              <!-- Icon toggle show/hide password -->
              <span @click="showPassword = !showPassword"
                    class="absolute top-1/2 right-4 z-30 -translate-y-1/2 cursor-pointer">
                                <!-- Icon mắt đóng - hiển thị khi mật khẩu ẩn -->
                                <svg x-show="!showPassword" class="fill-gray-500 dark:fill-gray-400" width="20"
                                     height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M10.0002 13.8619C7.23361 13.8619 4.86803 12.1372 3.92328 9.70241C4.86804 7.26761 7.23361 5.54297 10.0002 5.54297C12.7667 5.54297 15.1323 7.26762 16.0771 9.70243C15.1323 12.1372 12.7667 13.8619 10.0002 13.8619ZM10.0002 4.04297C6.48191 4.04297 3.49489 6.30917 2.4155 9.4593C2.3615 9.61687 2.3615 9.78794 2.41549 9.94552C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C13.5184 15.3619 16.5055 13.0957 17.5849 9.94555C17.6389 9.78797 17.6389 9.6169 17.5849 9.45932C16.5055 6.30919 13.5184 4.04297 10.0002 4.04297ZM9.99151 7.84413C8.96527 7.84413 8.13333 8.67606 8.13333 9.70231C8.13333 10.7286 8.96527 11.5605 9.99151 11.5605H10.0064C11.0326 11.5605 11.8646 10.7286 11.8646 9.70231C11.8646 8.67606 11.0326 7.84413 10.0064 7.84413H9.99151Z"/>
                                </svg>
                <!-- Icon mắt mở - hiển thị khi mật khẩu được hiển thị -->
                                <svg x-cloak x-show="showPassword" class="fill-gray-500 dark:fill-gray-400" width="20"
                                     height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M4.63803 3.57709C4.34513 3.2842 3.87026 3.2842 3.57737 3.57709C3.28447 3.86999 3.28447 4.34486 3.57737 4.63775L4.85323 5.91362C3.74609 6.84199 2.89363 8.06395 2.4155 9.45936C2.3615 9.61694 2.3615 9.78801 2.41549 9.94558C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C11.255 15.3619 12.4422 15.0737 13.4994 14.5598L15.3625 16.4229C15.6554 16.7158 16.1302 16.7158 16.4231 16.4229C16.716 16.13 16.716 15.6551 16.4231 15.3622L4.63803 3.57709ZM12.3608 13.4212L10.4475 11.5079C10.3061 11.5423 10.1584 11.5606 10.0064 11.5606H9.99151C8.96527 11.5606 8.13333 10.7286 8.13333 9.70237C8.13333 9.5461 8.15262 9.39434 8.18895 9.24933L5.91885 6.97923C5.03505 7.69015 4.34057 8.62704 3.92328 9.70247C4.86803 12.1373 7.23361 13.8619 10.0002 13.8619C10.8326 13.8619 11.6287 13.7058 12.3608 13.4212ZM16.0771 9.70249C15.7843 10.4569 15.3552 11.1432 14.8199 11.7311L15.8813 12.7925C16.6329 11.9813 17.2187 11.0143 17.5849 9.94561C17.6389 9.78803 17.6389 9.61696 17.5849 9.45938C16.5055 6.30925 13.5184 4.04303 10.0002 4.04303C9.13525 4.04303 8.30244 4.17999 7.52218 4.43338L8.75139 5.66259C9.1556 5.58413 9.57311 5.54303 10.0002 5.54303C12.7667 5.54303 15.1323 7.26768 16.0771 9.70249Z"/>
                                </svg>
                            </span>
            </div>
            @error('password')
            <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
            @enderror
          </div>

          <!-- ===== TRƯỜNG VAI TRÒ (ROLE) ===== -->
          <!-- Danh sách các vai trò: Admin, Receptionist, Stylist
               Giá trị được lưu từ cơ sở dữ liệu, hiển thị lại nếu validation lỗi -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              Role <span class="text-error-500">*</span>
            </label>
            <!-- Alpine.js kiểm soát trạng thái visual của dropdown -->
            <div x-data="{ isOptionSelected: true }" class="relative z-20 bg-transparent">
              <!-- Trường bắt buộc, trigger validation khi thay đổi -->
              <select name="role_id" required
                      class="dark:bg-dark-900 shadow-theme-xs focus:ring-brand-500/10 h-11 w-full appearance-none rounded-lg border bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30
                                @error('role_id') border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800 @else border-gray-300 focus:border-brand-300 dark:focus:border-brand-800 dark:border-gray-700 @enderror"
                      :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                      @change="isOptionSelected = true">
                <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" disabled>Select Role</option>
                <!-- Các tùy chọn vai trò được lưu từ bảng roles trong DB -->
                <option value="1" {{ old('role_id', $user->role_id) == 1 ? 'selected' : '' }}>Admin</option>
                <option value="2" {{ old('role_id', $user->role_id) == 2 ? 'selected' : '' }}>Receptionist</option>
                <option value="3" {{ old('role_id', $user->role_id) == 3 ? 'selected' : '' }}>Stylist</option>
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
            @error('role_id')
            <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
            @enderror
          </div>

          <!-- ===== CÁC NÚT HÀNH ĐỘNG (CANCEL / UPDATE) ===== -->
          <!-- Cancel: Quay lại danh sách người dùng
               Update User: Gửi form để cập nhật thông tin người dùng -->
          <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-5 dark:border-gray-800">
            <a href="{{ route('staff.users.index') }}"
               class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-center text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
              Cancel
            </a>
            <button type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-center text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
              Update User
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</x-staff.layout>

@push('scripts')
  <!-- ===== JAVASCRIPT VALIDATION: JQUERY VALIDATE PLUGIN ===== -->
  <!-- Xác thực client-side trước khi gửi form
       Password không bắt buộc (có thể bỏ trống), các trường khác bắt buộc -->
  <script>
    $(document).ready(function () {
      // Khởi tạo plugin jQuery Validate cho form editUserForm
      $('#editUserForm').validate({
        // 1. Quy tắc validation: Password KHÔNG bắt buộc khi chỉnh sửa
        rules: {
          // Username: bắt buộc nhập
          username: {
            required: true
          },
          // Email: bắt buộc nhập, phải đúng định dạng email
          email: {
            required: true,
            email: true
          },
          // Password: tùy chọn, nhưng nếu nhập thì phải ≥6 ký tự
          password: {
            minlength: 6
          },
          // Role: bắt buộc chọn
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
            minlength: "If you want to change the password, it must be at least 6 characters long."
          },
          role_id: {
            required: "Please select a role."
          }
        },

        // 3. HTML element cho thông báo lỗi (thẻ <p>)
        errorElement: 'p',

        // 4. Xác định vị trí chính xác của thông báo lỗi
        // Nếu input nằm trong div.relative thì hiển thị lỗi sau div cha, ngược lại hiển thị sau input
        errorPlacement: function (error, element) {
          error.addClass('text-theme-xs text-error-500 mt-1.5');

          if (element.parent().hasClass('relative')) {
            error.insertAfter(element.parent());
          } else {
            error.insertAfter(element);
          }
        },

        // 5. Làm nổi input khi validation lỗi (thêm Tailwind error classes)
        highlight: function (element) {
          $(element)
            .removeClass('border-gray-300 focus:border-brand-300 dark:border-gray-700 dark:focus:border-brand-800')
            .addClass('border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800');
        },

        // 6. Bỏ nổi input (Phục hồi Tailwind classes mặc định)
        unhighlight: function (element) {
          $(element)
            .removeClass('border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800')
            .addClass('border-gray-300 focus:border-brand-300 dark:border-gray-700 dark:focus:border-brand-800');
        }
      });

      // Trigger validation khi thay đổi giá trị select role_id
      $('select[name="role_id"]').on('change', function () {
        $(this).valid();
      });
    });
  </script>
@endpush
