<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-custom btn-custom-red']) }}>
    {{ $slot }}
</button>
