@extends('admin.layouts.master')
@section('main_content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Edit Quotation</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="{{route('admin.lead.quotation.update')}}" method="post">@csrf
                                        <div class="row">
                                            <input type="hidden" name="quotation_id" value="{{$quotation->id}}">
                                            <input type="hidden" name="lead_id" value="{{$quotation->lead_id}}">
                                            <input type="hidden" name="quot_version" value="{{$quotation->quot_version}}">

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="quotation_remarks">Quotation Remarks <span class="text-danger"> *</span></label>
                                                    <textarea class="form-control" name="quotation_remarks" id="quotation_remarks" rows="4" required>{{$quotation->quot_remarks}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="enquiry_ref">Enquiry Ref <span class="text-danger"> *</span></label>
                                                    <input type="text" class="form-control" id="enquiry_ref" name="enquiry_ref" required value="{{$quotation->quot_user_ref_no}}">
                                                </div>
                                            </div>
                                       
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="product_id">Select Products <span class="text-danger"> *</span></label>
                                                    <select name="product_id[]" id="product_id" class="form-control product_select_quot" multiple required>
                                                        @foreach($products as $product)
                                                        <option value="{{$product->id}}"
                                                            @foreach($quotation_details as $quotation)
                                                            @if($product->id == $quotation->product_id) {{'selected'}} @endif 
                                                            @endforeach >{{$product->product_name}}
                                                       </option>
                                                        @endforeach
                                                    </select>
                                                </div>
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
                                                    @foreach($quotation_details as $quotation)
                                                        @php
                                                            $amount = $quotation->quot_product_unit_price * $quotation->quot_product_qty;
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                {{$quotation->quot_product_name}} ({{$quotation->quot_product_code}})
                                                                <input type="hidden" name="product_name[]" value="{{$quotation->quot_product_name}}">
                                                                <input type="hidden" name="product_code[]" value="{{$quotation->quot_product_code}}">
                                                                <input type="hidden" name="product_unit[]" value="{{$quotation->quot_product_unit}}">
                                                                <input type="hidden" name="product_tech_spec[]" value="{{$quotation->quot_product_tech_spec}}">
                                                                <input type="hidden" name="product_m_spec[]" value="{{$quotation->quot_product_m_spec}}">
                                                            </td>
                                                            <td><input type="number" name="qty[]" class="qty" value="{{$quotation->quot_product_qty}}" ></td>
                                                            <td><input type="number" name="rate[]" class="rate" value="{{$quotation->quot_product_unit_price}}" ></td>
                                                            <td><input type="text" name="amount[]" class="amount" value="{{$amount}}" readonly></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
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
                                                    <input type="text" class="form-control" id="discount" name="discount" placeholder="Enter Discount" value="{{$quotation_terms->term_discount}}">
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="tax">Tax</label>
                                                    <input type="text" class="form-control" id="tax" name="tax" value="{{$quotation_terms->term_tax}}" placeholder="GST 18% EXTRA">
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="basis">Basis</label>
                                                    <input type="text" class="form-control" id="basis" name="basis" value="{{$quotation_terms->term_price}}" placeholder="F.O.R Kolkata">
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="payment">Payment</label>
                                                    <input type="text" class="form-control" id="payment" name="payment" placeholder="100% against proforma invoice" value="{{$quotation_terms->term_payment}}">
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="delivery">Delivery</label>
                                                    <input type="text" class="form-control" id="delivery" name="delivery" value="{{$quotation_terms->term_dispatch}}" placeholder="2 days of PO">
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="freight_forwarding">Freight & Forwarding</label>
                                                    <input type="text" class="form-control" id="freight_forwarding" name="freight_forwarding" value="{{$quotation_terms->term_forwarding}}" placeholder="2% Extra on basic price">
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="validity">Validity</label>
                                                    <input type="text" class="form-control" id="validity" name="validity" value="{{$quotation_terms->term_validity}}">
                                                </div>
                                            </div>
                                        

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="warranty">Warranty</label>
                                                    <input type="text" class="form-control" id="warranty" name="warranty" placeholder="12 months from the date of supply" value="{{$quotation_terms->term_warranty}}">
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="note_1">Note 1</label>
                                                    <input type="text" class="form-control" id="note_1" name="note_1" value="{{$quotation_terms->term_note_1}}">
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="note_2">Note 2</label>
                                                    <input type="text" class="form-control" id="note_2" name="note_2" value="{{$quotation_terms->term_note_2}}">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                            <button class="btn btn-success float-right mt-5" type="submit">Save</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <!-- /.col -->
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')

<script>

$(document).ready(function() {
        $('#product_id').select2({
            placeholder: "Select Product",
            allowClear: true,
        });
        changeAmount();   
 

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


                    $('#product_id').on('select2:select', function (e) {
                        const selectedData = e.params.data;
                        var last_product_id = selectedData.id;
                        // console.log(last_product_id);
                        $.ajax({
                            type:'post',
                            url:"{{route('admin.product-details')}}",
                            data:{"product_id":last_product_id},
                            success:function(res){
                                 console.log(res);
                                var i=0;
                                var tr='';                                       
                                for(i=0;i<res.length;i++){
                                var tr = tr + `<tr>
                                            <td>
                                                `+res[i].product_name+`(`+res[i].product_code+`)
                                                <input type="hidden" name="product_name[]" value="`+res[i].product_name+`">
                                                <input type="hidden" name="product_code[]" value="`+res[i].product_code+`">
                                                <input type="hidden" name="product_unit[]" value="`+res[i].unit_type+`">
                                                <input type="hidden" name="product_tech_spec[]" value="`+res[i].product_tech_spec+`">
                                                <input type="hidden" name="product_m_spec[]" value="`+res[i].product_marketing_spec+`">
                                            </td>
                                            <td><input type="number" name="qty[]" class="qty" value="1"></td>
                                            <td><input type="number" name="rate[]" class="rate" value="`+res[i].product_price+`"></td>

                                            <td>
                                                <input type="text" name="amount[]" class="amount" value="`+res[i].product_price+`" readonly>
                                            </td>
                                        </tr>`;
                                }
                                $("tbody").append(tr);
                                 changeAmount();
                            }
                        })  
                    });

                    function changeAmount(){
                        $(".qty").keyup(function(){
                            var quantity = $(this).val();
                            var amount = $(this).closest('tr').find('.rate').val();
                            var total_amount = quantity * amount; 
                            if (isNaN(total_amount)) {
                                $(this).closest('tr').find('.amount').val(0);
                            }
                            else{
                                $(this).closest('tr').find('.amount').val(total_amount);
                            }
                        });
                    }


});
                                    </script>


@endpush





