@props([
    'title' => 'ZenStyle — Salon',
    'mainClass' => 'pt-20',
])

<!doctype html>
<html lang="vi" class="scroll-smooth">
<head>
    <x-frontend.head :title="$title" />
    @vite(['resources/css/frontend.css', 'resources/js/frontend.js'])
</head>
<body class="bg-zen-bg text-zen-text min-h-screen font-outfit antialiased">
<x-frontend.header />
<main class="{{ $mainClass }}">
    {{ $slot }}
</main>
<x-frontend.footer />
<x-frontend.floating-booking />
</body>
</html>
