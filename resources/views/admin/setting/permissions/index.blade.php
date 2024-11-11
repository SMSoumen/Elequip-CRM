@extends('admin.layouts.master')

@section('main_content')

<x-breadcrumb />

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">DataTable with Permissions</h3>
                            @can('Permission create')
                            <a href="{{route('admin.permissions.create')}}" class="btn btn-sm btn-success">Add Permission</a>
                            @endcan
                        </div>
                    </div>


                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Permission</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @can('Permission access')
                                @forelse($permissions as $permission)
                                <tr>
                                    <td>{{$permission->name}}</td>

                                    <td class="d-flex">
                                        @can('Permission edit')
                                        <a href="{{route('admin.permissions.edit',$permission->id)}}" class="btn btn-sm btn-warning mr-2">Edit</a>
                                        @endcan

                                        @can('Permission delete')
                                        <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" class="inline deleteConfirm">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                        @endcan

                                    </td>
                                </tr>
                                @empty
                                @endforelse
                                @endcan
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