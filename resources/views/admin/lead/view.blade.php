@extends('admin.layouts.master')
@section('main_content')
    <style>
        .tabs {
            display: flex;
            justify-content: space-around;
            border-bottom: 2px solid #ddd;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            color: #555;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .tab:hover {
            color: #333;
            border-bottom: 3px solid #007bff;
        }

        .tab.active {
            font-weight: bold;
            color: #007bff;
            border-bottom: 3px solid #007bff;
        }

        .tab-content {
            display: none;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .tab-content.active {
            display: block;
        }
    </style>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title"></h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="response-message"></div>

                            <div class="tabs">
                                <div class="tab @if (in_array($lead->lead_stage_id, [1])) active @endif" data-target="tab1">Time
                                    Line</div>
                                <div class="tab" data-target="lead_details">Lead Details</div>
                                @php
                                    $disabled = $lead->lead_stage_id > 1 ? '' : 'disabled';
                                @endphp
                                <div class="tab {{ $disabled }} @if ($lead->lead_stage_id >= 2 && $lead->lead_stage_id < 5) active @endif"
                                    data-target="quotation_stage">Quotation Stage</div>

                                @php
                                    $disabled = $lead->lead_stage_id >= 3 ? '' : 'disabled';
                                @endphp
                                <div class="tab {{ $disabled }} @if ($lead->lead_stage_id >= 5) active @endif"
                                    data-target="po_stage">P.O.
                                    Stage</div>
                                @php
                                    $disabled = $lead->lead_stage_id > 4 ? '' : 'disabled';
                                @endphp
                                <div class="tab {{ $disabled }}" data-target="proforma">Proforma</div>
                            </div>

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div id="tab1" class="tab-content @if (in_array($lead->lead_stage_id, [1])) active @endif">
                                {{-- <h4>Timeline</h4> --}}
                                @include('admin.lead.timeline')
                            </div>

                            <div id="lead_details" class="tab-content">
                                <form action="{{ route('admin.leads.update', $lead) }}" method="post">@csrf
                                    @method('PUT')
                                    @include('admin.lead.lead_details')
                                </form>
                            </div>

                            <div id="quotation_stage" class="tab-content @if ($lead->lead_stage_id >= 2 && $lead->lead_stage_id < 5) active @endif">
                                @if (session('quotation_data') && $lead->lead_stage_id == 2)
                                    @include('admin.lead.quotation_session_pdf')
                                @elseif($lead->lead_stage_id == 2)
                                    @include('admin.lead.quotation')
                                @elseif(in_array($lead->lead_stage_id, [3, 4, 5, 6, 7, 8, 9]))
                                    @include('admin.lead.quotation_pdf')
                                @endif
                            </div>

                            <div id="po_stage" class="tab-content @if ($lead->lead_stage_id >= 5) active @endif">

                                @if ($lead->lead_stage_id == 3)
                                    <div class="modal fade" id="po_modal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Change Lead Stage</h5>
                                                </div>
                                                <form method="POST" action="{{ route('admin.lead_stage.update') }}">@csrf
                                                    <div class="modal-body">
                                                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                                                        <div class="col-12">
                                                            <label for="lead_stage_id">Update Lead Stage <span
                                                                    class="text-danger"> *</span></label>
                                                            <select name="lead_stage_id" id="lead_stage_id"
                                                                class="form-control">
                                                                <option value="">Select Lead Stage</option>
                                                                @php
                                                                    $manual_stages = $stages->where('stage_is_automated', '0');
                                                                @endphp
                                                                @foreach ($manual_stages as $stage)
                                                                    <option value="{{ $stage->id }}"
                                                                        @if ($stage->id != '4') {{ 'disabled' }} @endif>
                                                                        {{ $stage->stage_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($lead->lead_stage_id == 4)
                                    @include('admin.lead.po_stage')
                                @elseif($lead->lead_stage_id >= 5)
                                    @include('admin.lead.po_stage_update')
                                @endif

                            </div>

                            <div id="proforma" class="tab-content">
                                @if ($lead->lead_stage_id > 4)
                                    @if (!$lead_company->gst)
                                        <div class="modal fade" id="update_gst_modal" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Add Company GST No
                                                        </h5>
                                                    </div>
                                                    <form method="POST" action="{{ route('admin.update.company_gst') }}"
                                                        id="update_gst">@csrf
                                                        <div class="modal-body">
                                                            <input type="hidden" name="company_id"
                                                                value="{{ $lead_company->id }}">
                                                            <div class="col-12">
                                                                <label for="gst_no">Company GST No <span
                                                                        class="text-danger"> *</span></label>
                                                                <input type="text" name="gst_no" id="gst_no"
                                                                    class="form-control" minlength="15" maxlength="15" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($proforma)
                                        @include('admin.lead.proforma_pdf')
                                    @else
                                        @include('admin.lead.proforma')
                                    @endif
                                @endif

                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>

                    <div class="alert alert-danger" role="alert">
                        (*) marks fields are mandatory
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const tabs = document.querySelectorAll('.tab');
            const tabContents = document.querySelectorAll('.tab-content');
            $('.product_select_details').select2({
                placeholder: "Select an option",
                allowClear: true
            });

            // for quotation_stage
            $('.product_select_quot').select2({
                placeholder: "Select an option",
                allowClear: true
            });

            $("#product_id2").change(function() {
                // var product_id = $(this).val();
                var product_id = $(this).val().slice(-1)[0]; 

                $.ajax({
                    type: 'post',
                    url: "{{ route('admin.product-details') }}",
                    data: {
                        "product_id": product_id
                    },
                    success: function(res) {
                        var i = 0;
                        var tr = '';
                        for (i = 0; i < res.length; i++) {
                            var tr = tr + `<tr>
                                                <td>
                                                   <p> ` + res[i].product_name + `(` + res[i].product_code + `)</p>
                                                    <textarea class="product_tech_spec mt-3" readonly>`+res[i].product_tech_spec+`</textarea>

                                                    <input type="hidden" name="product_name[]" value="` + res[i]
                                .product_name + `">
                                                    <input type="hidden" name="product_code[]" value="` + res[i]
                                .product_code + `">
                                                    <input type="hidden" name="product_unit[]" value="` + res[i]
                                .unit_type + `">
                                                    <input type="hidden" name="product_tech_spec[]" value="` + res[i]
                                .product_tech_spec + `">
                                                    <input type="hidden" name="product_m_spec[]" value="` + res[i]
                                .product_marketing_spec + `">
                                                </td>
                                                <td><input type="number" name="qty[]" class="qty mt-5" value="1"></td>
                                                <td><input type="number" name="rate[]" class="rate mt-5" value="` + res[i]
                                .product_price + `"></td>

                                                <td>
                                                    <input type="hidden" class="single_amount" value="` + res[i]
                                .product_price + `">
                                                    <input type="text" name="amount[]" class="amount mt-5" value="` + res[i]
                                .product_price + `" readonly>
                                                </td>
                                            </tr>`;
                        }

                        $("tbody").append(tr);
                        $('.product_tech_spec').summernote({tabsize: 2, height: 100});
                        changeAmount();
                    }
                })
            });

            function changeAmount() {
                $(".qty").keyup(function() {
                    var quantity = $(this).val();
                    var amount = $(this).closest('tr').find(
                        '.single_amount').val();
                    var total_amount = quantity * amount;
                    if (isNaN(total_amount)) {
                        $(this).closest('tr').find('.amount').val(0);
                    } else {
                        $(this).closest('tr').find('.amount').val(
                            total_amount);
                    }
                });
            }
            // for quotation_stage

            // for po stage

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                }
            });

            $("#tax_percent").change(function() {
                amountCalculation();
            });
            $("#gross_total").keyup(function() {
                amountCalculation();
            });
            $("#order_no").keyup(function() {
                amountCalculation();
            })

            function amountCalculation() {
                var tax_percent = $("#tax_percent").val();
                var gross_total = $("#gross_total").val();
                if (gross_total == '') {
                    $("#total_tax_amount").val('0');
                    $("#net_total").val('0');
                } else {
                    var tax_amount = gross_total * (tax_percent / 100);
                    var net_amount = Number(gross_total) + Number(tax_amount);
                    $("#total_tax_amount").val(tax_amount.toFixed(2));
                    $("#net_total").val(net_amount.toFixed(2));
                }
            };
            // for po stage

            // for proforma
            $('.product_tech_spec').summernote({
                tabsize: 2,
                height: 100
            });

            changeAmount();

            function changeAmount() {
                $(".qty").keyup(function() {
                    var quantity = $(this).val();
                    var amount = $(this).closest('tr').find('.rate').val();
                    var total_amount = quantity * amount;
                    if (isNaN(total_amount)) {
                        $(this).closest('tr').find('.amount').val(0);
                    } else {
                        $(this).closest('tr').find('.amount').val(
                            total_amount.toFixed(2));
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
                $('#basic_amount').val('Rs. ' + total);
            }
            // for proforma



            tabs.forEach(tab => {
                tab.addEventListener('click', (e) => {
                    // Remove 'active' class from all tabs and contents                
                    if (!e.target.classList.contains('disabled')) {
                        tabs.forEach(t => t.classList.remove('active'));
                        tabContents.forEach(content => content.classList.remove('active'));

                        // Add 'active' class to the clicked tab and corresponding content
                        tab.classList.add('active');
                        const target = document.getElementById(tab.dataset.target);
                        target.classList.add('active');

                        console.log(tab.dataset.target);

                        if (tab.dataset.target === "lead_details") {

                            $('#lead_stage_id').select2({
                                placeholder: "Select Lead Stage",
                                allowClear: true
                            });
                        } else if (tab.dataset.target === "quotation_stage") {


                        } else if (tab.dataset.target === "po_stage") {
                            $("#po_modal").modal('show');

                        } else if (tab.dataset.target === "proforma") {
                            $("#update_gst_modal").modal('show');
                        }
                    }


                });
            });
        })
    </script>
@endpush
