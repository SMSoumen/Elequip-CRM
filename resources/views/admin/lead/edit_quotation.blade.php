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
                                    <form action="{{ route('admin.lead.quotation.update') }}" method="post">@csrf
                                        <div class="row">
                                            <input type="hidden" name="quotation_id" value="{{ $quotation->id }}">
                                            <input type="hidden" name="lead_id" value="{{ $quotation->lead_id }}">
                                            <input type="hidden" name="quot_version"
                                                value="{{ $quotation->quot_version }}">

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="quotation_remarks">Quotation Remarks <span
                                                            class="text-danger"> *</span></label>
                                                    <textarea class="form-control" name="quotation_remarks" id="quotation_remarks" rows="4" required>{{ $quotation->quot_remarks }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="enquiry_ref">Enquiry Ref <span class="text-danger">
                                                            *</span></label>
                                                    <input type="text" class="form-control" id="enquiry_ref"
                                                        name="enquiry_ref" required
                                                        value="{{ $quotation->quot_user_ref_no }}">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="product_id">Select Products <span class="text-danger">
                                                            *</span></label>
                                                    <br>
                                                    <select name="product_id[]" id="product_id"
                                                        class="form-control product_select_quot" multiple required>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                @foreach ($quotation_details as $quotation)
                                                            @if ($product->id == $quotation->product_id) {{ 'selected' }} @endif @endforeach>
                                                                {{ $product->product_name }} ({{ $product->product_code }})
                                                            </option>
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
                                                    <tbody id="load_table">
                                                        @php
                                                            $total = 0.0;
                                                        @endphp
                                                        @foreach ($quotation_details as $k => $quotation)
                                                            @php
                                                                $amount =
                                                                    $quotation->quot_product_unit_price *
                                                                    $quotation->quot_product_qty;

                                                                $total += $amount;
                                                            @endphp
                                                            <tr class="item-row-{{ $quotation->product_id }}">
                                                                <td class="prod_head product_q_sl_no">{{ $k + 1 }}
                                                                </td>
                                                                <td>
                                                                    <p class="prod_head">
                                                                        {{ $quotation->quot_product_name }}
                                                                        ({{ $quotation->quot_product_code }})
                                                                    </p>

                                                                    <textarea class="mt-3 product_tech_spec_textarea"  name="product_tech_spec[]">{!! $quotation->quot_product_tech_spec !!}</textarea>
                                                                    <input type="hidden" name="product_name[]"
                                                                        value="{{ $quotation->quot_product_name }}">
                                                                    <input type="hidden" name="product_code[]"
                                                                        value="{{ $quotation->quot_product_code }}">
                                                                    <input type="hidden" name="product_unit[]"
                                                                        value="{{ $quotation->quot_product_unit }}">
                                                                    {{-- <input type="hidden"
                                                                        value="{{ $quotation->quot_product_tech_spec }}">
                                                                    <input type="hidden"
                                                                        value="{{ $quotation->quot_product_m_spec }}"> --}}
                                                                </td>
                                                                <td>
                                                                    <div class="input-group mb-3">
                                                                        <input type="number" name="qty[]"
                                                                            class="qty form-control"
                                                                            value="{{ $quotation->quot_product_qty }}"
                                                                            placeholder="Quantity">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon2">{{ $quotation->quot_product_unit }}</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" name="rate[]"
                                                                        class="rate form-control"
                                                                        value="{{ $quotation->quot_product_unit_price }}">
                                                                </td>
                                                                <td>
                                                                    <p class="text-right amount_p ">
                                                                        <i class="fas fa-rupee-sign"></i>
                                                                        <span class="pro_price_span amount">
                                                                            <?= sprintf('%.2f', $amount) ?>
                                                                        </span>
                                                                    </p>
                                                                    <input type="hidden" name="amount[]"
                                                                        class="amount_input form-control"
                                                                        value="{{ $amount }}">
                                                                </td>
                                                            </tr>
                                                            <tr class="item-row-{{ $quotation->product_id }}">
                                                                <td class="border-0"></td>
                                                                <td class="border-0 pt-0" colspan="4">
                                                                    <textarea class="mt-3 product_tech_spec_textarea"  name="product_m_spec[]">{!! $quotation->quot_product_m_spec !!}</textarea>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>

                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" class="text-right"
                                                                style="vertical-align: middle;">
                                                                <b>Basic Total = </b>
                                                            </td>
                                                            <td style="vertical-align: middle;">
                                                                <p class="text-right amount_p mt-3" id="basic_total">
                                                                    <i class="fas fa-rupee-sign"></i> <b
                                                                        id="total_amount">{{ $total }}</b>
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
                                                    <input type="text" class="form-control" id="discount"
                                                        name="discount" placeholder="Enter Discount"
                                                        value="{{ $quotation_terms->term_discount }}">
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="tax">Tax</label>
                                                    <input type="text" class="form-control" id="tax"
                                                        name="tax" value="{{ $quotation_terms->term_tax }}"
                                                        placeholder="GST 18% EXTRA">
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="basis">Basis</label>
                                                    <input type="text" class="form-control" id="basis"
                                                        name="basis" value="{{ $quotation_terms->term_price }}"
                                                        placeholder="F.O.R Kolkata">
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="payment">Payment</label>
                                                    <input type="text" class="form-control" id="payment"
                                                        name="payment" placeholder="100% against proforma invoice"
                                                        value="{{ $quotation_terms->term_payment }}">
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="delivery">Delivery</label>
                                                    <input type="text" class="form-control" id="delivery"
                                                        name="delivery" value="{{ $quotation_terms->term_dispatch }}"
                                                        placeholder="2 days of PO">
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="freight_forwarding">Freight & Forwarding</label>
                                                    <input type="text" class="form-control" id="freight_forwarding"
                                                        name="freight_forwarding"
                                                        value="{{ $quotation_terms->term_forwarding }}"
                                                        placeholder="2% Extra on basic price">
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="validity">Validity</label>
                                                    <input type="text" class="form-control" id="validity"
                                                        name="validity" value="{{ $quotation_terms->term_validity }}">
                                                </div>
                                            </div>


                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="warranty">Warranty</label>
                                                    <input type="text" class="form-control" id="warranty"
                                                        name="warranty" placeholder="12 months from the date of supply"
                                                        value="{{ $quotation_terms->term_warranty }}">
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="note_1">Note 1</label>
                                                    <input type="text" class="form-control" id="note_1"
                                                        name="note_1" value="{{ $quotation_terms->term_note_1 }}">
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="note_2">Note 2</label>
                                                    <input type="text" class="form-control" id="note_2"
                                                        name="note_2" value="{{ $quotation_terms->term_note_2 }}">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button class="btn btn-success float-right mt-5"
                                                    type="submit">Save</button>
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



            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.product_tech_spec_textarea').summernote({
                tabsize: 2,
                minheight: 50,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph', 'style']],
                    ['height', ['height']],
                    // ['font', ['strikethrough', 'superscript', 'subscript']],
                ],
                styleTags: [
                    'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
                ]

            });


            $('#product_id').on('select2:select', function(e) {
                const selectedData = e.params.data;
                var last_product_id = selectedData.id;
                // console.log(last_product_id);
                $.ajax({
                    type: 'post',
                    url: "{{ route('admin.product-details') }}",
                    data: {
                        "product_id": last_product_id,
                        "quot": 1
                    },
                    success: function(res) {
                        console.log(res);
                        // var i = 0;
                        var tr = '';
                        // for (i = 0; i < res.length; i++) {
                        //     var tr = tr + `<tr>
                    //                     <td>
                    //                         ` + res[i].product_name + `(` + res[i].product_code + `)
                    //                         <input type="hidden" name="product_name[]" value="` + res[i]
                        //         .product_name + `">
                    //                         <input type="hidden" name="product_code[]" value="` + res[i]
                        //         .product_code + `">
                    //                         <input type="hidden" name="product_unit[]" value="` + res[i]
                        //         .unit_type + `">
                    //                         <input type="hidden" name="product_tech_spec[]" value="` + res[i]
                        //         .product_tech_spec + `">
                    //                         <input type="hidden" name="product_m_spec[]" value="` + res[i]
                        //         .product_marketing_spec + `">
                    //                     </td>
                    //                     <td><input type="number" name="qty[]" class="qty" value="1"></td>
                    //                     <td><input type="number" name="rate[]" class="rate" value="` + res[i]
                        //         .product_price + `"></td>

                    //                     <td>
                    //                         <input type="text" name="amount[]" class="amount" value="` + res[i]
                        //         .product_price + `" readonly>
                    //                     </td>
                    //                 </tr>`;
                        // }
                        // $("tbody").append(tr);
                        // changeAmount();

                        if (res.status == 'success') {
                            tr = res.data
                            $("#load_table").append(tr);
                            // changeAmount();

                            $('.product_tech_spec_textarea').summernote({
                                tabsize: 2,
                                minheight: 50,
                                toolbar: [
                                    ['style', ['bold', 'italic', 'underline',
                                        'clear'
                                    ]],
                                    ['para', ['ul', 'ol', 'paragraph', 'style']],
                                    ['height', ['height']],
                                    // ['font', ['strikethrough', 'superscript', 'subscript']],
                                ],
                                styleTags: [
                                    'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
                                ]

                            });

                            $('.product_q_sl_no').each(function(index) {
                                $(this).text(index + 1);
                            });
                            updateTotal();

                        } else {
                            conole.log(res.message);
                        }
                    }
                })

            });

            $('#product_id').on('select2:unselect', function(e) {
                console.log("unselect");

                var data = e.params.data; // Get the unselected data            
                // Remove the corresponding content from the div
                $(`#load_table .item-row-${data.id}`).remove();

                $('.product_q_sl_no').each(function(index) {
                    $(this).text(index + 1);
                });

                updateTotal();
            });

            changeAmount();

            function changeAmount() {
                console.log('changeAmount-2');
                $(document).on("change keyup keydown blur", ".qty",function() {
                    var quantity = $(this).val();
                    var amount = $(this).closest('tr').find('.rate').val();
                    var total_amount = quantity * amount;                  
                    if (isNaN(total_amount)) {
                        $(this).closest('tr').find('.amount').text(0);
                        $(this).closest('tr').find('.amount_input').val(0);

                    } else {
                        $(this).closest('tr').find('.amount').text(total_amount.toFixed(2));
                        $(this).closest('tr').find('.amount_input').val(total_amount.toFixed(2));
                    }
                    updateTotal();
                });
            }

            function updateTotal() {
                console.log('updateTotal');

                let total = 0;
                $('.amount').each(function() {
                    console.log('amount');
                    // console.log($(this).val());
                    // const value = parseFloat($(this).val()) || 0;
                    const value = parseFloat($(this).text()) || 0;
                    total += value;
                });
                $('#total_amount').text(total);
                $('#basic_amount').val('Rs. ' + total);
            }

            $(document).on("change keyup keydown blur", ".rate", function() {
                console.log('rate change');

                let rate = $(this).val();
                let quantity = $(this).closest('tr').find('.qty').val();
                let total_amount = quantity * rate;
                if (isNaN(total_amount)) {
                    $(this).closest('tr').find('.amount').text(0);
                    $(this).closest('tr').find('.amount_input').val(0);
                } else {
                    $(this).closest('tr').find('.amount').text(total_amount.toFixed(2));
                    $(this).closest('tr').find('.amount_input').val(total_amount.toFixed(2));
                }
                updateTotal();
            });


        });
    </script>
@endpush
