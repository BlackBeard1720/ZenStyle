@props(['title' => 'TailAdmin', 'pageName' => 'ecommerce'])

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta
        name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $title }}</title>
    @vite(['resources/css/staff.css', 'resources/js/staff/index.js'])
</head>
<body
    x-data="{ page: '{{ $pageName }}', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}"
>
    <!-- ===== Preloader Start ===== -->
    <x-staff.partials.preloader />
    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
        <!-- ===== Sidebar Start ===== -->
        <x-staff.partials.sidebar />
        <!-- ===== Sidebar End ===== -->

        <!-- ===== Content Area Start ===== -->
        <div
                class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto"
        >
            <!-- Small Device Overlay Start -->
            <x-staff.partials.overlay />
            <!-- Small Device Overlay End -->

            <!-- ===== Header Start ===== -->
            <x-staff.partials.header />
            <!-- ===== Header End ===== -->

            <!-- ===== Main Content Start ===== -->
            <main>
                <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">

                    <!-- Alert Messages Start -->
                    <!-- Success Message -->
                    <x-staff.partials.alert.alert-success />
                    <!-- Error Message -->
                    <x-staff.partials.alert.alert-error />
                    <!-- Alert Messages End -->

                    {{ $slot }}
                </div>
            </main>
            <!-- ===== Main Content End ===== -->
        </div>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    @stack('scripts')
</body>
</html>
