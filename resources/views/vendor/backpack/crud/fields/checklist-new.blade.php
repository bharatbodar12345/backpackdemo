<!-- checklist -->
@php

  // calculate the value of the hidden input
  $field['value'] = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? [];
  if ($field['value'] instanceof Illuminate\Database\Eloquent\Collection) {
    $field['value'] = $field['value']->pluck($key_attribute)->toArray();
  } elseif (is_string($field['value'])){
    $field['value'] = json_decode($field['value']);
  }

  // define the init-function on the wrapper
  $field['wrapper']['data-init-function'] =  $field['wrapper']['data-init-function'] ?? 'bpFieldInitChecklist';
@endphp

@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')

    <input type="hidden" @if (isset($field['selected']))
                        value='@json($field['selected'])'
                        @endif name="{{ $field['name'] }}">

    <div class="row">
        @foreach ($field['options'] as $key => $option)
            <div class="col-sm-{{ isset($field['number_of_columns']) ? intval(12/$field['number_of_columns']) : '4'}}">
                <div class="checkbox">
                  <label class="font-weight-normal">
                    <input type="checkbox" value="{{ $key }}"> {{ $option }}
                  </label>
                </div>
            </div>
        @endforeach
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp
    {{-- FIELD JS - will be loaded in the after_scripts section --}}


@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
