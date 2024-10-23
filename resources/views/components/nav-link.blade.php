@props(['active'])

@php
$classes = ($active ?? false)
    ? 'text-black bg-gray-700'
    : 'text-md text-black  py-1 px-1.5 rounded-sm relative inline-block text-gray-800 hover:text-black group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
