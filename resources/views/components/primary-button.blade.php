<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-cobalto hover:bg-cobalto-dark text-blanco rounded-md font-semibold text-sm transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
