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
                        <form action="{{route('admin.customers.store')}}" method="POST">@csrf
                            <div class="row">
   

                                    <div class="col-6">
                                        <label for="company_id">Company Name <span class="text-danger"> *</span></label>
                                        <select name="company_id" id="company_id" class="form-control" required>
                                            <option value="">Select Company</option>
                                            @foreach($companies as $company)
                                                <option value="{{$company->id}}">{{$company->company_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="lead_source_id">Source of Lead <span class="text-danger"> *</span></label>
                                        <select name="lead_source_id" id="lead_source_id" class="form-control" required>
                                            <option value="">Select Lead Source</option>
                                            @foreach($sources as $source)
                                                <option value="{{$source->id}}">{{$source->source_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label for="customer_id">Select Customer <span class="text-danger"> *</span></label>
                                        <select name="customer_id" id="customer_id" class="form-control" required>
                                            <option value="">Select Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label for="lead_category_id">Lead Category <span class="text-danger"> *</span></label>
                                        <select name="lead_category_id" id="lead_category_id" class="form-control" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-6 mt-3">
                                        <label for="lead_estimate_closure_date">Estimate Closure Date<span class="text-danger"> *</span></label>
                                        <input type="date" name="lead_estimate_closure_date" id="lead_estimate_closure_date" class="form-control" required>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label for="company_id">Next Follow-up Date<span class="text-danger"> *</span></label>
                                        <input type="date" name="company_id" id="company_id" class="form-control" required>
                                    </div>

                                    <div class="col-6 mt-3">
                                        <label for="product_id">Select Products <span class="text-danger"> *</span></label>
                                        <select name="product_id" id="product_id" class="form-control" required>
                                            <option value="">Select Product</option>
                                            @foreach($products as $product)
                                                <option value="{{$product->id}}">{{$product->product_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Product Details</th>
                                                    <th>Qty</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        CC-Spares
                                                    </td>
                                                    <td>
                                                        <input type="text" name="qty">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="amount" readonly>
                                                    </td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <label for="lead_remarks">Remarks</label>
                                        <textarea class="form-control" name="lead_remarks" id="lead_remarks" rows="6"></textarea>
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



