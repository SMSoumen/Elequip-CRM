@extends('admin.layouts.master')

@section('main_content')

<x-breadcrumb />

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <x-alert />
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Change Password Form</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <!-- <h5>Custom Color Variants</h5> -->
                <div class="row">
                    <div class="col-lg-12 col-12">

                        <form action="{{ route('admin.change_password.update')}}" method="post">
                            @csrf
                            @method('post')
                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->email }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone No</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{auth()->user()->phone }}" required>
                            </div>

                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter Current Password">
                            </div>

                            <label for="password">Password</label>
                            <div class="input-group mb-3">
                                <input name="password" type="password" class="form-control" aria-describedby="admin-password-eye" id="admin-change-password-input" placeholder="Enter New Password">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="admin-password-eye"><i class="fas fa-eye-slash"></i></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re Enter Password">
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>


                        <!-- /.form-group -->
                    </div>

                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->




    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection