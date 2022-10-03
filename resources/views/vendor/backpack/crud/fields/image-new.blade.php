@php

    $field['prefix'] = $field['prefix'] ?? '';
    $field['disk'] = $field['disk'] ?? null;
    $value = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '';

    if (! function_exists('getDiskUrl')) {
        function getDiskUrl($disk, $path) {
            try {
                // make sure the value don't have disk base path on it, this is the same as `Storage::disk($disk)->url($prefix);`,
                // we need this solution to deal with `S3` not supporting getting empty urls
                // that could happen when there is no $prefix set.
                $origin = substr(Storage::disk($disk)->url('/'), 0, -1);
                $path = str_replace($origin, '', $path);

                return Storage::disk($disk)->url($path);
            }
            catch (Exception $e) {
                // the driver does not support retrieving URLs (eg. SFTP)
                return url($path);
            }
        }
    }

    if (! function_exists('maximumServerUploadSizeInBytes')) {
        function maximumServerUploadSizeInBytes() {

            $val = trim(ini_get('upload_max_filesize'));
            $last = strtolower($val[strlen($val)-1]);

            switch($last) {
                // The 'G' modifier is available since PHP 5.1.0
                case 'g':
                    $val = (int)$val * 1073741824;
                    break;
                case 'm':
                    $val = (int)$val * 1048576;
                    break;
                case 'k':
                    $val = (int)$val * 1024;
                    break;
            }

            return $val;
        }
    }

    // if value isn't a base 64 image, generate URL
    if($value && !preg_match('/^data\:image\//', $value)) {
        // make sure to append prefix once to value
        $value = Str::start($value, $field['prefix']);

        // generate URL
        $value = $field['disk']
            ? getDiskUrl($field['disk'], $value)
            : url($value);
    }

    $max_image_size_in_bytes = $field['max_file_size'] ?? (int)maximumServerUploadSizeInBytes();

    $field['wrapper'] = $field['wrapper'] ?? $field['wrapperAttributes'] ?? [];
    $field['wrapper']['class'] = $field['wrapper']['class'] ?? "form-group col-sm-12";
    $field['wrapper']['class'] = $field['wrapper']['class'].' cropperImage';
    $field['wrapper']['data-aspectRatio'] = $field['aspect_ratio'] ?? 0;
    $field['wrapper']['data-crop'] = $field['crop'] ?? false;
    $field['wrapper']['data-field-name'] = $field['wrapper']['data-field-name'] ?? $field['name'];
    $field['wrapper']['data-init-function'] = $field['wrapper']['data-init-function'] ?? 'bpFieldInitCropperImageElement';
@endphp

@include('crud::fields.inc.wrapper_start')
    <div>
        <label>{!! $field['label'] !!}</label>
        @include('crud::fields.inc.translatable_icon')
    </div>
    {{-- Wrap the image or canvas element with a block element (container) --}}
    <div class="row">
        <div class="col-sm-6" data-handle="previewArea" style="margin-bottom: 20px;">
            <img data-handle="mainImage" src="">
        </div>
        @if(isset($field['crop']) && $field['crop'])
        <div class="col-sm-3" data-handle="previewArea">
            <div class="docs-preview clearfix">
                <div class="img-preview preview-lg">
                    <img src="" style="display: block; min-width: 0px !important; min-height: 0px !important; max-width: none !important; max-height: none !important; margin-left: -32.875px; margin-top: -18.4922px; transform: none;">
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="btn-group">
        <div class="btn btn-light btn-sm btn-file">
            {{ trans('backpack::crud.choose_file') }} <input type="file" accept="image/*" data-handle="uploadImage"  @include('crud::fields.inc.attributes')>
            <input type="hidden" data-handle="hiddenImage" name="{{ $field['name'] }}" data-value-prefix="{{ $field['prefix'] }}" value="{{ $value }}">
        </div>
        @if(isset($field['crop']) && $field['crop'])
        <button class="btn btn-light btn-sm" data-handle="rotateLeft" type="button" style="display: none;"><i class="la la-rotate-left"></i></button>
        <button class="btn btn-light btn-sm" data-handle="rotateRight" type="button" style="display: none;"><i class="la la-rotate-right"></i></button>
        <button class="btn btn-light btn-sm" data-handle="zoomIn" type="button" style="display: none;"><i class="la la-search-plus"></i></button>
        <button class="btn btn-light btn-sm" data-handle="zoomOut" type="button" style="display: none;"><i class="la la-search-minus"></i></button>
        <button class="btn btn-light btn-sm" data-handle="reset" type="button" style="display: none;"><i class="la la-times"></i></button>
        @endif
        <button class="btn btn-light btn-sm" data-handle="remove" type="button"><i class="la la-trash"></i></button>
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

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')

    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <script src="{{ asset('packages/cropperjs/dist/cropper.min.js') }}"></script>
    <script src="{{ asset('packages/jquery-cropper/dist/jquery-cropper.min.js') }}"></script>
    @endpush
@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
