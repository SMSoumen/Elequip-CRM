<tr class="item-row-{{$product->id}}">
    <td><span class="product_sl_no"></span></td>
    <td><input type="hidden" name="product_ids[]" value="{{$product->id}}">
        <div class="">{{$product->product_name}}</div>
        <div class="product_tech_spec p-1 mt-1" readonly>{!! htmlspecialchars_decode($product->product_tech_spec) !!}</div></td>
    <td><input type="number" name="qty[]" class="qty" value="1"> <span class="badge bg-secondary ml-1">{{$product->unit_type}}</span></td>
    <td>
        <input type="hidden" class="single_amount" value="{{$product->product_price}}">
        <input type="number" name="amount[]" class="amount" value="{{$product->product_price}}" readonly>
    </td>
</tr>