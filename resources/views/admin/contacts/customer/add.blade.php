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
                                <h3 class="card-title">Add Customer</h3>
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
                                        <label for="customer_name">Contact Person <span class="text-danger"> *</span></label>
                                        <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{old('customer_name')}}" required>
                                    </div>

                                    <div class="col-6">
                                        <label for="designation">Designation <span class="text-danger"> *</span></label>
                                        <input type="text" name="designation" id="designation" class="form-control" value="{{old('designation')}}" required>
                                    </div>

                                    <div class="col-6 mt-2">
                                        <label for="mobile">Mobile <span class="text-danger"> *</span></label>
                                        <input type="text" name="mobile" id="mobile" class="form-control" value="{{old('mobile')}}" required>
                                    </div>

                                    <div class="col-6 mt-2">
                                        <label for="phone">Phone </label>
                                        <input type="text" name="phone" id="phone" class="form-control" value="{{old('phone')}}">
                                    </div>

                                    <div class="col-6 mt-2">
                                        <label for="email">Email <span class="text-danger"> *</span></label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}" required>
                                    </div>

                                    <div class="col-6 mt-2">
                                        <label for="email2">Email2</label>
                                        <input type="email" name="email2" id="email2" class="form-control" value="{{old('email2')}}">
                                    </div>

                                    <div class="col-6 mt-2">
                                        <label for="company_id">Company Name <span class="text-danger"> *</span></label>
                                        <select name="company_id" id="company_id" class="form-control" required>
                                            <option value="">Select Company</option>
                                            @foreach($companies as $company)
                                                <option value="{{$company->id}}">{{$company->company_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-6 mt-2">
                                        <label for="address">Address</label>
                                        <textarea name="address" id="address" class="form-control">{{old('address')}}</textarea>
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



