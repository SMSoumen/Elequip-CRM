@extends('admin.layouts.master')
@section('main_content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Companies</h3>
                                @can('Company create')
                                    <button type="button" class="btn btn-primary add_company">Add Company</button>                              
                                @endcan
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
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

    <!--==================> Add Company Modal ============================-->

    <div class="modal fade" id="add_company" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        $(".add_company").click(function(){
            $(".modal-title").html('Add Company');
            let html =`<form action="{{route('admin.companies.store')}}" method="POST" id="form_data">@csrf
                    <div class="modal-body">
                        <div class="col-12">
                            <label for="company_name">Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="company_name" id="company_name" class="form-control" required>
                        </div>

                        <div class="col-12 mt-2">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>

                        <div class="col-12 mt-2">
                            <label for="website">Website</label>
                            <input type="url" name="website" id="website" class="form-control">
                        </div>

                        <div class="col-12 mt-2">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control">
                        </div>

                        <div class="col-12 mt-2">
                            <label for="city">City<span class="text-danger">*</span></label>
                            <select name="city_id" id="city" class="form-control" required>
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                 <option value="{{$city->id}}">{{$city->city_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mt-2">
                            <label for="gstn">GSTN</label>
                            <input type="text" name="gst" id="gst" class="form-control">
                        </div>

                        <div class="col-12 mt-2">
                            <label for="address">Address<span class="text-danger">*</span></label>
                            <textarea name="address" id="address" class="form-control" required></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>`;
            $(".load_html").html(html);
            $("#add_company").modal('show');
        });

        $(document).on('click','.edit_data',function(){
            let company_id = $(this).data("modelid");
            let url = `{{ route('admin.companies.show', ':id') }}`; 
            url = url.replace(':id', company_id);  

            $.ajax({
                method:"GET",
                url: url,
                success:function(res){
                    $(".modal-title").html('Edit Company');
                    let html =`<form action="{{route('admin.companies.update',':res')}}" method="post" id="form_data">@csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="col-12">
                            <label for="company_name">Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="company_name" id="company_name" class="form-control" required>
                        </div>

                        <div class="col-12 mt-2">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>

                        <div class="col-12 mt-2">
                            <label for="website">Website</label>
                            <input type="url" name="website" id="website" class="form-control">
                        </div>

                        <div class="col-12 mt-2">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control">
                        </div>

                        <div class="col-12 mt-2">
                            <label for="city">City<span class="text-danger">*</span></label>
                            <select name="city" id="city" class="form-control" required>
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                 <option value="{{$city->id}}">{{$city->city_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mt-2">
                            <label for="gstn">GSTN</label>
                            <input type="text" name="gst" id="gst" class="form-control">
                        </div>

                        <div class="col-12 mt-2">
                            <label for="address">Address<span class="text-danger">*</span></label>
                            <textarea name="address" id="address" class="form-control" required></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>`;

                        $(".load_html").html(html);
                        let update_url = `{{ route('admin.companies.update', ':id') }}`;
                        update_url = update_url.replace(':id', res.id);
                        $("#form_data").attr('action',update_url);
                        $("#company_name").val(res.company_name);
                        $("#website").val(res.website);
                        $("#phone").val(res.phone);
                        $("#city").val(res.city);
                        $("#email").val(res.email);
                        $("#gst").val(res.gst);
                        $("#address").val(res.address);
                        $("#add_company").modal('show');
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

                ajax: "{{ route('admin.companies.index') }}",
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
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
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
