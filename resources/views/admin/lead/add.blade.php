@extends('admin.layouts.master')
@section('main_content')
    @php
        $tomorrow = date('Y-m-d', strtotime('tomorrow'));
    @endphp
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Add Lead</h3>
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
                            <form action="{{ route('admin.leads.store') }}" method="POST">@csrf
                                <div class="row">
                                    <div class="col-6">
                                        <label for="company_id">Company Name <span class="text-danger"> *</span></label>
                                        <select name="company_id" id="company_id" class="form-control" required>
                                            <option value="">Select Company</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="lead_source_id">Source of Lead <span class="text-danger">
                                                *</span></label>
                                        <select name="lead_source_id" id="lead_source_id" class="form-control" required>
                                            <option value="">Select Lead Source</option>
                                            @foreach ($sources as $source)
                                                <option value="{{ $source->id }}">{{ $source->source_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label for="customer_id">Select Customer <span class="text-danger"> *</span></label>
                                        <select name="customer_id" id="customer_id" class="form-control" required>
                                            <option value="">Select Customer</option>

                                        </select>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label for="lead_category_id">Lead Category <span class="text-danger">
                                                *</span></label>
                                        <select name="lead_category_id" id="lead_category_id" class="form-control" required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-6 mt-3">
                                        <label for="lead_estimate_closure_date">Estimate Closure Date<span
                                                class="text-danger"> *</span></label>
                                        <input type="date" name="lead_estimate_closure_date"
                                            id="lead_estimate_closure_date" class="form-control"
                                            value="{{ old('lead_estimate_closure_date', $tomorrow) }}" required>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label for="Next_follow_up_date">Next Follow-up Date<span class="text-danger">
                                                *</span></label>
                                        <input type="date" name="Next_follow_up_date" id="Next_follow_up_date"
                                            class="form-control" value="{{ old('Next_follow_up_date', $tomorrow) }}"
                                            required>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <label for="product_id">Select Products <span class="text-danger"> *</span></label>
                                        <select name="product_id[]" id="product_id" class="form-control" multiple required>
                                            <option value="">Select Product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->product_name }}
                                                    ({{ $product->product_code }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <table class="table" id="myTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Product Details</th>
                                                    <th style="width:18%">Qty</th>
                                                    <th style="width:18%">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody id="load_table">

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <label for="lead_remarks">Remarks</label>
                                        <textarea class="form-control" name="lead_remarks" id="lead_remarks" rows="6">{{ old('lead_remarks') }}</textarea>
                                    </div>

                                    <div class="col-12 mt-5">
                                        <button type="submit" class="btn btn-success float-right">Submit</button>
                                    </div>
                                </div>
                            </form>

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

            $('#company_id').select2({
                placeholder: "Select Company",
                allowClear: true,
            });
            changeAmount();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#company_id").change(function() {
            var company_id = $(this).val();
            $.ajax({
                type: 'post',
                url: "{{ route('admin.lead.company_customer') }}",
                data: {
                    "company_id": company_id
                },
                success: function(res) {
                    var i = 0;
                    var html = `<option value="">Select Customer</option>`;
                    for (i = 0; i < res.length; i++) {
                        html = html + `<option value="` + res[i].id + `">` + res[i].customer_name +
                            `</option>`;
                    }
                    $("#customer_id").html(html);
                }
            })
        });

        $('#product_id').on('select2:select', function(e) {
            const selectedData = e.params.data;
            var last_product_id = selectedData.id;
            // Log the selected value and text
            // console.log("Value:", selectedData.id);
            // console.log("Text:", selectedData.text);

            $.ajax({
                type: 'post',
                url: "{{ route('admin.product-details') }}",
                data: {
                    "product_id": last_product_id
                },
                success: function(res) {
                    // console.log(res);
                    // var i = 0;
                    var tr = ``;
                    // for(i=0;i<res.length;i++){
                    // var tr = tr + `<tr>
                        //             <td><input type="hidden" name="product_ids[]" value="`+res[i].id+`">`+res[i].product_name+`
                        //                 <div class="product_tech_spec mt-3" readonly>`+res[i].product_tech_spec+`</div></td>
                        //             <td><input type="number" name="qty[]" class="qty" value="1"> <span class="badge bg-secondary ml-1" style="font-size:18px">`+res[i].unit_type+`</span></td>
                        //             <td>
                        //                 <input type="hidden" class="single_amount" value="`+res[i].product_price+`">
                        //                 <input type="number" name="amount[]" class="amount" value="`+res[i].product_price+`" readonly>
                        //             </td>
                        //         </tr>`;
                    // }
                    if (res.status == 'success') {
                        tr = res.data
                        $("#load_table").append(tr);
                        changeAmount();

                        $('.product_sl_no').each(function(index) {
                            $(this).text(index + 1);
                        });

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
            $('.product_sl_no').each(function(index) {
                $(this).text(index + 1);
            });
        });

        function changeAmount() {
            $(".qty").keyup(function() {
                var quantity = $(this).val();
                var amount = $(this).closest('tr').find('.single_amount').val();
                var total_amount = quantity * amount;
                if (isNaN(total_amount)) {
                    $(this).closest('tr').find('.amount').val(0);
                } else {
                    $(this).closest('tr').find('.amount').val(total_amount.toFixed(2));
                }
            });
        }

        // $("#company_id").select2({
        //     placeholder: "Select Company",
        //     allowClear: true,
        // });
    </script>
@endpush
