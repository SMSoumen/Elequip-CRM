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
                                <h3 class="card-title">Reports</h3>
                            </div>
                        </div>
                        <div class="card-body">
                           <div class="row">
                                <div class="col-4">
                                    <label for="from_date">From Date</label>
                                    <input type="date" id="from_date" class="form-control" name="from_date">
                                </div>
                                <div class="col-4">
                                    <label for="to_date">To Date</label>
                                    <input type="date" id="to_date" class="form-control" name="to_date">
                                </div>

                                <div class="col-4">
                                    <button type="button" name="search" class="btn btn-warning mt-4">Search</button>
                                </div>
                           </div>
                        </div>
                        
                    </div>
                </div>

                <!--========================================================>Client Business Report<================================================================-->
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Client Business Report</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-4">
                                    <select class="form-control" name="company_id">
                                        <option value="">Select Company</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select class="form-control" name="customer_id">
                                        <option value="">Select Customer</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <button type="button" name="search" class="btn btn-warning">Search</button>
                                </div>
                            </div>
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Customer(Designation)</th>
                                        <th>Company</th>
                                        <th>Quotation</th>
                                        <th>P.O. Stage</th>
                                        <th>A/c Closed</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                <!--========================================================>Category-wise Report<================================================================-->
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Category-wise Report</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-4">
                                    <select class="form-control" name="company_id">
                                        <option value="">Select Category</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <button type="button" name="search" class="btn btn-warning">Search</button>
                                </div>
                            </div>
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Category Name</th>
                                        <th>Quotation</th>
                                        <th>P.O. Stage</th>
                                        <th>A/c Closed</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
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

       

    </script>
@endpush
