<tr class="item-row-{{$product->id}}">
    <td class="prod_head product_q_sl_no"></td>
    <td>
        <p class="prod_head">{{$product->product_name}} ({{$product->product_code}})</p>
        <textarea class="mt-3 product_tech_spec_textarea" name="product_tech_spec[]">{!! ($product->product_tech_spec) !!}</textarea>

        <input type="hidden" name="product_name[]" value="{{$product->product_name}}">
        <input type="hidden" name="product_code[]" value="{{$product->product_code}}">
        <input type="hidden" name="product_unit[]" value="{{$product->unit_type}}">
    </td>
    <td>
        <div class="input-group mb-3">
            <input type="number" name="qty[]"
                class="qty form-control"
                value="1.00"
                placeholder="Quantity">
            <div class="input-group-append">
                <span class="input-group-text"
                    id="basic-addon2">{{ $product->unit_type }}</span>
            </div>
        </div>
        {{-- <input type="number" name="qty[]" class="qty mt-5" value="1" > --}}
    </td>
    <td><input type="number" name="rate[]" class="rate form-control" value="{{$product->product_price}}" ></td>
    <td>
        <p class="text-right amount_p">
            <i class="fas fa-rupee-sign"></i>
            <span class="pro_price_span amount">
                <?= sprintf('%.2f', $product->product_price) ?>
            </span>
        </p>
        <input type="hidden" name="amount[]" class="amount_input form-control" value="{{ $product->product_price }}">
    </td>
</tr>
<tr class="item-row-{{$product->id}}">
    <td class="border-0"></td>
    <td class="border-0 pt-0" colspan="4">
        <textarea class="mt-3 product_tech_spec_textarea" name="product_m_spec[]" >{!! $product->product_m_spec !!}</textarea>
    </td>
</tr>