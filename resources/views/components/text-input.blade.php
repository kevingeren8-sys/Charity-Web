@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-stone-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm']) }}>
