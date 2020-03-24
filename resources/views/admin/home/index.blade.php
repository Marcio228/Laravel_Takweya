@extends('layouts.backend.main')

@section('title', 'Takweya | Dashboard')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Admin panel
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-folder"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Telegram users</span>
                            <span class="info-box-number">{{ $usersCount }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="ion ion-ios-paper"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Students</span>
                            <span class="info-box-number">{{ $studentsCount }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="ion ion-email"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Teachers</span>
                            <span class="info-box-number">{{ $teachersCount }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <i class="fa fa-bar-chart-o"></i>

                            <h3 class="box-title">Users</h3>

                        </div>
                        <div class="box-body">
                            <div id="bar-chart" style="height: 284px;"></div>
                        </div>
                        <!-- /.box-body-->
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Last added users</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <ul class="products-list product-list-in-box">
                                @foreach($recentlyUsers as $user)
                                    <li class="item">
                                        <div class="product-img">
                                            <img src="{{ asset('/storage/img/users/user1.png') }}" alt="Post Image">
                                        </div>
                                        <div class="product-info">
                                            <a href="/admin" class="product-title">{{$user->email}}
                                                <span class="label label-warning pull-right">{{$user->created_at}}</span></a>
                                            <span class="product-description">
                                                {{ $user->full_name }}
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('script')
    <script>
        var bar_data = {
            data : [
                    @foreach ($chartMessages as $chartMessage)
                [' {{  $chartMessage['monthName'] }} ', {{ $chartMessage['count'] }}],
                @endforeach
            ],
            color: '#3c8dbc'
        }
        $.plot('#bar-chart', [bar_data], {
            grid: {
                borderWidth: 1,
                borderColor: '#f3f3f3',
                tickColor: '#f3f3f3'
            },
            series: {
                bars: {
                    show: true,
                    barWidth: 0.5,
                    align: 'center'
                }
            },
            xaxis: {
                mode: 'categories',
                tickLength: 0
            }
        })
    </script>
@endsection