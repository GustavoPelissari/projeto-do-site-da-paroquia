@props([
    'label' => null,
    'name',
    'type' => 'text',
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'errors' => null,
    'hint' => null,
])

<div class="mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if ($required)
                <span class="text-danger" aria-label="requerido">*</span>
            @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror"
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif
        @if ($required) required aria-required="true" @endif
        @if ($disabled) disabled aria-disabled="true" @endif
        @if ($hint) aria-describedby="{{ $name }}-hint" @endif
        {{ $attributes }}
    >

    @if ($hint)
        <small id="{{ $name }}-hint" class="form-text text-muted">
            {{ $hint }}
        </small>
    @endif

    @error($name)
        <div class="invalid-feedback d-block" role="alert">
            {{ $message }}
        </div>
    @enderror
</div>
