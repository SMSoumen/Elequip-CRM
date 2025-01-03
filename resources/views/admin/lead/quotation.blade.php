<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <!-- Timelime example  -->
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('admin.lead.quotation_store')}}" method="post">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="lead_id" value="{{$lead->id}}">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="quotation_remarks">Quotation Remarks <span class="text-danger"> *</span></label>
                                <textarea class="form-control" name="quotation_remarks" id="quotation_remarks" rows="4" required></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="enquiry_ref">Enquiry Ref <span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" id="enquiry_ref" name="enquiry_ref" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="product_id">Select Products <span class="text-danger"> *</span></label>
                                <select name="product_id[]" id="product_id2" class="form-control product_select_quot" multiple required>
                                    @foreach($products as $product)
                                    <option value="{{$product->id}}"
                                    @foreach($lead_details as $lead_product)
                                    @if($product->id == $lead_product->product_id) {{'selected'}} @endif 
                                    @endforeach >{{$product->product_name}} ({{ $product->product_code }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <table class="table" id="myTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Details</th>
                                        <th style="width:15%">Qty</th>
                                        <th style="width:20%">Rate</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="load_quot_table">  
                                    @php
                                        $total = 0.00;
                                    @endphp
                                @foreach($lead_details as $k => $lead_product)
                                    @php
                                        $amount = $lead_product->lead_product_price * $lead_product->lead_product_qty;
                                        $total += $amount;
                                    @endphp
                                    <tr>
                                        <td class="prod_head product_q_sl_no">{{$k + 1}}</td>
                                        <td>
                                            <p class="prod_head">{{$lead_product->lead_product_name}} ({{$lead_product->lead_product_code}})</p>
                                            <textarea name="product_tech_spec[]" class="mt-3 product_tech_spec_textarea" readonly>{!! $lead_product->lead_product_tech_spec !!}</textarea>

                                            <input type="hidden" name="product_name[]" value="{{$lead_product->lead_product_name}}">
                                            <input type="hidden" name="product_code[]" value="{{$lead_product->lead_product_code}}">
                                            <input type="hidden" name="product_unit[]" value="{{$lead_product->lead_product_unit}}">
                                            {{-- <input type="hidden"  value="{{$lead_product->lead_product_tech_spec}}"> --}}
                                            {{-- <input type="hidden"  value="{{$lead_product->lead_product_m_spec}}"> --}}
                                        </td>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input type="number" name="qty[]"
                                                    class="qty form-control"
                                                    value="{{ $lead_product->lead_product_qty }}"
                                                    placeholder="Quantity">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"
                                                        id="basic-addon2">{{ $lead_product->lead_product_unit }}</span>
                                                </div>
                                            </div>
                                            {{-- <input type="number" name="qty[]" class="qty mt-5" value="{{$lead_product->lead_product_qty}}" > --}}
                                        </td>
                                        <td><input type="number" name="rate[]" class="rate form-control" value="{{$lead_product->lead_product_price}}" ></td>
                                        <td>
                                            <p class="text-right amount_p ">
                                                <i class="fas fa-rupee-sign"></i>
                                                <span class="pro_price_span amount">
                                                    <?= sprintf('%.2f', $amount) ?>
                                                </span>
                                            </p>                                          
                                            {{-- <input type="text" name="amount[]" class="amount mt-5 input-orange-elequip" value="{{$amount}}" readonly> --}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-0"></td>
                                        <td class="border-0 pt-0" colspan="4">
                                            <textarea class="mt-3 product_tech_spec_textarea" name="product_m_spec[]">{!! $lead_product->lead_product_m_spec !!}</textarea>
                                        </td>
                                    </tr>
                                @endforeach                                
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right" style="vertical-align: middle;">
                                           <b>Basic Total = </b> 
                                        </td>
                                        <td  style="vertical-align: middle;">
                                            <p class="text-right amount_p" id="basic_total" >
                                                <i class="fas fa-rupee-sign"></i> <b id="total_amount">{{$total}}</b>
                                            </p>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>


                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-5">Terms & Conditions</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="discount">Discount</label>
                                <input type="text" class="form-control" id="discount" name="discount" placeholder="Enter Discount">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="tax">Tax</label>
                                <input type="text" class="form-control" id="tax" name="tax" value="GST 18% EXTRA" placeholder="GST 18% EXTRA">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="basis">Basis</label>
                                <input type="text" class="form-control" id="basis" name="basis" value="F.O.R Kolkata" placeholder="F.O.R Kolkata">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="payment">Payment</label>
                                <input type="text" class="form-control" id="payment" name="payment" placeholder="100% against proforma invoice" value="100% against proforma invoice">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="delivery">Delivery</label>
                                <input type="text" class="form-control" id="delivery" name="delivery" value="2 days of PO" placeholder="2 days of PO">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="freight_forwarding">Freight & Forwarding</label>
                                <input type="text" class="form-control" id="freight_forwarding" name="freight_forwarding" value="2% Extra on basic price" placeholder="2% Extra on basic price">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="validity">Validity</label>
                                <input type="text" class="form-control" id="validity" name="validity" value="Offers remains valid for 30 days from the date of hereof.">
                            </div>
                        </div>
                    

                        <div class="col-6">
                            <div class="form-group">
                                <label for="warranty">Warranty</label>
                                <input type="text" class="form-control" id="warranty" name="warranty" value="12 months from the date of supply" placeholder="12 months from the date of supply">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="note_1">Note 1</label>
                                <input type="text" class="form-control" id="note_1" name="note_1" placeholder="Enter First Note">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="note_2">Note 2</label>
                                <input type="text" class="form-control" id="note_2" name="note_2" placeholder="Enter Second Note">
                            </div>
                        </div>

                        <div class="col-12">
                           <button class="btn btn-success float-right mt-5" type="submit">Preview & Next</button>
                        </div>
                    </div>

                </form>
            </div>
            <!-- /.col -->
        </div>
    </div>
    <!-- /.timeline -->

</section>
<!-- /.content -->
