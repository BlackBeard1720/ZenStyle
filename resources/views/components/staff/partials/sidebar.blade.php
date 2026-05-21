<aside
  :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
  class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
>
  <!-- SIDEBAR HEADER -->
  <div
    :class="sidebarToggle ? 'justify-center' : 'justify-between'"
    class="flex items-center gap-2 pt-8 sidebar-header pb-7"
  >
    <a href="{{ route('staff.dashboard') }}">
      <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
        <img class="dark:hidden" src="{{ asset('images/tailadmin/logo/logo.svg') }}" alt="Logo" />
        <img
          class="hidden dark:block"
          src="{{ asset('images/tailadmin/logo/logo-dark.svg') }}"
          alt="Logo"
        />
      </span>

      <img
        class="logo-icon"
        :class="sidebarToggle ? 'lg:block' : 'hidden'"
        src="{{ asset('images/tailadmin/logo/logo-icon.svg') }}"
        alt="Logo"
      />
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

          <!-- Menu Item Service Management -->
          @canany(['view-categories', 'view-services'])
          <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'ServiceManagement' ? '':'ServiceManagement')"
              class="menu-item group"
              :class="(selected === 'ServiceManagement') || (page === 'CategoryManagement' || page === 'ServiceManagement') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'ServiceManagement') || (page === 'CategoryManagement' || page === 'ServiceManagement') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M5.25 4C4.55964 4 4 4.55964 4 5.25V18.75C4 19.4404 4.55964 20 5.25 20H18.75C19.4404 20 20 19.4404 20 18.75V5.25C20 4.55964 19.4404 4 18.75 4H5.25ZM2.5 5.25C2.5 3.73122 3.73122 2.5 5.25 2.5H18.75C20.2688 2.5 21.5 3.73122 21.5 5.25V18.75C21.5 20.2688 20.2688 21.5 18.75 21.5H5.25C3.73122 21.5 2.5 20.2688 2.5 18.75V5.25ZM7.25 7.5C7.25 7.08579 7.58579 6.75 8 6.75H16C16.4142 6.75 16.75 7.08579 16.75 7.5C16.75 7.91421 16.4142 8.25 16 8.25H8C7.58579 8.25 7.25 7.91421 7.25 7.5ZM7.25 12C7.25 11.5858 7.58579 11.25 8 11.25H16C16.4142 11.25 16.75 11.5858 16.75 12C16.75 12.4142 16.4142 12.75 16 12.75H8C7.58579 12.75 7.25 12.4142 7.25 12ZM7.25 16.5C7.25 16.0858 7.58579 15.75 8 15.75H13C13.4142 15.75 13.75 16.0858 13.75 16.5C13.75 16.9142 13.4142 17.25 13 17.25H8C7.58579 17.25 7.25 16.9142 7.25 16.5Z"
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
                :class="[(selected === 'ServiceManagement') || (page === 'CategoryManagement' || page === 'ServiceManagement') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
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
              :class="(selected === 'ServiceManagement') || (page === 'CategoryManagement' || page === 'ServiceManagement') ? 'block' :'hidden'"
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
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M5.25 4C4.55964 4 4 4.55964 4 5.25V18.75C4 19.4404 4.55964 20 5.25 20H18.75C19.4404 20 20 19.4404 20 18.75V5.25C20 4.55964 19.4404 4 18.75 4H5.25ZM2.5 5.25C2.5 3.73122 3.73122 2.5 5.25 2.5H18.75C20.2688 2.5 21.5 3.73122 21.5 5.25V18.75C21.5 20.2688 20.2688 21.5 18.75 21.5H5.25C3.73122 21.5 2.5 20.2688 2.5 18.75V5.25ZM7.25 7.5C7.25 7.08579 7.58579 6.75 8 6.75H16C16.4142 6.75 16.75 7.08579 16.75 7.5C16.75 7.91421 16.4142 8.25 16 8.25H8C7.58579 8.25 7.25 7.91421 7.25 7.5ZM7.25 12C7.25 11.5858 7.58579 11.25 8 11.25H16C16.4142 11.25 16.75 11.5858 16.75 12C16.75 12.4142 16.4142 12.75 16 12.75H8C7.58579 12.75 7.25 12.4142 7.25 12ZM7.25 16.5C7.25 16.0858 7.58579 15.75 8 15.75H13C13.4142 15.75 13.75 16.0858 13.75 16.5C13.75 16.9142 13.4142 17.25 13 17.25H8C7.58579 17.25 7.25 16.9142 7.25 16.5Z" fill=""/>
                    </svg>
                    Services
                  </a>
                </li>
                @endcan
              </ul>
            </div>
          </li>
          @endcanany
          <!-- Menu Item Service Management -->

          <!-- Menu Item Clients -->
          <li>
            <a
              href="{{ route('staff.clients.index') }}"
              class="menu-item group"
              :class="page === 'ClientManagement' ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="page === 'ClientManagement' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
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
            </a>
          </li>
          <!-- Menu Item Clients -->

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

          @can('manage-staff-users')
          <!-- Menu Item Authentication -->
          <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'Authentication' ? '':'Authentication')"
              class="menu-item group"
              :class="(selected === 'Authentication') || (page === 'StaffAccount' || page === 'ClientAccount' || page === 'UserManagement') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'Authentication') || (page === 'StaffAccount' || page === 'ClientAccount' || page === 'UserManagement') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M14 2.75C14 2.33579 14.3358 2 14.75 2C15.1642 2 15.5 2.33579 15.5 2.75V5.73291L17.75 5.73291H19C19.4142 5.73291 19.75 6.0687 19.75 6.48291C19.75 6.89712 19.4142 7.23291 19 7.23291H18.5L18.5 12.2329C18.5 15.5691 15.9866 18.3183 12.75 18.6901V21.25C12.75 21.6642 12.4142 22 12 22C11.5858 22 11.25 21.6642 11.25 21.25V18.6901C8.01342 18.3183 5.5 15.5691 5.5 12.2329L5.5 7.23291H5C4.58579 7.23291 4.25 6.89712 4.25 6.48291C4.25 6.0687 4.58579 5.73291 5 5.73291L6.25 5.73291L8.5 5.73291L8.5 2.75C8.5 2.33579 8.83579 2 9.25 2C9.66421 2 10 2.33579 10 2.75L10 5.73291L14 5.73291V2.75ZM7 7.23291L7 12.2329C7 14.9943 9.23858 17.2329 12 17.2329C14.7614 17.2329 17 14.9943 17 12.2329L17 7.23291L7 7.23291Z"
                  fill=""
                />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Authentication
              </span>

              <svg
                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                :class="[(selected === 'Authentication') || (page === 'StaffAccount' || page === 'ClientAccount' || page === 'UserManagement') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
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
              :class="(selected === 'Authentication') || (page === 'StaffAccount' || page === 'ClientAccount' || page === 'UserManagement') ? 'block' :'hidden'"
            >
              <ul
                :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9"
              >
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
                    Staff Account
                  </a>
                </li>
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
              </ul>
            </div>
          </li>
          <!-- Menu Item Authentication -->
          @endcan

        </ul>
      </div>
    </nav>
    <!-- Sidebar Menu -->

  </div>
</aside>
