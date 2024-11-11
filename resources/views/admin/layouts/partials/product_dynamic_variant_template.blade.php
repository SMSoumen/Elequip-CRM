<div class="var_box border p-2 mt-2  bg-dark">
    <h6>Variation Box</h6>
    <div class="row">
        @forelse($attr_names as $key => $atr_name)
        <div class="col-md-2">
            <div class="form-group">
                <label>Select {{$atr_name}}</label>
                <select name="product_variant_attr[{{$variation_counter}}][{{$key}}]" class="form-control form-control-sm">
                    <option value="">Any {{$atr_name}}</option>
                    @forelse($attr_values[$key] as $j => $atr_val)
                    <option value="{{$atr_val[1]}}">{{$atr_val[0]}}</option>
                    @empty
                    @endforelse
                </select>
            </div>
        </div>
        @empty
        @endforelse

    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label>Description</label>
                <textarea name="product_variant_desc[]" cols="30" rows="2" class="form-control form-control-sm product_variant_desc" placeholder="Enter desc"></textarea>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="feature_image">Image</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input form-control form-control-sm product_variant_img" name="product_variant_img[]">
                        <label class="custom-file-label" for="feature_image">Choose file</label>
                    </div>
                    <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label>Product SKU</label>
                <input type="text" class="form-control form-control-sm product_variant_sku" name="product_variant_sku[]" placeholder="Enter SKU">
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label>Product HSN</label>
                <input type="text" class="form-control form-control-sm product_variant_sku" name="product_variant_hsn[]" placeholder="Enter HSN">
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label>Product Price</label>
                <input type="text" required class="form-control form-control-sm product_variant_price" name="product_variant_price[]" placeholder="Enter Price">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Product Sale Price</label>
                <input type="text" class="form-control form-control-sm product_variant_sale_price" name="product_variant_sale_price[]" placeholder="Enter Sale Price">
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label>Sale Start Time</label>
                <input type="datetime" class="form-control form-control-sm product_variant_sale_start" name="product_variant_sale_start[]" placeholder="Sale Start Time">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Sale End Time</label>
                <input type="datetime" class="form-control form-control-sm product_variant_sale_end" name="product_variant_sale_end[]" placeholder="Sale End Time">
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label>Sale Stock Qty</label>
                <input type="text" class="form-control form-control-sm product_variant_stock_qty" name="product_variant_stock_qty[]" placeholder="Stock Qty">
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label>Sale Stock Threshold</label>
                <input type="text" class="form-control form-control-sm product_variant_stock_threshold" name="product_variant_stock_threshold[]" placeholder="Stock Threshold">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Sale Stock Status</label>
                <select class="form-control form-control-sm" name="product_variant_stock_status[]">
                    <option value="1">In Stock</option>
                    <option value="0">Out of Stock</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Shipping Length</label>
                <input type="text" class="form-control form-control-sm product_variant_shipping_length" name="product_variant_shipping_length[]" placeholder="Shipping Length">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Shipping Width</label>
                <input type="text" class="form-control form-control-sm product_variant_shipping_width" name="product_variant_shipping_width[]" placeholder="Shipping Width">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Shipping Height</label>
                <input type="text" class="form-control form-control-sm product_variant_shipping_height" name="product_variant_shipping_height[]" placeholder="Shipping Height">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Shipping Weight</label>
                <input type="text" class="form-control form-control-sm product_variant_shipping_weight" name="product_variant_shipping_weight[]" placeholder="Shipping Weight">
            </div>
        </div>


    </div>
</div>