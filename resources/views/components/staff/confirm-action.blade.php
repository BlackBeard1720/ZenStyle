@props([
    'action',
    'method' => 'POST',
    'title' => 'Confirm Action',
    'message' => 'Are you sure you want to perform this action?',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'variant' => 'danger',
    'buttonText' => '',
    'buttonClass' => '',
])

@php
    $buttonColors = [
        'danger' => 'bg-error-500 hover:bg-error-600',
        'warning' => 'bg-warning-500 hover:bg-warning-600',
        'success' => 'bg-success-500 hover:bg-success-600',
        'primary' => 'bg-brand-500 hover:bg-brand-600',
    ];

    $confirmButtonClass = $buttonColors[$variant] ?? $buttonColors['danger'];
@endphp

<div x-data="{ open: false }" class="inline-block">
    <!-- Trigger Button / Slot -->
    <div @click="open = true">
        @if($slot->isNotEmpty())
            {{ $slot }}
        @else
            <button type="button" class="{{ $buttonClass }}">
                {{ $buttonText }}
            </button>
        @endif
    </div>

    <!-- Modal Overlay & Content -->
    <template x-teleport="body">
        <div x-show="open" 
             style="display: none;" 
             class="fixed inset-0 z-[999999] flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900/50 p-4"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
             
            <!-- Modal Box -->
            <div @click.outside="open = false" 
                 @keydown.escape.window="open = false"
                 class="relative w-full max-w-md rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-lg dark:border-gray-800 dark:bg-gray-900 sm:p-6"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                 
                <!-- Title & Message -->
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90">{{ $title }}</h4>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $message }}</p>
                
                <!-- Actions -->
                <div class="mt-6 flex items-center justify-end gap-3">
                    <button type="button" @click="open = false" class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800">
                        {{ $cancelText }}
                    </button>
                    
                    <form method="POST" action="{{ $action }}" class="m-0">
                        @csrf
                        @if(!in_array(strtoupper($method), ['GET', 'POST']))
                            @method($method)
                        @endif
                        <button type="submit" class="rounded-lg px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs {{ $confirmButtonClass }}">
                            {{ $confirmText }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>
