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
                                <h3 class="card-title">Sub Categories of {{$category->product_category_name}}</h3>
                                @can('ProductCategory create')
                                    <button type="button" class="btn btn-primary add_subcategory">Add Sub Category</button>                              
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
                            <table class="listtable table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Sub Category Name</th>
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

    <!--==================> Add Brand Modal ============================-->

    <div class="modal fade" id="add_subcategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                </div>
                <div class="load_html">

                </div>
            </div>
        </div>
    </div>

@push('scripts')

    <script>
        $(".add_subcategory").click(function(){
            $(".modal-title").html('Add Sub Category');
            let html =`<form action="{{route('admin.product-subcategories.store')}}" method="POST" id="form_data">@csrf
                <div class="modal-body">
                    <input type="hidden" name="product_category_id" value="{{$cat_id}}">
                    <div class="col-12">
                        <label for="product_subcat_name">Sub Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="product_subcat_name" id="product_subcat_name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>`;
            $(".load_html").html(html);
            $("#add_subcategory").modal('show');
        });

        $(document).on('click','.edit_data',function(){
            let subcategory_id = $(this).data("modelid");
            let url = `{{ route('admin.product-subcategories.show', ':id') }}`; 
            url = url.replace(':id', subcategory_id);  
            $.ajax({
                method:"GET",
                url: url,
                success:function(res){
                    $(".modal-title").html('Edit Sub Category');
                    let html =`<form action="{{route('admin.product-subcategories.update',':res')}}" method="post" id="form_data">@csrf
                    @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" name="product_category_id" value="{{$cat_id}}">
                            <div class="col-12">
                                <label for="product_subcat_name">Sub Category Name <span class="text-danger">*</span></label>
                                <input type="text" name="product_subcat_name" id="product_subcat_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        </form>`;

                        $(".load_html").html(html);
                        let update_url = `{{ route('admin.product-subcategories.update', ':id') }}`;
                        update_url = update_url.replace(':id', res.id);
                        $("#form_data").attr('action',update_url);
                        $("#product_subcat_name").val(res.product_subcat_name);
                        $("#add_subcategory").modal('show');
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

                ajax: "{{ route('admin.product-subcategories.all',$cat_id) }}",
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
                        data: 'product_subcat_name',
                        name: 'product_subcat_name'
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
