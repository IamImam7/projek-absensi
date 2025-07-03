@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center space-x-3 p-2 rounded-md bg-gray-900 text-white transition duration-150 ease-in-out'
            : 'flex items-center space-x-3 p-2 rounded-md hover:bg-gray-700 hover:text-white transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
