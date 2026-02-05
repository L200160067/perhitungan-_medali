@props(['type' => 'success', 'message'])

@php
    $classes = [
        'success' => 'bg-green-50 border-green-200 text-green-800',
        'error' => 'bg-red-50 border-red-200 text-red-800',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
        'info' => 'bg-blue-50 border-blue-200 text-blue-800',
    ];
    
    $icons = [
        'success' => '✓',
        'error' => '✕',
        'warning' => '⚠',
        'info' => 'ℹ',
    ];
@endphp

<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    <div class="rounded-lg border-2 p-4 {{ $classes[$type] ?? $classes['info'] }}">
        <div class="flex items-center">
            <span class="text-xl mr-3">{{ $icons[$type] ?? $icons['info'] }}</span>
            <p class="font-medium">{{ $message }}</p>
        </div>
    </div>
</div>
