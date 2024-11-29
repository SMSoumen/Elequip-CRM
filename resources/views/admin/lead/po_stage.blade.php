<div class="load_content">
    <div id="response-message"></div>
    <form id="po_add" enctype="multipart/form-data"> @csrf
        <div class="row">
                <input type="hidden" name="lead_id" value="{{$lead->id}}">
                <input type="hidden" name="quotation_id" value="{{$letest_quotation->id}}">

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
                    <input type="file" name="po_document" id="po_document" class="form-control">
                </div>

                <div class="col-6 mt-3">
                    <label for="order_remark">Order Remarks (Dispatch / Pakaging / Payment / installation) <span class="text-danger">*</span></label>
                    <textarea name="order_remark" id="order_remark" class="form-control" required></textarea>
                </div>

                <div class="col-12 mt-5">
                    <button type="submit" class="btn btn-success float-right">Submit</button>
                </div>
        </div>
    </form>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#tax_percent").change(function(){
            amountCalculation();
        });
                        $("#gross_total").keyup(function(){
                            amountCalculation();
                        });
                        $("#order_no").keyup(function(){
                            amountCalculation();
                        })

                            function amountCalculation(){
                                var tax_percent = $("#tax_percent").val();
                                var gross_total = $("#gross_total").val();
                                if(gross_total == ''){
                                    $("#total_tax_amount").val('0');
                                    $("#net_total").val('0');
                                }else{
                                    var tax_amount = gross_total * (tax_percent / 100);
                                    var net_amount = Number(gross_total) + Number(tax_amount); 
                                    $("#total_tax_amount").val(tax_amount);
                                    $("#net_total").val(net_amount);
                                }
                            };

        $('#po_add').on('submit', function (e) {
                e.preventDefault(); 
                let formData = new FormData(this);
                $.ajax({
                    url: "{{route('admin.lead.purchase_order.create')}}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false, 
                    success: function (response) {
                        $('#response-message').html('');
                        if (response.success) {
                            $('#response-message').html('<div class="alert alert-success text-center">' + response.message + '</div>');
                            let url = `{{route('admin.po.details',':po_id')}}`; 
                            url = url.replace(':po_id', response.po_id);
                            $.ajax({
                                url: url,
                                method: 'GET',
                                success: function (res) {
                                    $(".load_content").html(res);
                                }
                            });
                        }
                    },
                    error: function (xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';
                        for (let field in errors) {
                            errorMessages += `<p style="color: red;">${errors[field]}</p>`;
                        }
                        $('#response-message').html(errorMessages);
                    }
                });
        })
</script>

