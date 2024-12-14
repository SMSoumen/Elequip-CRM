<div class="load_content">
    <div id="response-message"></div>
    <form id="po_add" action="{{route('admin.lead.purchase_order.create')}}" method="POST" enctype="multipart/form-data"> @csrf
        <div class="row">
                <input type="hidden" name="lead_id" value="{{$lead->id}}">
                <input type="hidden" name="quotation_id" value="{{$letest_quotation->id}}">
                <input type="hidden" name="lead_closure_date" value="{{$lead->lead_estimate_closure_date}}">

                <div class="col-12">
                    <label for="tax_percent">Tax Percentage <span class="text-danger">*</span></label>
                    <select class="form-control" name="tax_percent" id="tax_percent" required>
                        <option value="0">0%</option>
                        <option value="12">12%</option>
                        <option value="18">18%</option>
                        <option value="28">28%</option>
                    </select>
                </div>

                <div class="col-6 mt-3">
                    <label for="gross_total">Gross Total <span class="text-danger">*</span></label>
                    <input type="number" name="gross_total" id="gross_total" class="form-control" required>
                </div>

                <div class="col-6 mt-3">
                    <label for="order_no">Order No <span class="text-danger">*</span></label>
                    <input type="text" name="order_no" id="order_no" class="form-control" required>
                </div>

                <div class="col-6 mt-3">
                    <label for="total_tax_amount">Total Tax Amount <span class="text-danger">*</span></label>
                    <input type="text" name="total_tax_amount" id="total_tax_amount" class="form-control" readonly>
                </div>
                <div class="col-6 mt-3">
                    <label for="order_date">Order Date <span class="text-danger">*</span></label>
                    <input type="date" name="order_date" id="order_date" class="form-control" required>
                </div>
                <div class="col-6 mt-3">
                    <label for="net_total">Net Total <span class="text-danger">*</span></label>
                    <input type="text" name="net_total" id="net_total" class="form-control" required readonly>
                </div>
                <div class="col-6 mt-3">
                    <label for="et_bill_no">ET Bill No <span class="text-danger">*</span></label>
                    <input type="text" name="et_bill_no" id="et_bill_no" class="form-control" required>
                </div>
                <div class="col-6 mt-3">
                    <label for="po_document">Upload P.O.</label>
                    <input type="file" name="po_document" id="po_document" class="form-control dropify" data-max-file-size="3M" data-allowed-file-extensions="pdf png jpeg jpg doc docx">
                </div>

                <div class="col-6 mt-3">
                    <label for="order_remark">Order Remarks (Dispatch / Pakaging / Payment / installation) <span class="text-danger">*</span></label>
                    <textarea name="order_remark" id="order_remark" class="form-control" rows="4" required></textarea>
                </div>

                <div class="col-12 mt-5">
                    <button type="submit" class="btn btn-success float-right">Submit</button>
                </div>
        </div>
    </form>
</div>



