@php
    $field['prefix'] = $field['prefix'] ?? '';
    $field['disk'] = $field['disk'] ?? null;
    $value = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '';
@endphp
@include('crud::fields.inc.wrapper_start')
<div class="mb-3">
    <label for="formFileSm" class="form-label">{{ $field['label'] }}</label>
    @if(isset($field['value']))
        <img src="{{ $field['value'] }}" width="100px" height="100">
    @endif
    <input class="form-control form-control-sm" id="file" name="{{ $field['name'] }}" type="file">
</div>

@include('crud::fields.inc.wrapper_end')

