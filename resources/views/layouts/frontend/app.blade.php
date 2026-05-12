{{-- Deprecated frontend layout kept for compatibility. Use <x-frontend.layout> in frontend pages. --}}
<x-frontend.layout :title="$title ?? 'ZenStyle — Salon'" :main-class="$mainClass ?? 'pt-20'">
    {{ $slot ?? '' }}
</x-frontend.layout>
