@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-[var(--color-cobalto)] focus:ring-[var(--color-cian)] focus:ring-1 shadow-sm']) }}>
