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
                                    <form action="{{route('admin.lead.proforma.update')}}" method="post">@csrf
                                        <div class="row">
                                            <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                                            <input type="hidden" name="lead_id" value="{{$invoice->lead_id}}">

                                            <div class="col-6">
                                                <label for="tax_type">Tax Type <span class="text-danger">*</span></label>
                                                <select class="form-control" name="tax_type" id="tax_type" required>
                                                    <option value="cgst+sgst" @if($invoice->proforma_gst_type == 'cgst+sgst') {{'selected'}} @endif>CGST+SGST</option>
                                                    <option value="igst" @if($invoice->proforma_gst_type == 'igst') {{'selected'}} @endif>IGST</option>
                                                </select>
                                            </div>

                                            <div class="col-6">
                                                <label for="dispatch">Dispatch<span class="text-danger">*</span></label>
                                                <input type="text" name="dispatch" id="dispatch" class="form-control" value="{{$invoice->proforma_dispatch}}" required>
                                            </div>

                                            <div class="col-12 mt-3">
                                                <label for="proforma_remark">Proforma Remarks <span class="text-danger">*</span></label>
                                                <textarea name="proforma_remark" id="proforma_remark" class="form-control" required>{{$invoice->proforma_remarks}}</textarea>
                                            </div>

                                            <div class="col-12 mt-3">
                                                    <table class="table" id="myTable">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Product Details</th>
                                                                        <th>Qty</th>
                                                                        <th>Rate</th>
                                                                        <th>Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>  
                                                                @php $total_amount = 0; @endphp
                                                                @foreach($proforma_details as $key=>$proforma)
                                                                    @php
                                                                        $amount = $proforma->proforma_product_price * $proforma->proforma_product_qty;
                                                                        $total_amount = $total_amount + $amount
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{$key+1}}</td>
                                                                        <td>
                                                                            {{$proforma->product_name}} ({{$proforma->product_code}}) <br><br>
                                                                            <textarea name="product_tech_spec[]" class="product_tech_spec">{{$proforma->proforma_product_spec}}</textarea>
                                                                            <input type="hidden" name="product_id[]" value="{{$proforma->product_id}}">
                                                                            <input type="hidden" name="product_name[]" value="{{ $proforma->proforma_product_name }}">
                                                                            <input type="hidden" name="product_code[]" value="{{ $proforma->proforma_product_code }}">
                                                                            <input type="hidden" name="product_unit[]" value="{{ $proforma->proforma_product_unit }}">
                                                                        </td>
                                                                        <td><input type="number" name="qty[]" class="qty mt-5" value="{{$proforma->proforma_product_qty}}" ></td>
                                                                        <td><input type="number" name="rate[]" class="rate mt-5" value="{{$proforma->proforma_product_price}}" ></td>
                                                                        <td><input type="text" name="amount[]" class="amount mt-5" value="{{$amount}}" readonly></td>
                                                                    </tr>
                                                                @endforeach

                                                                    <tr>
                                                                        <td colspan="3"></td>
                                                                        <td colspan="2">
                                                                            <div class="input-group">
                                                                                <span class="input-group-text" id="basic-addon1">Basic Total =</span>
                                                                                <input type="text" id="basic_amount" aria-label="Username" aria-describedby="basic-addon1" value="Rs. {{$total_amount}}" readonly>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                    </table>
                                            </div>

                                            <div class="col-12 mt-5 mb-3">
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
            updateTotal();
        });
    }

    function updateTotal() {
        let total = 0;
        $('.amount').each(function() {
            const value = parseFloat($(this).val()) || 0;
            total += value;
        });
        $('#basic_amount').val('Rs. '+total);
    }

</script>


@endpush





