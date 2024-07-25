@props([
    'type' => 'text',
    'placeholder' => null,
    'value' => null,
    'label' => null,
    'name' => null,
    'id' => null,
    'readonly' => false,
])
<label>{{ $label }}</label>
<div class="mb-3">
    <input type="{{ $type }}" class="form-control" placeholder="{{ $placeholder }}" value="{{ $value }}"
        name="{{ $name }}" id="{{ $id }}" {{ $readonly ? 'readonly' : '' }} />
</div>
