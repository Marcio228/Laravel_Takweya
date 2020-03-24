@extends('layouts.backend.main')

@section('title', 'Takweya | All users')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Users
                <small>All users</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>Dashboard</a>
                </li>
                <li><a href="{{ route('admin.users.index') }}">Users</a></li>
                <li class="active">All users</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body ">
                            @if(session('message'))
                                <div class="alert alert-info">
                                    {{ session('message') }}
                                </div>
                            @endif

                            @if(! $users->count())
                                <div class="alert alert-danger">
                                    <strong>No record found</strong>
                                </div>
                            @else
                                <table class="table table-bordered table-users">
                                    <thead>
                                    <tr>
                                        <td>First Name</td>
                                        <td>Last Name</td>
                                        <td>Email Name</td>
                                        <td>Phone</td>
                                        <td>Role</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->first_name }}</td>
                                            <td>{{ $user->last_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->profile->phone ?? "" }}</td>
                                            <td>
                                                @foreach($user->getRoles() as $role)
                                                    {{ $role->name }}
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            </div>
            <!-- ./row -->
        </section>
        <!-- /.content -->
    </div>

@endsection

@section('script')
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <script type="text/javascript">
        $('ul.pagination').addClass('no-margin pagination-sm');

        $('.table-users').DataTable({
            "autoWidth": false,
            stateSave: true,
            "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "All"]],
            "columnDefs": [
                {"orderable": false, "targets": 'nosort'}
            ]
        });
    </script>
@endsection