<x-staff.layout
  title="User management"
  page-name="UserManagement"
>

  <!-- Breadcrumb Start -->
  <div x-data="{ pageName: `Users management`}">
    <x-staff.partials.breadcrumb/>
  </div>
  <!-- Breadcrumb End -->

  <div class="space-y-5 sm:space-y-6">
    <div
      class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
    >
      <div class="px-5 py-4 sm:px-6 sm:py-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Users list</h3>

          <div class="flex items-center gap-2">
            <!-- ADD USER BUTTON -->
            <a href="{{ route('staff.users.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-theme-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M12 4v16m8-8H4"/>
              </svg>
              Add User
            </a>

            <!-- FILTER BUTTON -->
            <div class="relative flex items-center gap-3" x-data="{ openFilter: false }">
              <button
                @click="openFilter = !openFilter"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
              >
                <svg
                  class="stroke-current"
                  width="20"
                  height="20"
                  viewBox="0 0 20 20"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M2.29004 5.90393H17.7067"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <path
                    d="M17.7075 14.0961H2.29085"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <path
                    d="M12.0826 3.33331C13.5024 3.33331 14.6534 4.48431 14.6534 5.90414C14.6534 7.32398 13.5024 8.47498 12.0826 8.47498C10.6627 8.47498 9.51172 7.32398 9.51172 5.90415C9.51172 4.48432 10.6627 3.33331 12.0826 3.33331Z"
                    stroke-width="1.5"
                  />
                  <path
                    d="M7.91745 11.525C6.49762 11.525 5.34662 12.676 5.34662 14.0959C5.34661 15.5157 6.49762 16.6667 7.91745 16.6667C9.33728 16.6667 10.4883 15.5157 10.4883 14.0959C10.4883 12.676 9.33728 11.525 7.91745 11.525Z"
                    stroke-width="1.5"
                  />
                </svg>
                Filter
              </button>

              <!-- FILTER POPUP -->
              <x-staff.partials.filter-popup/>
            </div>
          </div>
        </div>
      </div>

      <div class="p-5 sm:p-6">

        <!-- ====== Table Start -->
        <div
          class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
          <div class="w-full overflow-x-auto">
            <table class="min-w-full">
              <!-- table header start -->
              <thead>
              <tr class="border-b border-gray-100 dark:border-gray-800">
                <th class="px-4 pb-3 pt-4 sm:px-6 text-left">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">ID</p>
                </th>
                <th class="px-4 pb-3 pt-4 sm:px-6 text-left">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">User</p>
                </th>
                <th class="px-4 pb-3 pt-4 sm:px-6 text-left">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Email</p>
                </th>
                <th class="px-4 pb-3 pt-4 sm:px-6 text-left">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                </th>
                <th class="px-4 pb-3 pt-4 sm:px-6 text-right">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Action</p>
                </th>
              </tr>
              </thead>
              <!-- table header end -->

              <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
              @foreach($users as $user)
                <!-- table item -->
                <tr>
                  <td class="px-4 pb-3 pt-4 sm:px-6">
                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $user->id }}</p>
                  </td>

                  <td class="px-4 pb-3 pt-4 sm:px-6">
                    <div class="flex items-center gap-3">

                      <div class="h-10 w-10 overflow-hidden rounded-full bg-gray-100">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->username) }}" alt="User"/>
                      </div>

                      <div>
                        <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                          {{ $user->username }}
                        </span>
                        <span class="block text-gray-500 text-theme-xs dark:text-gray-400">
                          {{ $user->role->role_name }}
                        </span>
                      </div>

                    </div>
                  </td>

                  <td class="px-4 pb-3 pt-4 sm:px-6">
                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $user->email }}</p>
                  </td>

                  <td class="px-4 pb-3 pt-4 sm:px-6">
                    @php
                      $isActive = $user->status === 'active';
                    @endphp

                    <span class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium
                      {{ $isActive
                          ? 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500'
                          : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500'
                      }}">
                      {{ $isActive ? 'Active' : 'Inactive' }}
                    </span>
                  </td>
                  <td class="px-4 pb-3 pt-4 sm:px-6">
                    <div class="flex items-center justify-end gap-2">

                      <!-- View -->
                      <a href="{{ route('staff.users.show', $user->id) }}"
                         class="flex items-center justify-center text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400"
                         title="View">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                      </a>

                      <!-- Edit -->
                      <a href="{{ route('staff.users.edit', $user->id) }}"
                         class="flex items-center justify-center text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                      </a>

                      <!-- Delete -->
                      <form action="{{ route('staff.users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="flex items-center justify-center text-gray-500 hover:text-error-600 dark:text-gray-400 dark:hover:text-error-500">
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                          </svg>
                        </button>
                      </form>

                    </div>
                  </td>
                </tr>
              @endforeach

              </tbody>
            </table>
          </div>
        </div>
        <!-- ====== Table End -->

        <!-- Pagination -->
        <div class="mt-5">
          {{ $users->links() }}
        </div>
      </div>
    </div>
  </div>
</x-staff.layout>
