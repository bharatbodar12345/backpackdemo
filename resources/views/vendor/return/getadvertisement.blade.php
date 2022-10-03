@include('crud::fields.inc.wrapper_start')
@foreach ($advertisementdata as $key => $value)
    @switch($value->category_type)
        @case(2)
            <div class="form-group">
                <label class="form-check-label" for="exampleCheck1">Select : </label>
                <select name="attr_name" id="option">
                    @if(isset($value->attributesdata))
                        {{-- {{ dd($value->attributesdata[0]->attribute_name) }} --}}
                        @foreach ($value->attributesdata as $value_name)
                            <option value="">{{$value_name->attribute_name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        @break

         @case(1)
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
        @break
        @case(4)
            <div class="form-group">
                <label class="form-check-label" for="exampleCheck1">Text Box</label>
                <input type="text" class="form-control" id="text">
            </div>
        @break
        @case(5)
            <div class="form-group">
                <label class="form-check-label" for="exampleCheck1">Textarea</label>
                <input type="textarea" class="form-control" id="textarea">
            </div>
        @break
        @case(7)
            <div class="form-group">
                <label class="form-check-label" for="exampleCheck1">Date</label>
                <input type="date" class="form-control" id="textarea">
            </div>
        @break
        @case(6)
            <div class="mb-3">
                <label for="formFileSm" class="form-label">Image</label>
                <input class="form-control form-control-sm" id="formFileSm" type="file">
            </div>
        @break
        @case(3)
            <div class="mb-3">
                <label for="formFileSm" class="form-label">Image</label>
                <input class="form-control form-control-sm" id="formFileSm" type="file">
            </div>
        @break

            @default
            @endswitch


@endforeach
@include('crud::fields.inc.wrapper_end')

