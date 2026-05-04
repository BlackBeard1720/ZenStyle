@extends('layouts.staff.base')
@section('title', 'eCommerce Dashboard | TailAdmin - Tailwind CSS Admin Dashboard Template')
@section('page_name', 'ecommerce')

@section('body_content')
<!-- ===== Preloader Start ===== -->
@include('layouts.staff.partials.preloader')
<!-- ===== Preloader End ===== -->

<!-- ===== Page Wrapper Start ===== -->
<div class="flex h-screen overflow-hidden">
    <!-- ===== Sidebar Start ===== -->
    @include('layouts.staff.partials.sidebar')
    <!-- ===== Sidebar End ===== -->

    <!-- ===== Content Area Start ===== -->
    <div
        class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto"
    >
        <!-- Small Device Overlay Start -->
        @include('layouts.staff.partials.overlay')
        <!-- Small Device Overlay End -->

        <!-- ===== Header Start ===== -->
        @include('layouts.staff.partials.header')
        <!-- ===== Header End ===== -->

        <!-- ===== Main Content Start ===== -->
        <main>
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">

                <!-- Alert Messages Start -->
                <!-- Success Message -->
                @include('layouts.staff.partials.alert.alert-success')
                <!-- Error Message -->
                @include('layouts.staff.partials.alert.alert-error')
                <!-- Alert Messages End -->

                @yield('content')
            </div>
        </main>
        <!-- ===== Main Content End ===== -->
    </div>
    <!-- ===== Content Area End ===== -->
</div>
<!-- ===== Page Wrapper End ===== -->
@endsection
