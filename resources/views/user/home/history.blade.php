@extends('layouts.frontend.main')

@section('style')
    <style>
        .box-body {
            overflow-y: auto;
        }

        .table.table-bordered {
            min-width: 700px;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                History
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> History</li>
            </ol>
        </section>
        <?php $currentUser = \App\User::where('id', Sentinel::getUser()->id)->firstOrFail() ?>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body ">
                            @if(session('message'))
                                <div class="alert alert-info">
                                    {{ session('message') }}
                                </div>
                            @endif

                            @if(! $historyMessages->count())
                                <div class="alert alert-danger">
                                    <strong>No record found</strong>
                                </div>
                            @else
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td width="40">Action</td>
                                        <td>Author</td>
                                        <td>Message</td>
                                        <td>Username</td>
                                        <td>Points</td>
                                        <td width="270">Data</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($historyMessages as $historyMessage)
                                        <tr>
                                            <td>
                                                {!! Form::open(['method' => 'DELETE', 'url' => ['remove-message', $historyMessage->id]]) !!}
                                                <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Do you want to delete this notification?')">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                                {!! Form::close() !!}
                                            </td>
                                            <td>Admin</td>
                                            <td>You earn {{ \App\Point::COUNT_OF_POINTS }} points for visited new
                                                user {{ $historyMessage->telegram_user_first_name . " " . $historyMessage->telegram_user_last_name }}
                                            </td>
                                            <td>{{$historyMessage->telegram_user_username}}</td>
                                            <td>{{\App\Point::COUNT_OF_POINTS}}</td>
                                            <td>{{ $historyMessage->created_at }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                {{ $historyMessages->render() }}
                            </div>
                            <div class="pull-right">
                                <small>{{ $historyMessagesCount }} {{ str_plural('Item', $historyMessagesCount) }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection