<?php
    $input_id = $delivery->with_address
        ? 'delivery-method-address'
        : 'delivery-method-pickup'
        . '-' . $delivery->id;
?>

<div class="form-radio">
    <input type="radio"
           name="delivery_type_id"
           id="{{ $input_id }}"
           value="{{ $delivery->id }}"
            @checked($loop->first || old('delivery_id') === $delivery->id)
    >
    <label for="{{ $input_id }}" class="form-radio-label">
        {{ $delivery->title }}
    </label>
</div>
