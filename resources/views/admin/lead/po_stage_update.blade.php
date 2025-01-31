<div id="response-message"></div>
<form id="po_update" action="{{route('admin.lead.purchase_order.update')}}" method="POST" enctype="multipart/form-data"> @csrf
    <div class="row">

            @if($po_details->po_document)
                <div>
                    <a class="btn btn-secondary mb-3" href="{{asset(asset_path('upload/po/'.$po_details->po_document))}}" download><span class="m-3 text-warning"><i class="fas fa-download" title="Download P.O"></i> P.O. Download</span></a>
                </div>
            @endif

            <input type="hidden" name="lead_id" value="{{$po_details->lead_id}}">
            <input type="hidden" name="quotation_id" value="{{$po_details->quotation_id}}">
            <input type="hidden" name="po_id" value="{{$po_details->id}}">


            <div class="col-12">
                <label for="tax_percent">Tax Percentage <span class="text-danger">*</span></label>
                <select class="form-control" name="tax_percent" id="tax_percent" required>
                    <option value="0" @if($po_details->po_tax_percent == 0) {{'selected'}} @endif>0%</option>
                    <option value="12" @if($po_details->po_tax_percent == 12) {{'selected'}} @endif>12%</option>
                    <option value="18" @if($po_details->po_tax_percent == 18) {{'selected'}} @endif>18%</option>
                    <option value="28" @if($po_details->po_tax_percent == 28) {{'selected'}} @endif>28%</option>
                </select>
            </div>

            <div class="col-6 mt-3">
                <label for="gross_total">Gross Total <span class="text-danger">*</span></label>
                <input type="number" name="gross_total" id="gross_total" class="form-control" value="{{$po_details->po_gross_amount}}" required>
            </div>

            <div class="col-6 mt-3">
                <label for="order_no">Order No <span class="text-danger">*</span></label>
                <input type="text" name="order_no" id="order_no" class="form-control" value="{{$po_details->po_order_no}}" required>
            </div>

            <div class="col-6 mt-3">
                <label for="total_tax_amount">Total Tax Amount <span class="text-danger">*</span></label>
                <input type="text" name="total_tax_amount" id="total_tax_amount" class="form-control" value="{{$po_details->po_taxable}}" readonly>
            </div>
            <div class="col-6 mt-3">
                <label for="order_date">Order Date <span class="text-danger">*</span></label>
                <input type="date" name="order_date" id="order_date" class="form-control" value="{{$po_details->po_order_date}}" required>
            </div>
            <div class="col-6 mt-3">
                <label for="net_total">Net Total <span class="text-danger">*</span></label>
                <input type="text" name="net_total" id="net_total" class="form-control" value="{{$po_details->po_net_amount}}" required readonly>
            </div>
            <div class="col-6 mt-3">
                <label for="et_bill_no">ET Bill No <span class="text-danger">*</span></label>
                <input type="text" name="et_bill_no" id="et_bill_no" class="form-control" value="{{$po_details->po_et_bill_no}}" required>
            </div>
            <div class="col-6 mt-3">
                <label for="po_document">Upload P.O.</label>
                <input type="file" name="po_document" id="po_document" class="form-control dropify" data-max-file-size="3M" data-allowed-file-extensions="pdf png jpeg jpg doc docx">
            </div>
            <div class="col-6 mt-3">
                <label for="order_remark">Order Remarks (Dispatch / Pakaging / Payment / installation) <span class="text-danger">*</span></label>
                <textarea name="order_remark" id="order_remark" class="form-control" rows="4" required>{{$po_details->po_remarks}}</textarea>
            </div>
            <br>
            <br>

            <div class="col-12">
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Product</th>
                            <th>Estimated Delivery</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $key=>$order)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>
                                {{$order->order_product_name}} ({{$order->order_product_code}})
                                <input type="hidden" name="order_id[]" value="{{$order->id}}">
                            </td>
                            <td><input class="form-control" type="date" name="estimate_delivery_date[]" value="@if($order->order_product_delivery_date){{$order->order_product_delivery_date}}@else{{date('Y-m-d')}}@endif" required></td>
                            <td>
                                @if($order->status == 0)
							        <span class="badge badge-warning text-center">Pending</span>
                                @elseif($order->status == 1)
                                    <span class="badge badge-info text-center">Ready to Dispatch</span>
                                @elseif($order->status == 2)
                                    <span class="badge badge-success text-center">Delivered</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($lead->lead_stage_id != 9)
            <div class="col-12 mt-5">
                <button type="submit" class="btn btn-success float-right">Submit</button>
            </div>
            @endif
    </div>
</form>





