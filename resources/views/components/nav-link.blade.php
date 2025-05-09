@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-block px-1 py-0.5 border-b-2 border-indigo-400 text-sm font-medium text-gray-900 dark:text-white focus:outline-none focus:border-indigo-700 dark:focus:border-indigo-500 transition duration-150 ease-in-out'
    : 'inline-block px-1 py-0.5 border-b-2 border-transparent text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
