<!doctype html>
<html lang="vi" class="scroll-smooth">
<head>
    @include('layouts.frontend.partials.head')
    @vite(['resources/css/frontend.css', 'resources/js/frontend.js'])
</head>
<body class="min-h-screen bg-stone-50 font-outfit text-stone-900 antialiased">
@include('layouts.frontend.partials.navbar')
<main class="@yield('main_class', 'pt-20')">
    @yield('content')
</main>
@include('layouts.frontend.partials.footer')
@include('layouts.frontend.partials.floating-booking')
</body>
</html>
