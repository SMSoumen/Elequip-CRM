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
                                <h3 class="card-title">Leads</h3>
                                @can('Lead create')
                                    <a href="{{route('admin.leads.create')}}"><button type="button" class="btn btn-primary add_brand">Add Lead</button></a>                             
                                @endcan
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                           <form action="" method="get">@csrf
                               <div class="row mb-5">
                                    <div class="col-3">
                                        <label for="lead_stage">Lead Stage</label>
                                        <select class="form-control" name="lead_stage" id="lead_stage" required>
                                            <option value="">Select Lead Stage</option>
                                            @foreach($lead_stages as $lead_stage)
                                            <option value="{{$lead_stage->id}}">{{$lead_stage->stage_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-3">
                                        <label for="from_date">From Date</label>
                                        <input type="date" class="form-control" name="ffrom_date" id="from_date">
                                    </div>

                                    <div class="col-3">
                                        <label for="to_date">To Date</label>
                                        <input type="date" class="form-control" name="to_date" id="to_date">
                                    </div>

                                    <div class="col-3 mt-4">
                                        <button type="submit" class="btn btn-success">Search</button>
                                    </div>
                                </div>
                            </form>

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
                                        <th>Customer</th>
                                        <th>Mobile</th>
                                        <th>Quote Ref NO.</th>
                                        <th>Next Follow-up</th>
                                        <th>Assigned To</th>
                                        <th>Stage</th>
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
@endsection


    <!--==================> Add Brand Modal ============================-->

    <div class="modal fade" id="assign_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assign Lead</h5>
                </div>
                <form action="{{route('admin.lead-assign')}}" method="POST" id="form_data">@csrf
                    <div class="modal-body">
                        <input type="hidden" name="lead_id" id="lead_id">
                        <div class="col-12">
                            <label for="lead_assigned_to">Select User <span class="text-danger">*</span></label>
                            <select name="lead_assigned_to" id="lead_assigned_to" class="form-control" required>
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
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

@push('scripts')

    <script>

        $(document).on('click','.assign_user',function(){
            var lead_id = $(this).data("modelid");
            $("#lead_id").val(lead_id);
            $("#assign_user").modal('show');
        });


        $(document).ready(function() {
            var currentdate = new Date();
            var datetime = currentdate.getDate() + "-" + (currentdate.getMonth() + 1) + "-" + currentdate
                .getFullYear() + "-" + currentdate.getHours() + "-" + currentdate.getMinutes() + "-" + currentdate
                .getSeconds();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

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

                ajax: "{{ route('admin.leads.index') }}",
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
                        data: 'customer',
                        name: 'customer'
                    },
                    {
                        data: 'mobile',
                        name: 'mobile'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'next_fllowup_date',
                        name: 'next_fllowup_date'
                    },
                    {
                        data: 'assign_to',
                        name: 'assign_to'
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
