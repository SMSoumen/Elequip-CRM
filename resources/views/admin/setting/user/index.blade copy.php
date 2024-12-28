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
                            <h3 class="card-title">DataTable with Users</h3>
                            @can('User create')
                            <a href="{{route('admin.users.create')}}" class="btn btn-sm btn-success">Add User</a>
                            @endcan
                        </div>
                    </div>


                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Code</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @can('Admin access')
                                @forelse($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>

                                    <td>{{$user->email}}</td>
                                    <td>{{$user->code}}</td>
                                    <td>
                                        @forelse($user->roles as $role)
                                        <span class="badge badge-pill badge-custom badge-info">{{$role->name}}</span>
                                        @empty
                                        <span class="badge badge-pill badge-custom badge-secondary">Sorry there is no role</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        <input type="checkbox" class="userStatusChange" name="user-checkbox" data-user="{{$user->id}}" data-url="{{route('admin.user.change.status')}}" @if($user->status == 1) checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                    </td>

                                    <td class="d-flex">
                                        @can('Admin edit')
                                        <a href="{{route('admin.users.edit',$user->id)}}" class="btn btn-sm btn-warning mr-2">Edit</a>
                                        @endcan

                                        @can('Admin delete')
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline deleteConfirm">
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

@push('scripts')

<script>
    $(".userStatusChange").on('switchChange.bootstrapSwitch', function(e) {
        // console.log($(this).data('user'));
        let userId = $(this).data('user');
        let url = $(this).data('url');
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                'user_stat': e.target.checked,
                'user_id': userId,
                '_token': "{{csrf_token()}}",
            },
            dataType: "json",
            success: function(response) {
                console.log(response.error);
                if (!response.error) {
                    toastr.success(response.msg);
                } else {
                    toastr.error(response.msg);
                }
            }

        });
    });
</script>

@endpush