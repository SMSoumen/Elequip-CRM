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
                            <h3 class="card-title">DataTable with Roles</h3>
                            @can('Role create')
                            <a href="{{route('admin.roles.create')}}" class="btn btn-sm btn-success">Add Role</a>
                            @endcan
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Role Name</th>
                                    <th>Permissions</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @can('Role access')
                                @forelse($roles as $role)
                                <tr>
                                    <td>{{$role->name}}</td>
                                    <td>
                                        @forelse($role->permissions as $permission)
                                        <span class="badge badge-pill badge-custom badge-info">{{$permission->name}}</span>
                                        @empty
                                        @if($role->name === 'Super-Admin')
                                        <span class="badge badge-pill badge-custom badge-info">You have full access.</span>
                                        @else
                                        <span class="badge badge-pill badge-custom badge-secondary">Sorry There is no access</span>
                                        @endif
                                        @endforelse
                                    </td>
                                    <td class="d-flex">
                                        @can('Role edit')
                                        <a href="{{route('admin.roles.edit',$role->id)}}" class="btn btn-sm btn-warning mr-2">Edit</a>
                                        @endcan

                                        @can('Role delete')
                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="inline deleteConfirm">
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