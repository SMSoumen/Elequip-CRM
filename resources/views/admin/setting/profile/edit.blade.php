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
                <h3 class="card-title">Update Profile Form</h3>

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

                        <form action="{{ route('admin.update.profile', $user->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label>Role: <span class="text-info">{{implode(',' , $user->getRoleNames()->toArray())}}</span></label>
                                @if($user->avatar)
                                <span><img src="{{asset($user->avatar)}}" alt="" class="user-profile-img"></span>
                                @endif

                            </div>
                            <div class="form-group">
                                <label for="name">User Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ old('name', $user->name) }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" value="{{ old('phone', $user->phone) }}">
                            </div>

                            <div class="form-group">
                                <label for="avatar">File input</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="avatar" name="avatar">
                                        <label class="custom-file-label" for="avatar">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
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