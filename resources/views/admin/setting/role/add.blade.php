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
                <h3 class="card-title">Add Role Form</h3>

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

                        <form action="{{ route('admin.roles.store')}}" method="post">
                            @csrf
                            @method('post')
                            <div class="form-group">
                                <label for="name">Role Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter role" value="{{ old('name') }}">
                            </div>

                            <div class="form-group">
                                <label>Permissions</label>
                                <div class="select2-purple">
                                    <select class="select2" multiple="multiple" data-placeholder="Select a permissions" data-dropdown-css-class="select2-purple" style="width: 100%;" id="permissions" name="permissions[]">
                                        @forelse($permissions as $permission)
                                        <option value="{{$permission->id}}">{{$permission->name}}</option>
                                        @empty
                                        <option value="">No Permission found</option>
                                        @endforelse
                                    </select>
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