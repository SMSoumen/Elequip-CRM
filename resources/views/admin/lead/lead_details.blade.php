<div class="row">
    <input type="hidden" name="lead_id" value="{{ $lead->id }}">
    <div class="col-12">
        <label for="remarks">Remarks</label>
        <textarea class="form-control" name="remarks" id="remarks" rows="4">{{ $lead->lead_remarks }}</textarea>
    </div>

    <div class="col-6 mt-3">
        <label for="company_id">Company Name</label>
        <select name="company_id" id="company_id" class="form-control" disabled>
            <option value="">Select Company</option>
            @foreach ($companies as $company)
                <option value="{{ $company->id }}" @if ($lead->company_id == $company->id) {{ 'selected' }} @endif>
                    {{ $company->company_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-6 mt-3">
        <label class="text-custom" for="lead_category_id">Lead Category <span> *</span></label>
        <select name="lead_category_id" id="lead_category_id" class="form-control" required>
            <option value="">Select Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @if ($lead->lead_category_id == $category->id) {{ 'selected' }} @endif>
                    {{ $category->category_name }}</option>
            @endforeach
        </select>
    </div>


    <div class="col-6 mt-3">
        <label for="customer_id">Select Customer</label>
        <select name="customer_id" id="customer_id" class="form-control" disabled>
            <option value="">Select Customer</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}" @if ($lead->customer_id == $customer->id) {{ 'selected' }} @endif>
                    {{ $customer->customer_name }}</option>
            @endforeach
        </select>
    </div>


    <div class="col-6 mt-3">
        <label class="text-custom" for="lead_estimate_closure_date">Estimate Closure Date<span> *</span></label>
        <input type="date" name="lead_estimate_closure_date" id="lead_estimate_closure_date" class="form-control"
            value="{{ $lead->lead_estimate_closure_date }}" required>
    </div>

    <div class="col-6 mt-3">
        <label for="lead_source_id">Source of Lead</label>
        <select name="lead_source_id" id="lead_source_id" class="form-control" disabled>
            <option value="">Select Lead Source</option>
            @foreach ($sources as $source)
                <option value="{{ $source->id }}" @if ($lead->lead_source_id == $source->id) {{ 'selected' }} @endif>
                    {{ $source->source_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-6 mt-3">
        <label class="text-custom" for="followup_next_date">Next Follow-up Date<span> *</span></label>
        <input type="date" name="followup_next_date" id="followup_next_date" class="form-control"
            value="{{ $followup_date }}" required>
    </div>

    <div class="col-6 mt-3">
        <label for="product_id">Select Products</label>
        <select name="product_id[]" id="product_id1" class="form-control product_select_details" multiple disabled>
            @foreach ($products as $product)
                <option value="{{ $product->id }}"
                    @foreach ($lead_details as $lead_product)
                  @if ($product->id == $lead_product->product_id) {{ 'selected' }} @endif @endforeach>
                    {{ $product->product_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-6 mt-3">
        <label class="text-custom" for="lead_stage_id">Update Lead Stage <span> *</span></label>
        <select name="lead_stage_id" id="lead_stage_id" class="form-control" @if($lead->lead_stage_id == 2) disabled  @endif>
            <option value="">Select Lead Stage</option>
            @foreach ($stages as $stage)
                <option value="{{ $stage->id }}" @if ($lead->lead_stage_id == $stage->id) {{ 'selected' }} @endif
                    @if ($stage->id != '2') {{ 'disabled' }} @endif>{{ $stage->stage_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-12 mt-5">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Details</th>
                    <th>Qty</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lead_details as $k => $lead_product)
                    <tr>
                        <td>{{ $k + 1 }}</td>
                        <td>
                            <div>{{ $lead_product->lead_product_name }} ({{ $lead_product->lead_product_code }})</div>
                            <div class="product_tech_spec p-1 mt-1 mb-2">
                                {!! htmlspecialchars_decode($lead_product->lead_product_m_spec) !!}
                            </div>
                            <div class="product_tech_spec p-1 mt-3">
                                {!! htmlspecialchars_decode($lead_product->lead_product_tech_spec) !!}
                            </div>

                        </td>
                        <td>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="qty[]" value="{{ $lead_product->lead_product_qty }}" disabled>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">{{ $lead_product->lead_product_unit }}</span>
                                </div>
                            </div>
                            {{-- <input type="text" name="qty[]" class="mt-5"
                                value="{{ $lead_product->lead_product_qty }}" disabled> AA --}}
                        </td>
                        <td><input type="text" name="amount[]" class="form-control input-orange-elequip pl-1"
                                value="₹{{ $lead_product->lead_product_price }}" disabled></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="col-12 mt-5">
        <button type="submit" class="btn btn-success float-right">Submit</button>
    </div>

    <div class="col-12 mt-5">
        <div class="alert alert-custom" role="alert">
            Orange represents editable until account closure & lead status editable before P.O. generation
        </div>
    </div>

</div>
