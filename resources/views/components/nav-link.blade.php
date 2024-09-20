@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-2 border-1 border-gray-300 rounded-md bg-gray-900 text-white font-medium text-sm focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center px-3 py-2 border-1 border-transparent rounded-lg text-gray-300 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
