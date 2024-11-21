<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <!-- Timelime example  -->
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post">
                    <div class="row">
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
                                <select name="product_id[]" id="product_id1" class="form-control product_select_quot" multiple required>
                                    @foreach($products as $product)
                                    <option value="{{$product->id}}">{{$product->product_name}}</option>
                                    @endforeach
                                </select>
                            </div>
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
                                <label for="enquiry_ref">Delivery</label>
                                <input type="text" class="form-control" id="enquiry_ref" name="enquiry_ref" value="2 days of PO" placeholder="2 days of PO">
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
