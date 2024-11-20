<div class="row">
    <input type="hidden" name="lead_id" value="{{$lead->id}}">
    <div class="col-12">
        <label for="remarks">Remarks</label>
        <textarea class="form-control" name="remarks" id="remarks" rows="4">{{$lead->lead_remarks}}</textarea>
    </div>

    <div class="col-6 mt-3">
        <label for="company_id">Company Name <span class="text-danger"> *</span></label>
        <select name="company_id" id="company_id" class="form-control" disabled>
                <option value="">Select Company</option>
                @foreach($companies as $company)
                <option value="{{$company->id}}" @if($lead->company_id == $company->id) {{'selected'}} @endif>{{$company->company_name}}</option>
                @endforeach
        </select>
    </div>

    <div class="col-6 mt-3">
        <label for="lead_source_id">Source of Lead <span class="text-danger"> *</span></label>
        <select name="lead_source_id" id="lead_source_id" class="form-control" disabled>
            <option value="">Select Lead Source</option>
            @foreach($sources as $source)
            <option value="{{$source->id}}" @if($lead->lead_source_id == $source->id) {{'selected'}} @endif>{{$source->source_name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-6 mt-3">
        <label for="customer_id">Select Customer <span class="text-danger"> *</span></label>
        <select name="customer_id" id="customer_id" class="form-control" disabled>
            <option value="">Select Customer</option>
            @foreach($customers as $customer)
            <option value="{{$customer->id}}" @if($lead->customer_id == $customer->id) {{'selected'}} @endif>{{$customer->customer_name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-6 mt-3">
        <label for="lead_category_id">Lead Category <span class="text-danger"> *</span></label>
        <select name="lead_category_id" id="lead_category_id" class="form-control" required>
            <option value="">Select Category</option>
            @foreach($categories as $category)
            <option value="{{$category->id}}" @if($lead->lead_category_id == $category->id) {{'selected'}} @endif>{{$category->category_name}}</option>
            @endforeach
        </select>
    </div>   
    
    <div class="col-6 mt-3">
        <label for="lead_estimate_closure_date">Estimate Closure Date<span class="text-danger"> *</span></label>
        <input type="date" name="lead_estimate_closure_date" id="lead_estimate_closure_date" class="form-control" value="{{ $lead->lead_estimate_closure_date }}" required>
    </div>
    <div class="col-6 mt-3">
        <label for="followup_next_date">Next Follow-up Date<span class="text-danger"> *</span></label>
        <input type="date" name="followup_next_date" id="followup_next_date" class="form-control" value="{{$fllowup_date->followup_next_date}}" required>
    </div>

    <div class="col-6 mt-3">
        <label for="lead_stage_id">Update Lead Stage <span class="text-danger"> *</span></label>
        <select name="lead_stage_id" id="lead_stage_id" class="form-control">
            <option value="">Select Lead Stage</option>
            @foreach($stages as $stage)
            <option value="{{$stage->id}}" 
                 @if($lead->lead_stage_id == $stage->id) {{'selected'}} @endif
                 @if($stage->id != '2') {{'disabled'}} @endif >{{$stage->stage_name}}</option>
            @endforeach
        </select>
    </div>  

    <div class="col-12 mt-3">
        <label for="product_id">Select Products <span class="text-danger"> *</span></label>
        <select name="product_id[]" id="product_id1" class="form-control product_select_details" multiple disabled>
            <!-- <option value="">Select Product</option> -->
            @foreach($products as $product)
                <option value="{{$product->id}}"
                @foreach($lead_details as $lead_product)
                  @if($product->id == $lead_product->product_id) {{'selected'}} @endif 
                @endforeach >{{$product->product_name}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-12 mt-3">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th>Product Details</th>
                    <th>Qty</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>  
            @foreach($lead_details as $lead_product)
                <tr>
                    <td>{{$lead_product->lead_product_name}} ({{$lead_product->lead_product_code}})</td>
                    <td><input type="text" name="qty[]" class="qty" value="{{$lead_product->lead_product_qty}}" disabled></td>
                    <td><input type="text" name="amount[]" class="amount" value="{{$lead_product->lead_product_price}}" disabled></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="col-12 mt-5">
        <button type="submit" class="btn btn-success float-right">Submit</button>
    </div>

</div>

