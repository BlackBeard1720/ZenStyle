<aside
  :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
  class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
>
  <!-- SIDEBAR HEADER -->
  <div
    :class="sidebarToggle ? 'justify-center' : 'justify-between'"
    class="flex items-center gap-2 pt-8 sidebar-header pb-7"
  >
    <a href="{{ route('staff.dashboard') }}" class="flex items-center gap-2">
      <!-- Full text logo: visible when sidebar is open -->
      <span class="logo text-xl font-extrabold tracking-wider text-gray-900 dark:text-white" :class="sidebarToggle ? 'hidden' : 'block'">
        Zen<span class="text-brand-500">Style</span>
      </span>

      <!-- Mini text icon logo: visible when sidebar is collapsed (toggled) -->
      <span class="logo-icon text-xl font-extrabold text-brand-500" :class="sidebarToggle ? 'lg:block' : 'hidden'">
        ZS
      </span>
    </a>
  </div>
  <!-- SIDEBAR HEADER -->

  <div
    class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar"
  >
    <!-- Sidebar Menu -->
    <nav x-data="{selected: $persist('Dashboard')}">
      <!-- Menu Group -->
      <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
          <span
            class="menu-group-title"
            :class="sidebarToggle ? 'lg:hidden' : ''"
          >
            MENU
          </span>

          <svg
            :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
            class="mx-auto fill-current menu-group-icon"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
              fill=""
            />
          </svg>
        </h3>

        <ul class="flex flex-col gap-4 mb-6">
          <!-- Menu Item Dashboard -->
          <li>
            <a
              href="{{ route('staff.dashboard') }}"
              class="menu-item group"
              :class="page === 'dashboard' ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="page === 'dashboard' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V8.99998C3.25 10.2426 4.25736 11.25 5.5 11.25H9C10.2426 11.25 11.25 10.2426 11.25 8.99998V5.5C11.25 4.25736 10.2426 3.25 9 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H9C9.41421 4.75 9.75 5.08579 9.75 5.5V8.99998C9.75 9.41419 9.41421 9.74998 9 9.74998H5.5C5.08579 9.74998 4.75 9.41419 4.75 8.99998V5.5ZM5.5 12.75C4.25736 12.75 3.25 13.7574 3.25 15V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H9C10.2426 20.75 11.25 19.7427 11.25 18.5V15C11.25 13.7574 10.2426 12.75 9 12.75H5.5ZM4.75 15C4.75 14.5858 5.08579 14.25 5.5 14.25H9C9.41421 14.25 9.75 14.5858 9.75 15V18.5C9.75 18.9142 9.41421 19.25 9 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V15ZM12.75 5.5C12.75 4.25736 13.7574 3.25 15 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V8.99998C20.75 10.2426 19.7426 11.25 18.5 11.25H15C13.7574 11.25 12.75 10.2426 12.75 8.99998V5.5ZM15 4.75C14.5858 4.75 14.25 5.08579 14.25 5.5V8.99998C14.25 9.41419 14.5858 9.74998 15 9.74998H18.5C18.9142 9.74998 19.25 9.41419 19.25 8.99998V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H15ZM15 12.75C13.7574 12.75 12.75 13.7574 12.75 15V18.5C12.75 19.7426 13.7574 20.75 15 20.75H18.5C19.7426 20.75 20.75 19.7427 20.75 18.5V15C20.75 13.7574 19.7426 12.75 18.5 12.75H15ZM14.25 15C14.25 14.5858 14.5858 14.25 15 14.25H18.5C18.9142 14.25 19.25 14.5858 19.25 15V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15C14.5858 19.25 14.25 18.9142 14.25 18.5V15Z"
                  fill=""
                />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Dashboard
              </span>
            </a>
          </li>
          <!-- Menu Item Dashboard -->

          <!-- Menu Item Appointments -->
          @can('view-appointments')
          <li>
            <a
              href="{{ route('staff.appointments.index') }}"
              @click="selected = (selected === 'Calendar' ? '':'Calendar')"
              class="menu-item group"
              :class=" (selected === 'Calendar') && (page === 'calendar') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'Calendar') && (page === 'calendar') ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M8 2C8.41421 2 8.75 2.33579 8.75 2.75V3.75H15.25V2.75C15.25 2.33579 15.5858 2 16 2C16.4142 2 16.75 2.33579 16.75 2.75V3.75H18.5C19.7426 3.75 20.75 4.75736 20.75 6V9V19C20.75 20.2426 19.7426 21.25 18.5 21.25H5.5C4.25736 21.25 3.25 20.2426 3.25 19V9V6C3.25 4.75736 4.25736 3.75 5.5 3.75H7.25V2.75C7.25 2.33579 7.58579 2 8 2ZM8 5.25H5.5C5.08579 5.25 4.75 5.58579 4.75 6V8.25H19.25V6C19.25 5.58579 18.9142 5.25 18.5 5.25H16H8ZM19.25 9.75H4.75V19C4.75 19.4142 5.08579 19.75 5.5 19.75H18.5C18.9142 19.75 19.25 19.4142 19.25 19V9.75Z"
                  fill=""
                />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Appointments
              </span>
            </a>
          </li>
          @endcan
          <!-- Menu Item Appointments -->


          @can('view-payrolls')
          <li>
            <a
              href="{{ route('staff.payments.index') }}"
              class="menu-item group"
              :class="page === 'PaymentManagement' ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="page === 'PaymentManagement' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.25 6C3.25 4.48122 4.48122 3.25 6 3.25H18C19.5188 3.25 20.75 4.48122 20.75 6V18C20.75 19.5188 19.5188 20.75 18 20.75H6C4.48122 20.75 3.25 19.5188 3.25 18V6ZM6 4.75C5.30964 4.75 4.75 5.30964 4.75 6V18C4.75 18.6904 5.30964 19.25 6 19.25H18C18.6904 19.25 19.25 18.6904 19.25 18V6C19.25 5.30964 18.6904 4.75 18 4.75H6ZM7.25 9C7.25 8.58579 7.58579 8.25 8 8.25H16C16.4142 8.25 16.75 8.58579 16.75 9C16.75 9.41421 16.4142 9.75 16 9.75H8C7.58579 9.75 7.25 9.41421 7.25 9ZM7.25 12.5C7.25 12.0858 7.58579 11.75 8 11.75H13C13.4142 11.75 13.75 12.0858 13.75 12.5C13.75 12.9142 13.4142 13.25 13 13.25H8C7.58579 13.25 7.25 12.9142 7.25 12.5ZM7.25 16C7.25 15.5858 7.58579 15.25 8 15.25H11C11.4142 15.25 11.75 15.5858 11.75 16C11.75 16.4142 11.4142 16.75 11 16.75H8C7.58579 16.75 7.25 16.4142 7.25 16Z" fill=""/>
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Payments</span>
            </a>
          </li>
          @endcan




          <!-- Menu Item Service Management -->
          @canany(['view-categories', 'view-services'])
          <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'ServiceManagement' ? '':'ServiceManagement')"
              class="menu-item group"
              :class="(selected === 'ServiceManagement') || (page === 'CategoryManagement' || page === 'ServiceManagement' || page === 'CommentManagement') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'ServiceManagement') || (page === 'CategoryManagement' || page === 'ServiceManagement' || page === 'CommentManagement') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <!-- Sparkles Parent Icon representing Style/Beauty Transformation -->
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M12 2C12 5.5 14.5 8 18 8C14.5 8 12 10.5 12 14C12 10.5 9.5 8 6 8C9.5 8 12 5.5 12 2Z"
                  fill=""
                />
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M18.5 13C18.5 14.5 19.5 15.5 21 15.5C19.5 15.5 18.5 16.5 18.5 18C18.5 16.5 17.5 15.5 16 15.5C17.5 15.5 18.5 14.5 18.5 13Z"
                  fill=""
                />
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M7.5 15C7.5 15.8 8.2 16.5 9 16.5C8.2 16.5 7.5 17.2 7.5 18C7.5 17.2 6.8 16.5 6 16.5C6.8 16.5 7.5 15.8 7.5 15Z"
                  fill=""
                />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Service Management
              </span>

              <svg
                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                :class="[(selected === 'ServiceManagement') || (page === 'CategoryManagement' || page === 'ServiceManagement' || page === 'CommentManagement') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
                  stroke=""
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </a>

            <div
              class="overflow-hidden transform translate"
              :class="(selected === 'ServiceManagement') || (page === 'CategoryManagement' || page === 'ServiceManagement' || page === 'CommentManagement') ? 'block' :'hidden'"
            >
              <ul
                :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9"
              >
                @can('view-categories')
                <li>
                  <a
                    href="{{ route('staff.categories.index') }}"
                    class="menu-dropdown-item group flex items-center gap-2"
                    :class="page === 'CategoryManagement' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    <svg class="fill-current" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H18.5C18.9142 4.75 19.25 5.08579 19.25 5.5V8.5C19.25 8.91421 18.9142 9.25 18.5 9.25H5.5C5.08579 9.25 4.75 8.91421 4.75 8.5V5.5ZM3.25 5.5C3.25 4.25736 4.25736 3.25 5.5 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V8.5C20.75 9.74264 19.7426 10.75 18.5 10.75H5.5C4.25736 10.75 3.25 9.74264 3.25 8.5V5.5ZM4.75 15.5C4.75 15.0858 5.08579 14.75 5.5 14.75H18.5C18.9142 14.75 19.25 15.0858 19.25 15.5V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V15.5ZM3.25 15.5C3.25 14.2574 4.25736 13.25 5.5 13.25H18.5C19.7426 13.25 20.75 14.2574 20.75 15.5V18.5C20.75 19.7426 19.7426 20.75 18.5 20.75H5.5C4.25736 20.75 3.25 19.7426 3.25 18.5V15.5Z" fill=""/>
                    </svg>
                    Categories
                  </a>
                </li>
                @endcan
                @can('view-services')
                <li>
                  <a
                    href="{{ route('staff.services.index') }}"
                    class="menu-dropdown-item group flex items-center gap-2"
                    :class="page === 'ServiceManagement' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    <svg class="fill-current" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <!-- Scissors Child Icon representing Hair/Salon Services -->
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M6 4C4.34315 4 3 5.34315 3 7C3 8.65685 4.34315 10 6 10C7.14231 10 8.1362 9.36214 8.64166 8.42398L11.5303 11.3127C10.7481 11.8385 10.2319 12.7533 10.2319 13.7844C10.2319 15.5709 11.6798 17.0188 13.4662 17.0188C14.4973 17.0188 15.4121 16.5027 15.9379 15.7204L18.8266 18.6092C17.8885 19.1146 17.2506 20.1085 17.2506 21.2508C17.2506 22.9077 18.5937 24.2508 20.2506 24.2508C21.9075 24.2508 23.2506 22.9077 23.2506 21.2508C23.2506 19.5939 21.9075 18.2508 20.2506 18.2508C19.1083 18.2508 18.1144 18.8887 17.609 19.8269L14.7203 16.9381C15.5024 16.4123 16.0186 15.4975 16.0186 14.4664C16.0186 12.6799 14.5707 11.232 12.7842 11.232C11.7531 11.232 10.8383 11.7482 10.3125 12.5305L7.42377 9.64175C7.92923 9.13629 8.25065 8.4236 8.25065 7.63385C8.25065 5.97699 6.9075 4.63385 5.25065 4.63385H6ZM4.5 7C4.5 6.17157 5.17157 5.5 6 5.5C6.82843 5.5 7.5 6.17157 7.5 7C7.5 7.82843 6.82843 8.5 6 8.5C5.17157 8.5 4.5 7.82843 4.5 7ZM18.7506 21.2508C18.7506 20.4224 19.4222 19.7508 20.2506 19.7508C21.079 19.7508 21.7506 20.4224 21.7506 21.2508C21.7506 22.0792 21.079 22.7508 20.2506 22.7508C19.4222 22.7508 18.7506 22.0792 18.7506 21.2508ZM11.7319 13.7844C11.7319 12.8276 12.5094 12.0501 13.4662 12.0501C14.4231 12.0501 15.2006 12.8276 15.2006 13.7844C15.2006 14.7412 14.4231 15.5188 13.4662 15.5188C12.5094 15.5188 11.7319 14.7412 11.7319 13.7844Z"
                        fill=""
                      />
                    </svg>
                    Services
                  </a>
                </li>
                @endcan

                @can('manage-services')
                <li>
                  <a
                    href="{{ route('staff.comments.index') }}"
                    class="menu-dropdown-item group flex items-center gap-2"
                    :class="page === 'CommentManagement' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    <svg class="fill-current" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 5.75C4 4.7835 4.7835 4 5.75 4H18.25C19.2165 4 20 4.7835 20 5.75V14.25C20 15.2165 19.2165 16 18.25 16H8.914L4.64 19.562C4.151 19.969 3.4 19.621 3.4 18.987V16.75C3.4 16.336 3.736 16 4.15 16H4V5.75Z" fill=""/></svg>
                    Comments
                  </a>
                </li>
                @endcan
              </ul>
            </div>
          </li>
          @endcanany
          <!-- Menu Item Service Management -->

          <!-- Menu Item Client Management Group -->
          <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'ClientManagementGroup' ? '':'ClientManagementGroup')"
              class="menu-item group"
              :class="(selected === 'ClientManagementGroup') || (page === 'ClientManagement' || page === 'ClientAccount') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'ClientManagementGroup') || (page === 'ClientManagement' || page === 'ClientAccount') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M9 11.75C6.79086 11.75 5 9.95914 5 7.75C5 5.54086 6.79086 3.75 9 3.75C11.2091 3.75 13 5.54086 13 7.75C13 9.95914 11.2091 11.75 9 11.75ZM9 5.25C7.61929 5.25 6.5 6.36929 6.5 7.75C6.5 9.13071 7.61929 10.25 9 10.25C10.3807 10.25 11.5 9.13071 11.5 7.75C11.5 6.36929 10.3807 5.25 9 5.25ZM15 19.25C15 16.6266 12.8734 14.5 10.25 14.5H7.75C5.12665 14.5 3 16.6266 3 19.25C3 19.6642 2.66421 20 2.25 20C1.83579 20 1.5 19.6642 1.5 19.25C1.5 15.7982 4.29822 13 7.75 13H10.25C13.7018 13 16.5 15.7982 16.5 19.25C16.5 19.6642 16.1642 20 15.75 20C15.3358 20 15 19.6642 15 19.25ZM16.25 11.75C14.5931 11.75 13.25 10.4069 13.25 8.75C13.25 7.09315 14.5931 5.75 16.25 5.75C17.9069 5.75 19.25 7.09315 19.25 8.75C19.25 10.4069 17.9069 11.75 16.25 11.75ZM16.25 7.25C15.4216 7.25 14.75 7.92157 14.75 8.75C14.75 9.57843 15.4216 10.25 16.25 10.25C17.0784 10.25 17.75 9.57843 17.75 8.75C17.75 7.92157 17.0784 7.25 16.25 7.25ZM22.5 18.25C22.5 15.4886 20.2614 13.25 17.5 13.25H16.75C16.3358 13.25 16 13.5858 16 14C16 14.4142 16.3358 14.75 16.75 14.75H17.5C19.433 14.75 21 16.317 21 18.25C21 18.6642 21.3358 19 21.75 19C22.1642 19 22.5 18.6642 22.5 18.25Z"
                  fill=""
                />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Client Management
              </span>

              <svg
                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                :class="[(selected === 'ClientManagementGroup') || (page === 'ClientManagement' || page === 'ClientAccount') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
                  stroke=""
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </a>

            <div
              class="overflow-hidden transform translate"
              :class="(selected === 'ClientManagementGroup') || (page === 'ClientManagement' || page === 'ClientAccount') ? 'block' :'hidden'"
            >
              <ul
                :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9"
              >
                <li>
                  <a
                    href="{{ route('staff.clients.index') }}"
                    class="menu-dropdown-item group flex items-center gap-2"
                    :class="page === 'ClientManagement' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    <svg
                      class="fill-current"
                      width="18"
                      height="18"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M9 11.75C6.79086 11.75 5 9.95914 5 7.75C5 5.54086 6.79086 3.75 9 3.75C11.2091 3.75 13 5.54086 13 7.75C13 9.95914 11.2091 11.75 9 11.75ZM9 5.25C7.61929 5.25 6.5 7.75 6.5 7.75C6.5 7.75 7.61929 10.25 9 10.25C10.3807 10.25 11.5 9.13071 11.5 7.75C11.5 6.36929 10.3807 5.25 9 5.25ZM15 19.25C15 16.6266 12.8734 14.5 10.25 14.5H7.75C5.12665 14.5 3 16.6266 3 19.25C3 19.6642 2.66421 20 2.25 20C1.83579 20 1.5 19.6642 1.5 19.25C1.5 15.7982 4.29822 13 7.75 13H10.25C13.7018 13 16.5 15.7982 16.5 19.25C16.5 19.6642 16.1642 20 15.75 20C15.3358 20 15 19.6642 15 19.25ZM16.25 11.75C14.5931 11.75 13.25 10.4069 13.25 8.75C13.25 7.09315 14.5931 5.75 16.25 5.75C17.9069 5.75 19.25 7.09315 19.25 8.75C19.25 10.4069 17.9069 11.75 16.25 11.75ZM16.25 7.25C15.4216 7.25 14.75 7.92157 14.75 8.75C14.75 9.57843 15.4216 10.25 16.25 10.25C17.0784 10.25 17.75 9.57843 17.75 8.75C17.75 7.92157 17.0784 7.25 16.25 7.25ZM22.5 18.25C22.5 15.4886 20.2614 13.25 17.5 13.25H16.75C16.3358 13.25 16 13.5858 16 14C16 14.4142 16.3358 14.75 16.75 14.75H17.5C19.433 14.75 21 16.317 21 18.25C21 18.6642 21.3358 19 21.75 19C22.1642 19 22.5 18.6642 22.5 18.25Z"
                        fill=""
                      />
                    </svg>
                    Clients
                  </a>
                </li>
                @can('manage-staff-users')
                <li>
                  <a
                    href="{{ route('staff.client-accounts.index') }}"
                    class="menu-dropdown-item group flex items-center gap-2"
                    :class="page === 'ClientAccount' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    <svg
                      class="fill-current"
                      width="18"
                      height="18"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M9 4.75C7.20507 4.75 5.75 6.20507 5.75 8C5.75 9.79493 7.20507 11.25 9 11.25C10.7949 11.25 12.25 9.79493 12.25 8C12.25 6.20507 10.7949 4.75 9 4.75ZM4.25 8C4.25 5.37665 6.37665 3.25 9 3.25C11.6234 3.25 13.75 5.37665 13.75 8C13.75 10.6234 11.6234 12.75 9 12.75C6.37665 12.75 4.25 10.6234 4.25 8ZM16 6.75C14.8954 6.75 14 7.64543 14 8.75C14 9.85457 14.8954 10.75 16 10.75C17.1046 10.75 18 9.85457 18 8.75C18 7.64543 17.1046 6.75 16 6.75ZM12.5 8.75C12.5 6.817 14.067 5.25 16 5.25C17.933 5.25 19.5 6.817 19.5 8.75C19.5 10.683 17.933 12.25 16 12.25C14.067 12.25 12.5 10.683 12.5 8.75ZM2.25 20C2.25 16.5482 5.04822 13.75 8.5 13.75H9.5C12.9518 13.75 15.75 16.5482 15.75 20C15.75 20.4142 15.4142 20.75 15 20.75C14.5858 20.75 14.25 20.4142 14.25 20C14.25 17.3766 12.1234 15.25 9.5 15.25H8.5C5.87665 15.25 3.75 17.3766 3.75 20C3.75 20.4142 3.41421 20.75 3 20.75C2.58579 20.75 2.25 20.4142 2.25 20ZM17 14.75C16.5858 14.75 16.25 15.0858 16.25 15.5C16.25 15.9142 16.5858 16.25 17 16.25H17.5C19.0188 16.25 20.25 17.4812 20.25 19C20.25 19.4142 20.5858 19.75 21 19.75C21.4142 19.75 21.75 19.4142 21.75 19C21.75 16.6528 19.8472 14.75 17.5 14.75H17Z"
                        fill=""
                      />
                    </svg>
                    Client Account
                  </a>
                </li>
                @endcan
              </ul>
            </div>
          </li>
          <!-- Menu Item Client Management Group -->

          <!-- Menu Item News -->
          <li>
            <a
              href="{{ route('staff.news.index') }}"
              class="menu-item group"
              :class="page === 'NewsManagement' ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="page === 'NewsManagement' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M8.50391 4.25C8.50391 3.83579 8.83969 3.5 9.25391 3.5H15.2777C15.4766 3.5 15.6674 3.57902 15.8081 3.71967L18.2807 6.19234C18.4214 6.333 18.5004 6.52376 18.5004 6.72268V16.75C18.5004 17.1642 18.1646 17.5 17.7504 17.5H16.248V17.4993H14.748V17.5H9.25391C8.83969 17.5 8.50391 17.1642 8.50391 16.75V4.25ZM14.748 19H9.25391C8.01126 19 7.00391 17.9926 7.00391 16.75V6.49854H6.24805C5.83383 6.49854 5.49805 6.83432 5.49805 7.24854V19.75C5.49805 20.1642 5.83383 20.5 6.24805 20.5H13.998C14.4123 20.5 14.748 20.1642 14.748 19.75L14.748 19ZM7.00391 4.99854V4.25C7.00391 3.00736 8.01127 2 9.25391 2H15.2777C15.8745 2 16.4468 2.23705 16.8687 2.659L19.3414 5.13168C19.7634 5.55364 20.0004 6.12594 20.0004 6.72268V16.75C20.0004 17.9926 18.9931 19 17.7504 19H16.248L16.248 19.75C16.248 20.9926 15.2407 22 13.998 22H6.24805C5.00541 22 3.99805 20.9926 3.99805 19.75V7.24854C3.99805 6.00589 5.00541 4.99854 6.24805 4.99854H7.00391Z"
                  fill=""
                />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                News
              </span>
            </a>
          </li>
          <!-- Menu Item News -->
          <!-- Menu Item Inventory -->
          <li>
            <a
              href="{{ route('staff.inventory.index') }}"
              @click="selected = (selected === 'Inventory' ? '' : 'Inventory')"
              class="menu-item group"
              :class="(selected === 'Inventory') ? 'menu-item-active' : 'menu-item-inactive'"
            >

              <svg
                :class="(selected === 'Inventory') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M11.665 3.75621C11.8762 3.65064 12.1247 3.65064 12.3358 3.75621L18.7807 6.97856L12.3358 10.2009C12.1247 10.3065 11.8762 10.3065 11.665 10.2009L5.22014 6.97856L11.665 3.75621ZM4.29297 8.19203V16.0946C4.29297 16.3787 4.45347 16.6384 4.70757 16.7654L11.25 20.0366V11.6513C11.1631 11.6205 11.0777 11.5843 10.9942 11.5426L4.29297 8.19203ZM12.75 20.037L19.2933 16.7654C19.5474 16.6384 19.7079 16.3787 19.7079 16.0946V8.19202L13.0066 11.5426C12.9229 11.5844 12.8372 11.6208 12.75 11.6516V20.037ZM13.0066 2.41456C12.3732 2.09786 11.6277 2.09786 10.9942 2.41456L4.03676 5.89319C3.27449 6.27432 2.79297 7.05342 2.79297 7.90566V16.0946C2.79297 16.9469 3.27448 17.726 4.03676 18.1071L10.9942 21.5857L11.3296 20.9149L10.9942 21.5857C11.6277 21.9024 12.3732 21.9024 13.0066 21.5857L19.9641 18.1071C20.7264 17.726 21.2079 16.9469 21.2079 16.0946V7.90566C21.2079 7.05342 20.7264 6.27432 19.9641 5.89319L13.0066 2.41456Z" fill=""></path>
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Inventory
              </span>

            </a>
          </li>
          <!-- End Menu Item Inventory -->
          <!-- Menu Item Profile -->
          <li>
            <a
              href="{{ route('staff.profile.show') }}"
              @click="selected = (selected === 'Profile' ? '':'Profile')"
              class="menu-item group"
              :class=" (selected === 'Profile') && (page === 'profile') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'Profile') && (page === 'profile') ?  'menu-item-icon-active'  :'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M12 3.5C7.30558 3.5 3.5 7.30558 3.5 12C3.5 14.1526 4.3002 16.1184 5.61936 17.616C6.17279 15.3096 8.24852 13.5955 10.7246 13.5955H13.2746C15.7509 13.5955 17.8268 15.31 18.38 17.6167C19.6996 16.119 20.5 14.153 20.5 12C20.5 7.30558 16.6944 3.5 12 3.5ZM17.0246 18.8566V18.8455C17.0246 16.7744 15.3457 15.0955 13.2746 15.0955H10.7246C8.65354 15.0955 6.97461 16.7744 6.97461 18.8455V18.856C8.38223 19.8895 10.1198 20.5 12 20.5C13.8798 20.5 15.6171 19.8898 17.0246 18.8566ZM2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM11.9991 7.25C10.8847 7.25 9.98126 8.15342 9.98126 9.26784C9.98126 10.3823 10.8847 11.2857 11.9991 11.2857C13.1135 11.2857 14.0169 10.3823 14.0169 9.26784C14.0169 8.15342 13.1135 7.25 11.9991 7.25ZM8.48126 9.26784C8.48126 7.32499 10.0563 5.75 11.9991 5.75C13.9419 5.75 15.5169 7.32499 15.5169 9.26784C15.5169 11.2107 13.9419 12.7857 11.9991 12.7857C10.0563 12.7857 8.48126 11.2107 8.48126 9.26784Z"
                  fill=""
                />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                User Profile
              </span>
            </a>
          </li>
          <!-- Menu Item Profile -->

          <!-- Menu Item Staff Management -->
          <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'StaffManagement' ? '':'StaffManagement')"
              class="menu-item group"
              :class="(selected === 'StaffManagement') || (page === 'StaffAccount' || page === 'UserManagement' || page === 'StaffScheduleManagement' || page === 'AttendanceManagement' || page === 'PayrollManagement') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'StaffManagement') || (page === 'StaffAccount' || page === 'UserManagement' || page === 'StaffScheduleManagement' || page === 'AttendanceManagement' || page === 'PayrollManagement') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <!-- Group of Users Icon in TailAdmin silhouette style -->
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M12 3C10.067 3 8.5 4.567 8.5 6.5C8.5 8.433 10.067 10 12 10C13.933 10 15.5 8.433 15.5 6.5C15.5 4.567 13.933 3 12 3ZM7 6.5C7 3.73858 9.23858 1.5 12 1.5C14.7614 1.5 17 3.73858 17 6.5C17 9.26142 14.7614 11.5 12 11.5C9.23858 11.5 7 9.26142 7 6.5ZM4.25 18.25C4.25 15.2124 6.71243 12.75 9.75 12.75H14.25C17.2876 12.75 19.75 15.2124 19.75 18.25C19.75 18.6642 19.4142 19 19 19H5C4.58579 19 4.25 18.6642 4.25 18.25ZM9.75 14.25C7.54086 14.25 5.75 16.0409 5.75 18.25H18.25C18.25 16.0409 16.4591 14.25 14.25 14.25H9.75ZM6 8.5C5.17157 8.5 4.5 7.82843 4.5 7C4.5 6.17157 5.17157 5.5 6 5.5C6.82843 5.5 7.5 6.17157 7.5 7C7.5 7.82843 6.82843 8.5 6 8.5ZM6 10C4.34315 10 3 8.65685 3 7C3 5.34315 4.34315 4 6 4C7.65685 4 9 5.34315 9 7C9 8.65685 7.65685 10 6 10ZM18 8.5C17.1716 8.5 16.5 7.82843 16.5 7C16.5 6.17157 17.1716 5.5 18 5.5C18.8284 5.5 19.5 6.17157 19.5 7C19.5 7.82843 18.8284 8.5 18 8.5ZM18 10C16.3431 10 15 8.65685 15 7C15 5.34315 16.3431 4 18 4C19.6569 4 21 5.34315 21 7C21 8.65685 19.6569 10 18 10Z"
                  fill=""
                />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Staff Management
              </span>

              <svg
                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                :class="[(selected === 'StaffManagement') || (page === 'StaffAccount' || page === 'UserManagement' || page === 'StaffScheduleManagement' || page === 'AttendanceManagement' || page === 'PayrollManagement') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
                  stroke=""
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </a>

            <div
              class="overflow-hidden transform translate"
              :class="(selected === 'StaffManagement') || (page === 'StaffAccount' || page === 'UserManagement' || page === 'StaffScheduleManagement' || page === 'AttendanceManagement' || page === 'PayrollManagement') ? 'block' :'hidden'"
            >
              <ul
                :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9"
              >
                @can('manage-staff-users')
                <!-- Staff Profiles (truoc day la Staff Account) -->
                <li>
                  <a
                    href="{{ route('staff.users.index') }}"
                    class="menu-dropdown-item group flex items-center gap-2"
                    :class="(page === 'StaffAccount' || page === 'UserManagement') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    <svg
                      class="fill-current"
                      width="18"
                      height="18"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M12 3.75C9.92893 3.75 8.25 5.42893 8.25 7.5C8.25 9.57107 9.92893 11.25 12 11.25C14.0711 11.25 15.75 9.57107 15.75 7.5C15.75 5.42893 14.0711 3.75 12 3.75ZM6.75 7.5C6.75 4.60051 9.10051 2.25 12 2.25C14.8995 2.25 17.25 4.60051 17.25 7.5C17.25 10.3995 14.8995 12.75 12 12.75C9.10051 12.75 6.75 10.3995 6.75 7.5ZM5.25 20.25C5.25 16.5221 8.27208 13.5 12 13.5C15.7279 13.5 18.75 16.5221 18.75 20.25C18.75 20.6642 18.4142 21 18 21C17.5858 21 17.25 20.6642 17.25 20.25C17.25 17.3505 14.8995 15 12 15C9.10051 15 6.75 17.3505 6.75 20.25C6.75 20.6642 6.41421 21 6 21C5.58579 21 5.25 20.6642 5.25 20.25Z"
                        fill=""
                      />
                    </svg>
                    Staff Profiles
                  </a>
                </li>
                @endcan

                <!-- Staff Schedules -->
                <li>
                  <a
                    href="{{ route('staff.schedules.index') }}"
                    class="menu-dropdown-item group flex items-center gap-2"
                    :class="page === 'StaffScheduleManagement' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    <svg
                      class="fill-current"
                      width="18" height="18" viewBox="0 0 24 24" fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M8 2C8.41421 2 8.75 2.33579 8.75 2.75V3.75H15.25V2.75C15.25 2.33579 15.5858 2 16 2C16.4142 2 16.75 2.33579 16.75 2.75V3.75H18.5C19.7426 3.75 20.75 4.75736 20.75 6V19C20.75 20.2426 19.7426 21.25 18.5 21.25H5.5C4.25736 21.25 3.25 20.2426 3.25 19V6C3.25 4.75736 4.25 3.75 5.5 3.75H7.25V2.75C7.25 2.33579 7.58579 2 8 2ZM4.75 9.75V19C4.75 19.4142 5.08579 19.75 5.5 19.75H18.5C18.9142 19.75 19.25 19.4142 19.25 19V9.75H4.75Z"
                            fill=""/>
                    </svg>
                    Staff Schedules
                  </a>
                </li>

                <!-- Attendance -->
                <li>
                  <a
                    href="{{ route('staff.attendance.index') }}"
                    class="menu-dropdown-item group flex items-center gap-2"
                    :class="page === 'AttendanceManagement' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    <svg
                      class="fill-current"
                      width="18" height="18" viewBox="0 0 24 24" fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M8 2C8.41421 2 8.75 2.33579 8.75 2.75V3.75H15.25V2.75C15.25 2.33579 15.5858 2 16 2C16.4142 2 16.75 2.33579 16.75 2.75V3.75H18.5C19.7426 3.75 20.75 4.75736 20.75 6V19C20.75 20.2426 19.7426 21.25 18.5 21.25H5.5C4.25736 21.25 3.25 20.2426 3.25 19V6C3.25 4.75736 4.25736 3.75 5.5 3.75H7.25V2.75C7.25 2.33579 7.58579 2 8 2ZM4.75 9.75V19C4.75 19.4142 5.08579 19.75 5.5 19.75H18.5C18.9142 19.75 19.25 19.4142 19.25 19V9.75H4.75ZM11.5795 16.1477L15.5028 12.2244C15.7957 11.9315 16.2706 11.9315 16.5635 12.2244C16.8564 12.5173 16.8564 12.9922 16.5635 13.285L12.1098 17.7388C11.8169 18.0317 11.342 18.0317 11.0491 17.7388L8.19012 14.8798C7.89723 14.5869 7.89723 14.1121 8.19012 13.8192C8.48302 13.5263 8.95789 13.5263 9.25078 13.8192L11.5795 16.1477Z"
                            fill=""/>
                    </svg>
                    Attendance
                  </a>
                </li>

                <!-- Payroll -->
                <li>
                  <a
                    href="{{ route('staff.payrolls.index') }}"
                    class="menu-dropdown-item group flex items-center gap-2"
                    :class="page === 'PayrollManagement' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    <svg
                      class="fill-current"
                      width="18"
                      height="18"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M6.5 3.25C5.25736 3.25 4.25 4.25736 4.25 5.5V18.5C4.25 19.7426 5.25736 20.75 6.5 20.75H17.5C18.7426 20.75 19.75 19.7426 19.75 18.5V5.5C19.75 4.25736 18.7426 3.25 17.5 3.25H6.5ZM5.75 5.5C5.75 5.08579 6.08579 4.75 6.5 4.75H17.5C17.9142 4.75 18.25 5.08579 18.25 5.5V18.5C18.25 18.9142 17.9142 19.25 17.5 19.25H6.5C6.08579 19.25 5.75 18.9142 5.75 18.5V5.5ZM8.25 8C8.25 7.58579 8.58579 7.25 9 7.25H15C15.4142 7.25 15.75 7.58579 15.75 8C15.75 8.41421 15.4142 8.75 15 8.75H9C8.58579 8.75 8.25 8.41421 8.25 8ZM8.25 12C8.25 11.5858 8.58579 11.25 9 11.25H9.01C9.42421 11.25 9.76 11.5858 9.76 12C9.76 12.4142 9.42421 12.75 9.01 12.75H9C8.58579 12.75 8.25 12.4142 8.25 12ZM11.25 12C11.25 11.5858 11.5858 11.25 12 11.25H12.01C12.4242 11.25 12.76 11.5858 12.76 12C12.76 12.4142 12.4242 12.75 12.01 12.75H12C11.5858 12.75 11.25 12.4142 11.25 12ZM14.25 12C14.25 11.5858 14.5858 11.25 15 11.25H15.01C15.4242 11.25 15.76 11.5858 15.76 12C15.76 12.4142 15.4242 12.75 15.01 12.75H15C14.5858 12.75 14.25 12.4142 14.25 12ZM8.25 15.5C8.25 15.0858 8.58579 14.75 9 14.75H9.01C9.42421 14.75 9.76 15.0858 9.76 15.5C9.76 15.9142 9.42421 16.25 9.01 16.25H9C8.58579 16.25 8.25 15.9142 8.25 15.5ZM11.25 15.5C11.25 15.0858 11.5858 14.75 12 14.75H12.01C12.4242 14.75 12.76 15.0858 12.76 15.5C12.76 15.9142 12.4242 16.25 12.01 16.25H12C11.5858 16.25 11.25 15.9142 11.25 15.5ZM14.25 15.5C14.25 15.0858 14.5858 14.75 15 14.75H15.01C15.4242 14.75 15.76 15.0858 15.76 15.5C15.76 15.9142 15.4242 16.25 15.01 16.25H15C14.5858 16.25 14.25 15.9142 14.25 15.5Z"
                        fill=""
                      />
                    </svg>
                    Payroll
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <!-- Menu Item Staff Management -->

        </ul>
      </div>
    </nav>
    <!-- Sidebar Menu -->

  </div>
</aside>
