@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block px-4 py-2 text-sm text-gray-700 bg-gray-200 border-l-4 border-indigo-400'
            : 'block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-800';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>