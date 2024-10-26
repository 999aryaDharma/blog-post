<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'relative font-sm -top-1 -left-1 bg-gray-800 py-1.5 px-5 text-white transition-all active:top-0 active:left-0 active:bg-gray-900 before:content-[""] before:absolute before:top-1 before:left-1 before:w-full before:h-full before:border-2 before:border-gray-800 before:-z-10 before:transition-all active:before:top-0 active:before:left-0'
]) }}>
    {{ $slot }}
</button>

