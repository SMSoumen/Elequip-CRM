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
                                <h3 class="card-title">Lead Stage</h3>
                                <!-- @can('Lead Stage create')
                                    <button type="button" class="btn btn-primary add_lead_stage">Add Lead Stage</button>                              
                                @endcan -->
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
                                        <th>Stage Name</th>
                                        <th>Created Date</th>
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
@endsection

    <!--==================> Add Lead Stage Modal ============================-->

    <div class="modal fade" id="add_lead_stage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
            </div>
            <div class="load_html"></div>

            </div>
        </div>
    </div>

@push('scripts')
    <script>
        $(".add_lead_stage").click(function(){
            $(".modal-title").html('Add  Lead Stage');
            let html =`<form action="{{route('admin.lead-stage.store')}}" method="POST">@csrf
                <div class="modal-body">
                    <div class="col-12">
                        <label for="stage_name">Stage Name <span class="text-danger">*</span></label>
                        <input type="text" name="stage_name" id="stage_name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>`;
            $(".load_html").html(html);
            $("#add_lead_stage").modal('show');
        });

        $(document).on('click','.edit_data',function(){
            let sources_id = $(this).data("modelid");
            let url = `{{route('admin.lead-stage.show',':id')}}`; 
            url = url.replace(':id', sources_id); 
            $.ajax({
                method:"GET",
                url: url,
                success:function(res){
                    // console.log(res);
                    $(".modal-title").html('Edit  Lead Stage');
                    let html =`<form action="{{route('admin.lead-stage.update',':res')}}" method="post" id="form_data">@csrf
                    @method('PUT')
                            <div class="modal-body">
                                <div class="col-12">
                                    <label for="stage_name1">Stage Name <span class="text-danger">*</span></label>
                                    <input type="text" name="stage_name" id="stage_name1" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>`;

                        $(".load_html").html(html);
                        let update_url = `{{ route('admin.lead-stage.update', ':id') }}`;
                        update_url = update_url.replace(':id', res.id);
                        $("#form_data").attr('action',update_url);
                        $("#stage_name1").val(res.stage_name);
                        $("#add_lead_stage").modal('show');
                }
            })
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

                ajax: "{{ route('admin.lead-stage.index') }}",
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
                        data: 'stage_name',
                        name: 'stage_name'
                    },
                    {
                        data: 'created_date',
                        name: 'created_date'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
