<a {{ $attributes->merge([ 'class' => 'flex items-center justify-center text-center text-green-600 bg-none hover:bg-green-500 hover:text-white py-2 px-3 text-sm rounded-lg mx-2 focus:outline-none hover:text-white border border-green-400']) }}>
    {{ $slot }}
</a>
