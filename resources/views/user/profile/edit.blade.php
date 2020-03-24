@extends('layouts.frontend.main')

@section('title', 'Takweaya | Edit profile')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Profile
                <small>Edit profile</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/') }}"><i class="fa fa-dashboard"></i>Dashboard</a>
                </li>
                <li class="active">Edit profile</li>
            </ol>
        </section>

    <?php $currentUser = \App\User::where('id', Sentinel::getUser()->id)->firstOrFail() ?>

    <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body ">
                            @if(session('message'))
                                <div class="alert alert-info">
                                    {{ session('message') }}
                                </div>
                            @endif
                            {!! Form::model($user, [
                                'method' => 'POST',
                                'url' => 'edit-profile',
                                'files' => TRUE,
                                'id' => 'post-form'
                            ]) !!}

                            <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                {!! Form::label('First Name') !!}
                                {!! Form::text('first_name', null, ['class' => 'form-control']) !!}

                                @if($errors->has('first_name'))
                                    <span class="help-block">{{ $errors->first('first_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                {!! Form::label('Last Name') !!}
                                {!! Form::text('last_name', null, ['class' => 'form-control']) !!}

                                @if($errors->has('last_name'))
                                    <span class="help-block">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                {!! Form::label('Email') !!}
                                {!! Form::text('email', null, ['class' => 'form-control']) !!}

                                @if($errors->has('email'))
                                    <span class="help-block">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            @if($currentUser->inRole("teacher"))
                                {{--<div class="form-group {{ $errors->has('grade') ? 'has-error' : '' }}">--}}
                                    {{--{!! Form::label('Grade') !!}--}}
                                    {{--{!! Form::text('grade', $user->teacher->grade ?? '', ['class' => 'form-control']) !!}--}}

                                    {{--@if($errors->has('grade'))--}}
                                        {{--<span class="help-block">{{ $errors->first('grade') }}</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                                {{--<div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">--}}
                                    {{--{!! Form::label('Subject') !!}--}}
                                    {{--{!! Form::text('subject', $user->teacher->subject ?? '', ['class' => 'form-control']) !!}--}}

                                    {{--@if($errors->has('subject'))--}}
                                        {{--<span class="help-block">{{ $errors->first('subject') }}</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            @else
                                <div class="form-group {{ $errors->has('balance') ? 'has-error' : '' }}">
                                    {!! Form::label('Balance') !!}
                                    {!! Form::text('balance', $user->student->balance ?? '', ['class' => 'form-control']) !!}

                                    @if($errors->has('balance'))
                                        <span class="help-block">{{ $errors->first('balance') }}</span>
                                    @endif
                                </div>
                                {{--<div class="form-group {{ $errors->has('grade') ? 'has-error' : '' }}">--}}
                                    {{--{!! Form::label('Grade') !!}--}}
                                    {{--{!! Form::text('grade', $user->student->grade ?? '', ['class' => 'form-control']) !!}--}}

                                    {{--@if($errors->has('grade'))--}}
                                        {{--<span class="help-block">{{ $errors->first('grade') }}</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            @endif
                            <hr>

                            {!! Form::submit('Update user', ['class' => 'btn btn-primary']) !!}

                            {!! Form::close() !!}
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- ./row -->
        </section>
        <!-- /.content -->
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $('ul.pagination').addClass('no-margin pagination-sm');

    </script>
@endsection