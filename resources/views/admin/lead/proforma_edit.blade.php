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
                                <h3 class="card-title">Proforma Update</h3>
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
                                    <form action="{{ route('admin.lead.proforma.update') }}" method="post">@csrf
                                        <div class="row">
                                            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                            <input type="hidden" name="lead_id" value="{{ $invoice->lead_id }}">

                                            <div class="col-6">
                                                <label for="tax_type">Tax Type <span class="text-danger">*</span></label>
                                                <select class="form-control" name="tax_type" id="tax_type" required>
                                                    <option value="1"
                                                        @if ($invoice->proforma_gst_type == '1') {{ 'selected' }} @endif>
                                                        CGST+SGST</option>
                                                    <option value="2"
                                                        @if ($invoice->proforma_gst_type == '2') {{ 'selected' }} @endif>IGST
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-6">
                                                <label for="dispatch">Dispatch<span class="text-danger">*</span></label>
                                                <input type="text" name="dispatch" id="dispatch" class="form-control"
                                                    value="{{ $invoice->proforma_dispatch }}" required>
                                            </div>

                                            <div class="col-12 mt-3">
                                                <label for="proforma_remark">Proforma Remarks <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="proforma_remark" id="proforma_remark" class="form-control" required>{{ $invoice->proforma_remarks }}</textarea>
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
                                                        @foreach ($proforma_details as $key => $proforma)
                                                            @php
                                                                $amount =
                                                                    $proforma->proforma_product_price *
                                                                    $proforma->proforma_product_qty;
                                                                $total_amount = $total_amount + $amount;
                                                            @endphp
                                                            <tr>
                                                                <td class="prod_head">{{ $key + 1 }}</td>
                                                                <td class="">
                                                                    <p class="prod_head">{{ $proforma->product_name }}
                                                                        ({{ $proforma->product_code }})
                                                                    </p>
                                                                    <br>
                                                                    <textarea name="product_tech_spec[]" class="product_tech_spec">{{ $proforma->proforma_product_spec }}</textarea>
                                                                    <input type="hidden" name="product_id[]"
                                                                        value="{{ $proforma->product_id }}">
                                                                    <input type="hidden" name="product_name[]"
                                                                        value="{{ $proforma->proforma_product_name }}">
                                                                    <input type="hidden" name="product_code[]"
                                                                        value="{{ $proforma->proforma_product_code }}">
                                                                    <input type="hidden" name="product_unit[]"
                                                                        value="{{ $proforma->proforma_product_unit }}">
                                                                </td>
                                                                <td>
                                                                    <div class="input-group mb-3">
                                                                        <input type="number" name="qty[]"
                                                                            class="qty form-control"
                                                                            value="{{ $proforma->proforma_product_qty }}"
                                                                            placeholder="Quantity">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon2-{{ $key + 1 }}">{{ $proforma->proforma_product_unit }}</span>
                                                                        </div>
                                                                    </div>
                                                                    {{-- <input type="number" name="qty[]" class="qty mt-5" value="{{$proforma->proforma_product_qty}}" > --}}
                                                                </td>
                                                                <td>
                                                                    <input type="number" name="rate[]"
                                                                        class="rate form-control"
                                                                        value="{{ $proforma->proforma_product_price }}">
                                                                </td>
                                                                <td>
                                                                    <p class="text-right amount_p ">
                                                                        <i class="fas fa-rupee-sign"></i>
                                                                        <span class="pro_price_span amount">
                                                                            <?= sprintf('%.2f', $amount) ?>
                                                                        </span>
                                                                    </p>
                                                                    {{-- <input type="text" name="amount[]" class="amount mt-5" value="{{$amount}}" readonly> --}}
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                        {{-- <tr>
                                                            <td colspan="3"></td>
                                                            <td colspan="2">
                                                                <div class="input-group">
                                                                    <span class="input-group-text" id="basic-addon1">Basic
                                                                        Total =</span>
                                                                    <input type="text" id="basic_amount"
                                                                        aria-label="Username"
                                                                        aria-describedby="basic-addon1"
                                                                        value="Rs. {{ $total_amount }}" readonly>
                                                                </div>
                                                            </td>
                                                        </tr> --}}
                                                    </tbody>

                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" align="right"
                                                                style="vertical-align: middle;">
                                                                <b><span>Basic Total =</span></b>
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

                                            <div class="col-12 mt-2 mb-3">
                                                <button type="submit" class="btn btn-success float-right">Submit</button>
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
        $('.product_tech_spec').summernote({
            tabsize: 2,
            height: 100,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['font', ['fontname', 'fontsize', 'color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });

        changeAmount();

        function changeAmount() {
            console.log('changeAmount-2');
            $(document).on("change keyup keydown blur", ".qty", function() {
                var quantity = $(this).val();
                var amount = $(this).closest('tr').find('.rate').val();
                var total_amount = quantity * amount;

                if (isNaN(total_amount)) {
                    $(this).closest('tr').find('.amount').text(0);
                } else {
                    $(this).closest('tr').find('.amount').text(
                        total_amount.toFixed(2));
                }
                updateTotal();
            });
        }

        $(document).on("change keyup keydown blur", ".rate", function() {
            console.log('rate change');

            let rate = $(this).val();
            let quantity = $(this).closest('tr').find('.qty').val();
            let total_amount = quantity * rate;
            if (isNaN(total_amount)) {
                $(this).closest('tr').find('.amount').text(0);
            } else {
                $(this).closest('tr').find('.amount').text(total_amount.toFixed(2));
            }
            updateTotal();
        });

        // function changeAmount() {
        //     $(".qty").keyup(function() {
        //         var quantity = $(this).val();
        //         var amount = $(this).closest('tr').find('.rate').val();
        //         var total_amount = quantity * amount;

        //         if (isNaN(total_amount)) {
        //             $(this).closest('tr').find('.amount').val(0);
        //         } else {
        //             $(this).closest('tr').find('.amount').val(total_amount);
        //         }
        //         updateTotal();
        //     });
        // }

        // function updateTotal() {
        //     let total = 0;
        //     $('.amount').each(function() {
        //         const value = parseFloat($(this).val()) || 0;
        //         total += value;
        //     });
        //     $('#basic_amount').val('Rs. ' + total);
        // }

        function updateTotal() {
            console.log('updateTotal');

            let total = 0;
            $('.amount').each(function() {
                console.log('amount');
                const value = parseFloat($(this).text()) || 0;
                total += value;
            });
            $('#total_amount').text(total);
            // $('#basic_amount').val('Rs. ' + total);
        }
    </script>
@endpush
