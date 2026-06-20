<button type="submit" {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-green-400 hover:bg-green-500 text-white py-2 px-3 text-sm rounded-lg mx-2']) }}>
    {{ $slot }}
</button>
