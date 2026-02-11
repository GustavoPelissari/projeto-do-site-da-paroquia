@props(['value'])

<label {{ $attributes->merge(['class' => 'd-block font-medium text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
