@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-stone-900']) }}>
    {{ $value ?? $slot }}
</label>
