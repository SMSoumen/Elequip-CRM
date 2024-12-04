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
                                                                        <th>Product Details</th>
                                                                        <th>Qty</th>
                                                                        <th>Rate</th>
                                                                        <th>Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>  
                                                                @foreach($proforma_details as $proforma)
                                                                    @php
                                                                        $amount = $proforma->proforma_product_price * $proforma->proforma_product_qty;
                                                                    @endphp
                                                                    <tr>
                                                                        <td>
                                                                            {{$proforma->product_title}} ({{$proforma->product_code}})
                                                                            <input type="hidden" name="product_id[]" value="{{$proforma->product_id}}">
                                                                            <input type="hidden" name="product_tech_spec[]" value="{{$proforma->proforma_product_spec}}">
                                                                        </td>
                                                                        <td><input type="number" name="qty[]" class="qty" value="{{$proforma->proforma_product_qty}}" ></td>
                                                                        <td><input type="number" name="rate[]" class="rate" value="{{$proforma->proforma_product_price}}" ></td>
                                                                        <td><input type="text" name="amount[]" class="amount" value="{{$amount}}" readonly></td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                    </table>
                                            </div>


                                            <div class="col-12 mt-5">
                                                <button type="submit" class="btn btn-success float-right">Update Proforma</button>
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
    });
}

</script>


@endpush





