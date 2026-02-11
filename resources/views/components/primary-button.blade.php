<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-custom btn-custom-gray']) }}>
    {{ $slot }}
</button>
