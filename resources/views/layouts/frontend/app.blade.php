<!doctype html>
{{-- scroll-smooth: khi bấm link #section trình duyệt cuộn mượt (tuỳ trình duyệt) --}}
<html lang="vi" class="scroll-smooth">
<head>
    @include('layouts.frontend.partials.head')
    {{-- @vite: frontend dùng entry riêng để load Tailwind + JS --}}
    @vite(['resources/css/frontend.css', 'resources/js/frontend.js'])
</head>
<body class="min-h-screen bg-white font-outfit text-stone-900 antialiased">
@include('layouts.frontend.partials.navbar')
{{--
    Mặc định pt-20: chừa chỗ cho navbar fixed (xem comment cũ).
    Trang chủ có thể @section('main_class', 'pt-0') để banner full màn kéo lên dưới navbar (trong suốt).
--}}
<main class="@yield('main_class', 'pt-20')">
    @yield('content')
</main>
@include('layouts.frontend.partials.footer')
</body>
</html>
