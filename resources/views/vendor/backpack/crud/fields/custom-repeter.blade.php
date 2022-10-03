
<div class="table-responsive">
    <table class="table table-bordered d-none attribute" id="dynamic_field">
        <tr>
            <td><label for="form-control">Attribute Value :</label>
                <input type="text" name="name[]" class="form-control" /></td>
            <td>
                <div>
                    <label for="form-control">Attribute Status : </label>
                </div>
                <div class="form-check-inline">
                    <input class="form-check-input" type="radio" name="radio" id="active" value="1">Active
                    <input class="form-check-input" type="radio" name="radio" id="deactive" value="0">Deactive
                </div>
            </td>
            <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
        </tr>
    </table>
</div>
{{-- @include('crud::fields.inc.wrapper_start')

<label>{!! $field['label'] !!}</label>
@include('crud::fields.inc.translatable_icon')
<div class="repeatable-fields">
    @foreach($field['fields'] as $subfield)
        @php
            $subfield = $crud->makeSureFieldHasNecessaryAttributes($subfield);
            $fieldViewNamespace = $subfield['view_namespace'] ?? 'crud::fields';
            $fieldViewPath = $fieldViewNamespace.'.'.$subfield['type'];
        @endphp

        @include($fieldViewPath, ['field' => $subfield])
    @endforeach

</div>



<button type="button" class="btn attribute_button btn-outline-primary btn-sm ml-1 add-repeatable-element-button">+ {{ $field['new_item_label'] ?? trans('backpack::crud.new_item') }}</button>

@include('crud::fields.inc.wrapper_end')

@push('crud_fields_styles')
<!-- no styles -->
<style type="text/css">
  .repeatable-fields {
    border: 1px solid rgba(0,40,100,.12);
    border-radius: 5px;
    background-color: #f0f3f94f;
    padding: 10px;
    margin-bottom: 10px;
  }
  .attribute{
    display: block;
    width: 100%;

  }
  .container-repeatable-elements .controls {
    display: flex;
    flex-direction: column;
    align-content: center;
    position: absolute !important;
    left: -16px;
    z-index: 2;
  }

  .container-repeatable-elements .controls button {
    height: 30px;
    width: 30px;
    border-radius: 50%;
    background-color: #e8ebf0 !important;
    margin-bottom: 2px;
    overflow: hidden;
  }
  .container-repeatable-elements .controls button.move-element-up,
  .container-repeatable-elements .controls button.move-element-down {
      height: 24px;
      width: 24px;
      margin: 2px auto;
  }
  .container-repeatable-elements .repeatable-element:first-of-type .move-element-up,
  .container-repeatable-elements .repeatable-element:last-of-type .move-element-down {
      display: none;
  }
</style>
@endpush

@push('crud_fields_scripts')
<script>

$(document).ready(function () {
    $('.attr_name').removeAttr('data-repeatable-input-name');
    $('.attr_status').removeAttr('data-repeatable-input-name');

    var htmlContent = $('.repeatable-fields').html();
    // console.log(htmlContent);
    $(document).on('change', '.select-test', function () {
        alert('hhh');
    });
    $(document).on('click', '.attribute_button', function () {

        conceptName = $('.select-test').find(":selected").val();
        console.log(conceptName);
        if(conceptName == 1 || conceptName == 2){
            // alert('gvfkdkl');
        }
        // $('.repeatable-fields').after('<div class="repeatable-fields">'+htmlContent+'</div>');
        console.log($(this).parent().parent().attr("data-row-number"), 'main div id ');
    });

});

</script>
@endpush --}}
