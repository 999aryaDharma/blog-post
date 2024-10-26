@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block mt-1 w-full border border-gray-300 rounded-lg focus:border-slate-500 focus:ring focus:ring-slate-500 focus:ring-opacity-50 shadow-sm hover:shadow-lg transition-shadow duration-300']) !!}>
