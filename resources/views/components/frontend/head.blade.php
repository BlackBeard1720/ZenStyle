@props([
    'title' => 'ZenStyle — Salon',
])

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $title }}</title>
{{-- Dancing Script: tiêu đề banner (chữ viết tay). Outfit: đã có trong resources/css/app.css --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700&display=swap" rel="stylesheet">
<link rel="icon" type="image/png" href="{{ asset('images/logos/zenstyle-mark.png') }}" sizes="32x32">
