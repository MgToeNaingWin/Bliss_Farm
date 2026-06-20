@props(['active' => false])

<a {{ $attributes->merge([
    'class' => ($active ? 'bg-gray-950/50 text-white' : 'border-b-2 border-transparent hover:border-amber-50 pb-1 transition duration-300 ease-in-out') . ' rounded-md px-3 py-2 text-sm font-medium',
    'aria-current' => $active ? 'page' : null
]) }}>
    {{ $slot }}
</a>
