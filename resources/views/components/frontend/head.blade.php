@props([
    'title' => 'ZenStyle — Salon',
])

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $title }}</title>
{{-- Frontend typography: Playfair Display cho heading, Inter cho body/UI. --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Sora:wght@500;600;700&display=swap" rel="stylesheet">
<link rel="icon" type="image/png" href="{{ asset('images/logos/zenstyle-mark.png') }}" sizes="32x32">
