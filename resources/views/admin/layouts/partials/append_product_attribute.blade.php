<div class="row prod_attr-{{$attribute->attribute_slug}}" data-attr="{{$attribute->attribute_slug}}">
    <div class="col-md-2">{{$attribute->attribute_name}}</div>
    <div class="col-md-4">
        <div class="form-group">
            <div class="select2-purple">
                <select class="form-control form-control-sm select2 select2-{{$attribute->attribute_slug}}" name="prod_attr[{{$attribute->id}}][]" multiple>
                    @forelse($attribute->attribute_values as $pav)
                    <option value="{{$pav->id}}">{{$pav->attribute_value}}</option>
                    @empty
                    <option value="">No Attribute Value found</option>
                    @endforelse
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-check">
            <input class="form-check-input variation_check_{{$attribute->attribute_slug}}" type="checkbox" value="" name="variation_attr[{{$attribute->id}}]">
            <label class="form-check-label" for="variation_check">
                Used for variations
            </label>
        </div>
    </div>
</div>