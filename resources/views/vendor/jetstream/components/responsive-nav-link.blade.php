@props(['active'])

@php
$classes = ($active ?? false)
? 'block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-white bg-sky-700 focus:outline-none focus:text-sky-800 focus:bg-sky-500 focus:border-indigo-700 transition'
: 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:text-white hover:bg-sky-800 hover:border-sky-600 focus:outline-none focus:text-sky-800 focus:bg-sky-600 focus:border-gray-800 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
