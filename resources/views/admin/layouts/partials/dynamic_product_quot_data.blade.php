<tr class="item-row-{{$product->id}}">
    <td class="prod_head product_q_sl_no"></td>
    <td>
        <p class="prod_head">{{$product->product_name}} ({{$product->product_code}})</p>
        <textarea class="mt-3 product_tech_spec_textarea" readonly>{!! ($product->product_tech_spec) !!}</textarea>

        <input type="hidden" name="product_name[]" value="{{$product->product_name}}">
        <input type="hidden" name="product_code[]" value="{{$product->product_code}}">
        <input type="hidden" name="product_unit[]" value="{{$product->product_unit}}">
        <input type="hidden" name="product_tech_spec[]" value="{{$product->product_tech_spec}}">
        <input type="hidden" name="product_m_spec[]" value="{{$product->product_m_spec}}">
    </td>
    <td><input type="number" name="qty[]" class="qty mt-5" value="1" ></td>
    <td><input type="number" name="rate[]" class="rate mt-5" value="{{$product->product_price}}" ></td>
    <td>
        <p class="text-right amount_p  mt-5">
            <i class="fas fa-rupee-sign"></i>
            <span class="pro_price_span amount">
                <?= sprintf('%.2f', $product->product_price) ?>
            </span>
        </p>
    </td>
</tr>
<tr class="item-row-{{$product->id}}">
    <td class="border-0"></td>
    <td class="border-0 pt-0" colspan="4">
        <textarea class="mt-3 product_tech_spec_textarea" readonly>{!! $product->product_m_spec !!}</textarea>
    </td>
</tr>