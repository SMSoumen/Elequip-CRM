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
                                        <label for="contact_person">Contact Person <span class="text-danger"> *</span></label>
                                        <input type="text" name="contact_person" id="contact_person" class="form-control" required>
                                    </div>

                                    <div class="col-6">
                                        <label for="designation">Designation <span class="text-danger"> *</span></label>
                                        <input type="text" name="designation" id="designation" class="form-control" required>
                                    </div>

                                    <div class="col-6 mt-2">
                                        <label for="mobile">Mobile <span class="text-danger"> *</span></label>
                                        <input type="text" name="mobile" id="mobile" class="form-control" required>
                                    </div>

                                    <div class="col-6 mt-2">
                                        <label for="phone">Phone </label>
                                        <input type="text" name="phone" id="phone" class="form-control">
                                    </div>

                                    <div class="col-6 mt-2">
                                        <label for="email">Email <span class="text-danger"> *</span></label>
                                        <input type="email" name="email" id="email" class="form-control" required>
                                    </div>

                                    <div class="col-6 mt-2">
                                        <label for="email2">Email2</label>
                                        <input type="email" name="email2" id="email2" class="form-control">
                                    </div>

                                    <div class="col-6 mt-2">
                                        <label for="designation">Company Name <span class="text-danger"> *</span></label>
                                        <select name="company_name" id="company_name" class="form-control" required>
                                            <option value="">Select Company</option>
                                            @foreach($companies as $company)
                                                <option value="{{$company->id}}">{{$company->company_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-6 mt-2">
                                        <label for="address">Address</label>
                                        <textarea name="address" id="address" class="form-control"></textarea>
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



