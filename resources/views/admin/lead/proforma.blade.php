<div id="response-message"></div>
<form id="po_update" action="{{ route('admin.lead.add_proforma') }}" method="POST" enctype="multipart/form-data"> @csrf
    <div class="row">

        <input type="hidden" name="lead_id" value="{{ $po_details->lead_id }}">
        <input type="hidden" name="po_id" value="{{ $po_details->id }}">

        <div class="col-6">
            <label for="tax_type">Tax Type <span class="text-danger">*</span></label>
            <select class="form-control" name="tax_type" id="tax_type" required>
                <option value="1">CGST+SGST</option>
                <option value="2">IGST</option>
            </select>
        </div>

        <div class="col-6">
            <label for="dispatch">Dispatch<span class="text-danger">*</span></label>
            <input type="text" name="dispatch" id="dispatch" class="form-control" value="" required>
        </div>

        <div class="col-12 mt-3">
            <label for="proforma_remark">Proforma Remarks <span class="text-danger">*</span></label>
            <textarea name="proforma_remark" id="proforma_remark" class="form-control" required></textarea>
        </div>

        <div class="col-12 mt-3">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th style="width:3%;">#</th>
                        <th style="width:48%">Product Details</th>
                        <th style="width:15%">Qty</th>
                        <th style="width:15%">Rate</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>

                    @php $total_amount = 0; @endphp
                    @foreach ($letest_quotation_details as $key => $quotation)
                        @php
                            $amount = $quotation->quot_product_unit_price * $quotation->quot_product_qty;
                            $total_amount = $total_amount + $amount;
                        @endphp
                        <tr>
                            <td class="prod_head">{{ $key + 1 }}</td>
                            <td>
                                <p class="prod_head">{{ $quotation->quot_product_name }} ({{ $quotation->quot_product_code }})</p>
                                 <br>
                                <textarea name="product_tech_spec[]" class="product_tech_spec_textarea">
                                    {{ $quotation->quot_product_tech_spec }}
                                </textarea>
                                <input type="hidden" name="product_id[]" value="{{ $quotation->product_id }}">
                                <input type="hidden" name="product_name[]" value="{{ $quotation->quot_product_name }}">
                                <input type="hidden" name="product_code[]" value="{{ $quotation->quot_product_code }}">
                                <input type="hidden" name="product_unit[]" value="{{ $quotation->quot_product_unit }}">
                            </td>
                            <td>
                                <div class="input-group mb-3">
                                    <input type="number" name="qty[]"
                                        class="qty form-control"
                                        value="{{ $quotation->quot_product_qty }}"
                                        placeholder="Quantity">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                            id="basic-addon2-{{ $key + 1 }}">{{ $quotation->quot_product_unit }}</span>
                                    </div>
                                </div>

                                {{-- <input type="number" name="qty[]" class="qty"
                                    value="{{ $quotation->quot_product_qty }}"> --}}
                                </td>
                            <td><input type="number" name="rate[]" class="rate form-control"
                                    value="{{ $quotation->quot_product_unit_price }}"></td>
                            <td>
                                <p class="text-right amount_p ">
                                    <i class="fas fa-rupee-sign"></i>
                                    <span class="pro_price_span amount">
                                        <?= sprintf('%.2f', $amount) ?>
                                    </span>
                                </p>
                                {{-- <input type="text" name="amount[]" class="amount form-control" value="{{ $amount }}"
                                    readonly> --}}
                                </td>
                        </tr>
                    @endforeach                    
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="4" align="right" style="vertical-align: middle;">
                            <b><span >Basic Total =</span></b>
                        </td>
                        <td colspan="1" style="vertical-align: middle;">
                            <p class="text-right amount_p mt-3" id="basic_total">
                                <i class="fas fa-rupee-sign"></i> <b
                                    id="total_amount">{{ $total_amount }}</b>
                            </p>
                            {{-- <div class="input-group">                                
                                <input type="text" id="basic_amount"  value="Rs. {{ $total_amount }}" readonly>
                            </div> --}}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>


        <div class="col-12 mt-5">
            <button type="submit" class="btn btn-success float-right">Submit</button>
        </div>

    </div>
</form>

