@props(['role'])

@php
  $roleKey = strtolower((string) $role);

  $config = match ($roleKey) {
      'admin' => [
          'label' => 'Admin',
          'class' => 'bg-purple-50 text-purple-700 ring-purple-100 dark:bg-purple-500/15 dark:text-purple-300 dark:ring-purple-500/20',
      ],
      'receptionist' => [
          'label' => 'Receptionist',
          'class' => 'bg-blue-50 text-blue-700 ring-blue-100 dark:bg-blue-500/15 dark:text-blue-300 dark:ring-blue-500/20',
      ],
      'stylist' => [
          'label' => 'Stylist',
          'class' => 'bg-pink-50 text-pink-700 ring-pink-100 dark:bg-pink-500/15 dark:text-pink-300 dark:ring-pink-500/20',
      ],
      default => [
          'label' => ucfirst($roleKey ?: 'user'),
          'class' => 'bg-gray-100 text-gray-700 ring-gray-200 dark:bg-white/10 dark:text-gray-300 dark:ring-white/10',
      ],
  };
@endphp

<span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset {{ $config['class'] }}">
  @switch($roleKey)
    @case('admin')
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
        <path d="m3 8 4 9h10l4-9-5 4-4-7-4 7-5-4Z" />
        <path d="M7 21h10" />
      </svg>
      @break

    @case('receptionist')
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M4 12a8 8 0 0 1 16 0" />
        <path d="M4 12v4a2 2 0 0 0 2 2h1v-6H6a2 2 0 0 0-2 2" />
        <path d="M20 12v4a2 2 0 0 1-2 2h-1v-6h1a2 2 0 0 1 2 2" />
        <path d="M13 20h2a3 3 0 0 0 3-3" />
      </svg>
      @break

    @case('stylist')
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
        <circle cx="6" cy="6" r="3" />
        <circle cx="6" cy="18" r="3" />
        <path d="M8.2 8.2 19 19" />
        <path d="M8.2 15.8 19 5" />
      </svg>
      @break

    @default
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M20 21a8 8 0 0 0-16 0" />
        <circle cx="12" cy="7" r="4" />
      </svg>
  @endswitch

  <span>{{ $config['label'] }}</span>
</span>
