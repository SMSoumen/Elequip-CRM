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
                                <h3 class="card-title">Orders</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
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
                            <table class="listtable table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Order By</th>
                                        <th>OA NO.</th>
                                        <th>Order Amount</th>
                                        <th>Balance Amount</th>
                                        <th>Created On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
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

    <!--==================> Add Advance Amount Modal ============================-->

    <div class="modal fade" id="add_advance_amount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Advance Payment</h5>
                </div>
                <form method="POST" id="add_advance_amount_form">@csrf
                    <div class="modal-body">
                        <p id="response-message"></p>
                        <input type="hidden" name="order_id" id="order_id">
                        <div class="col-12">
                            <label for="advance_amount">Advance Amount<span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="advance_amount" id="advance_amount" class="form-control" required>
                            <span class="text-danger" id="check_amount_msg"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--==================> Add Remaining Amount ============================-->

    <div class="modal fade" id="add_remaining_amount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Remaining Amount</h5>
                </div>
                <form method="POST" id="add_remaining_amount_form">@csrf
                    <div class="modal-body">
                        <p id="response-message1"></p>
                        <input type="hidden" name="order_id" id="r_order_id">
                        <div class="col-12">
                            <label for="remaining_amount">Remaining Amount<span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="remaining_amount" id="remaining_amount"
                                class="form-control" required>
                            <span class="text-danger" id="check_remaining_msg"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--==================> update lead stage Modal ============================-->

    <div class="modal fade" id="lead_stage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Stage</h5>
                </div>
                <form method="POST" id="lead_stage_form">@csrf
                    <div class="modal-body">
                        <p id="response-message_stage"></p>
                        <input type="hidden" name="lead_id" id="lead_id">
                        <div class="col-12" id="dynamic_lead_stages">
                            <label for="stage_id">Select Stage<span class="text-danger">*</span></label>
                            <select name="stage_id" id="stage_id" class="form-control" required>
                                @foreach ($lead_stages as $stage)
                                    <option value="{{ $stage->id }}"
                                        @if ($stage->id == 9) {{ 'disabled' }} @endif>
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

    <!--==================> Send SMS Modal ============================-->

    <div class="modal fade" id="send_sms" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send SMS</h5>
                </div>
                <form method="POST" action="{{ route('admin.order.send_sms') }}">@csrf
                    <div class="modal-body">
                        <input type="hidden" name="mobile_no" id="mobile_no">
                        <input type="hidden" name="lead_id" id="lead_id1">
                        <div class="col-12">
                            <label for="sms_title">SMS Title<span class="text-danger">*</span></label>
                            <select name="sms_title" id="sms_title" class="form-control" required>
                                <option value="" class="d-none">Select SMS Template</option>
                                @foreach ($templates as $template)
                                    <option value="{{ $template->id }}">{{ $template->template_name }}</option>
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
@endsection


@push('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.send_sms', function() {
            var mobile_no = $(this).data("mobileno");
            var lead_id = $(this).data("leadid");
            $("#mobile_no").val(mobile_no);
            $("#lead_id1").val(lead_id);
            $("#send_sms").modal('show');
        });

        $(document).on('click', '.update_stage', function() {
            var lead_id = $(this).data("modelid");
            var stage_id = $(this).data("stageid");
            $("#lead_id").val(lead_id);
            $("#stage_id").val(stage_id);

            $("#response-message_stage").html("")

            $.ajax({
                url: "{{ route('admin.order.update_lead_stage.modal') }}",
                method: 'POST',
                data: {lead_id, stage_id},
                datatype: 'json',
                success: function(response) {
                    $("#dynamic_lead_stages").html(response)
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    for (let field in errors) {
                        errorMessages += `<p style="color: red;">${errors[field]}</p>`;
                    }
                    $('#response-message_stage').html(errorMessages);
                }
            })

            $("#lead_stage").modal('show');
        });

        $(document).on('click', '.add_remaining_amount', function() {
            var order_id = $(this).data("modelid");
            var remaining_amount = $(this).data("remaining_amount");
            $("#r_order_id").val(order_id);
            $('#remaining_amount').attr('placeholder', remaining_amount);
            $("#add_remaining_amount").modal('show');
        });

        $(document).on('click', '.add_advance_amount', function() {
            var order_id = $(this).data("modelid");
            $("#order_id").val(order_id);
            $("#add_advance_amount").modal('show');
        });

        $('#add_advance_amount_form').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "{{ route('admin.order.add_advance_amount') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#response-message').html('');
                    if (response.success) {
                        $('#response-message').html('<div class="alert alert-success text-center">' +
                            response.message + '</div>');
                        setInterval(location.reload(), 100000);
                    } else if (response.status == 'check_amount') {
                        $("#check_amount_msg").html(response.message);
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    for (let field in errors) {
                        errorMessages += `<p style="color: red;">${errors[field]}</p>`;
                    }
                    $('#response-message').html(errorMessages);
                }
            })
        });

        $('#add_remaining_amount_form').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "{{ route('admin.order.add_remaining_amount') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#response-message1').html('');
                    if (response.success) {
                        $('#response-message1').html('<div class="alert alert-success text-center">' +
                            response.message + '</div>');
                        setTimeout(location.reload(), 100000);
                    } else if (response.status == 'check_amount') {
                        $("#check_remaining_msg").html(response.message);
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    for (let field in errors) {
                        errorMessages += `<p style="color: red;">${errors[field]}</p>`;
                    }
                    $('#response-message1').html(errorMessages);
                }
            })
        });

        $('#lead_stage_form').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "{{ route('admin.order.update_lead_stage') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#response-message_stage').html('');
                    if (response.success) {
                        $('#response-message_stage').html(
                            '<div class="alert alert-success text-center">' + response.message +
                            '</div>');
                        setInterval(location.reload(), 100000);
                    }else{
                        $('#response-message_stage').html(
                            '<div class="alert alert-danger text-center">' + response.message +
                            '</div>');
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    for (let field in errors) {
                        errorMessages += `<p style="color: red;">${errors[field]}</p>`;
                    }
                    $('#response-message_stage').html(errorMessages);
                }
            })
        });


        $(document).ready(function() {
            var currentdate = new Date();
            var datetime = currentdate.getDate() + "-" + (currentdate.getMonth() + 1) + "-" + currentdate
                .getFullYear() + "-" + currentdate.getHours() + "-" + currentdate.getMinutes() + "-" + currentdate
                .getSeconds();


            var table = $('.listtable').DataTable({
                dom: "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [{
                        extend: 'excel',
                        title: datetime + '-Data export',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: datetime + '-Data export',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    }
                ],
                paging: true,
                searching: true,
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "lengthChange": true,

                ajax: "{{ route('admin.orders.index') }}",
                lengthMenu: [
                    [10, 25, 50, 200, 500, 1000, -1],
                    [10, 25, 50, 200, 500, 1000, "All"]
                ],

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'orderby',
                        name: 'orderby'
                    },
                    {
                        data: 'po_refer_no',
                        name: 'po_refer_no'
                    },
                    {
                        data: 'po_net_amount',
                        name: 'po_net_amount'
                    },
                    {
                        data: 'balance_amount',
                        name: 'balance_amount'
                    },
                    {
                        data: 'created_date',
                        name: 'created_date'
                    },
                    {
                        data: 'stage',
                        name: 'stage'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false,
                    }
                ],
                "fnDrawCallback": function() {
                    $('.statusChange').bootstrapSwitch();
                }

            });

        });
    </script>
@endpush
