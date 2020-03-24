@extends('layouts.frontend.main')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                User profile
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> User profile</li>
            </ol>
        </section>

    <?php $currentUser = \App\User::where('id', Sentinel::getUser()->id)->firstOrFail() ?>

    <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <img class="profile-user-img img-responsive img-circle"
                                 src="{{ asset('/storage/img/users/user1.png') }}" alt="User profile picture">

                            <h3 class="profile-username text-center">{{ $currentUser->full_name }}</h3>

                            <p class="text-muted text-center">{{ $currentUser->roles[0]->name }}</p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Email</b> <a class="pull-right">{{ $currentUser->email }}</a>
                                </li>
                                @if($currentUser->inRole("teacher"))
                                    <li class="list-group-item">
                                        <b>Grade</b> <a
                                                class="pull-right"><b>{{ $currentUser->teacher->grade->name }}</b></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Subjects</b> <a class="pull-right"><b>{{ $currentUser->teacher->subjects }}</b></a>
                                    </li>
                                @else
                                    <li class="list-group-item">
                                        <b>Grade</b> <a
                                                class="pull-right"><b>{{ $currentUser->student->grade->name }}</b></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Balance</b> <a class="pull-right"><b>{{ $currentUser->student->balance }}</b></a>
                                    </li>
                                @endif
                            </ul>
                            <button id="btn-edit-account" class="btn btn-primary btn-block"><b>Edit account</b></button>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- About Me Box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">About Me</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <strong><i class="fa fa-book margin-r-5"></i> Biography</strong>

                            <p class="text-muted">
                                {{ $currentUser->profile->bio ?? "Write something about you..." }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

                            <p class="text-muted">{{ $currentUser->location->full_address ?? 'Not selected'}}</p>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#comments" data-toggle="tab">My lessons</a></li>

                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="comments">
                                @if(count($historyLessons))
                                    @foreach($historyLessons as $historyLesson)
                                        <div class="post">
                                            <div class="user-block">
                                                <img class="img-circle img-bordered-sm"
                                                     src="{{ asset('/storage/img/users/user1.png') }}" alt="user image">
                                                <span class="username">
                                <a href="#">Admin</a>
                                <a href="/" class="pull-right btn-box-tool remove-message"><i
                                            class="fa fa-times"></i></a>
                                </span>
                                                <span class="description">{{ $historyLesson->created_at }}</span>
                                            </div>
                                            <!-- /.user-block -->
                                            <p>
                                                @if($currentUser->inRole("teacher"))
                                                    You have a lesson with
                                                    student {{ $historyLesson->student->user->full_name ?? "" }}
                                                @else
                                                    You have a lesson with
                                                    teacher {{ $historyLesson->teacher->user->full_name ?? "" }}
                                                @endif
                                            </p>

                                        </div>
                                    @endforeach
                                    <div class="post">
                                        <a href="/">Show all lessons</a>
                                    </div>
                                @else
                                    <div class="post">
                                        No history lessons
                                    </div>
                                @endif
                            <!-- /.post -->
                                {{--@endforeach--}}

                            </div>
                            <!-- /.tab-pane -->

                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script type="text/javascript">

        $('#btn-edit-account').click(function () {
            location.href = "/edit-profile";
            return false;
        });

    </script>
@endsection
