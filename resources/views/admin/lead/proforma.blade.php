<div id="response-message"></div>
<form id="po_update" action="{{route('admin.lead.add_proforma')}}" method="POST" enctype="multipart/form-data"> @csrf
    <div class="row">
            <div class="col-6">
                <label for="tax_type">Tax Type <span class="text-danger">*</span></label>
                <select class="form-control" name="tax_type" id="tax_type" required>
                    <option value="cgst+sgst">CGST+SGST</option>
                    <option value="igst">IGST</option>
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
                                        <th>Product Details</th>
                                        <th>Qty</th>
                                        <th>Rate</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>  
                                @foreach($letest_quotation_details as $quotation)
                                    @php
                                        $amount = $quotation->quot_product_unit_price * $quotation->quot_product_qty;
                                    @endphp
                                    <tr>
                                        <td>
                                            {{$quotation->quot_product_name}} ({{$quotation->quot_product_code}})
                                            <input type="hidden" name="product_id[]" value="{{$quotation->product_id}}">
                                            <input type="hidden" name="product_name[]" value="{{$quotation->quot_product_name}}">
                                            <input type="hidden" name="product_code[]" value="{{$quotation->quot_product_code}}">
                                            <input type="hidden" name="product_tech_spec[]" value="{{$quotation->quot_product_tech_spec}}">
                                        </td>
                                        <td><input type="number" name="qty[]" class="qty" value="{{$quotation->quot_product_qty}}" ></td>
                                        <td><input type="number" name="rate[]" class="rate" value="{{$quotation->quot_product_unit_price}}" ></td>
                                        <td><input type="text" name="amount[]" class="amount" value="{{$amount}}" readonly></td>
                                    </tr>
                                @endforeach
                                </tbody>
                    </table>
            </div>

            
            <div class="col-12 mt-5">
                <button type="submit" class="btn btn-success float-right">Submit</button>
            </div>
            
    </div>
</form>



