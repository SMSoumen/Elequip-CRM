@extends('admin.layouts.master')

@section('main_content')
    <x-breadcrumb />

    <style>
        .custom-small-box {
            box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
            margin-bottom: 25px;
        }

        .custom-small-box .icon-box {
            background: #f3f5f6;
            border-radius: 50%;
            line-height: 20px;
        }

        .custom-small-box .icon>i.ion {
            font-size: 30px;

        }

        .icon-box {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .custom-small-box .icon>i.ion:nth-child(1) {
            color: #08d26f;
        }

        .violet-text {
            color: #857bff;
        }

        .green-text {
            color: #08d26f;
        }

        .red-text {
            color: #ff7474;
        }

        .custom-small-box .icon>i.fas {
            font-size: 25px;
        }
      
        .custom-small-box .inner p {
            font-size: 15px;
        }
        .chart-box{
            box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
        }
    </style>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="bg-white p-3 custom-small-box">
                        <div class="row">
                            <div class="col-3">
                                <div class="icon-box">
                                    <div class="icon">
                                        <i class="ion ion-cube"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="inner">
                                    <p class="mb-1">Total Quotations</p>
                                    <h5><b>{{ $quotation_amount ? moneyFormatIndia($quotation_amount) : $quotation_amount }}</b>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="bg-white p-3 custom-small-box">
                        <div class="row">
                            <div class="col-3">
                                <div class="icon-box">
                                    <div class="icon green-text">
                                        <i class="fas fa-filter"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="inner">
                                    <p class="mb-1">Active Quotations</p>
                                    <h5><b>{{ $active_quot_amount ? moneyFormatIndia($active_quot_amount) : $active_quot_amount }}</b>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="bg-white p-3 custom-small-box">
                        <div class="row">
                            <div class="col-3">
                                <div class="icon-box">
                                    <div class="icon violet-text">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="inner">
                                    <p class="mb-1">P.O.</p>
                                    <h5><b>{{ $po_amount ? moneyFormatIndia($po_amount) : $po_amount }}</b></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="bg-white p-3 custom-small-box">
                        <div class="row">
                            <div class="col-3">
                                <div class="icon-box">
                                    <div class="icon red-text">
                                        <i class="fas fa-user-friends"></i>
                                        {{-- <i class="ion ion-people"></i> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="inner">
                                    <p class="mb-1">A/c Closed</p>
                                    <h5><b>{{ $closed_amount ? moneyFormatIndia($closed_amount) : $closed_amount }}</b></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- Main row -->
            <div class="row d-none">
                <!-- Left col -->
                <section class="col-lg-7 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Sales
                            </h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane active" id="revenue-chart"
                                    style="position: relative; height: 300px;">
                                    <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                                <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </section>
                <!-- /.Left col -->
                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-5 connectedSortable d-none">

                    <!-- TO DO List -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ion ion-clipboard mr-1"></i>
                                To Do List
                            </h3>

                            <div class="card-tools">
                                <ul class="pagination pagination-sm">
                                    <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
                                    <li class="page-item"><a href="#" class="page-link">1</a></li>
                                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                                    <li class="page-item"><a href="#" class="page-link">3</a></li>
                                    <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <ul class="todo-list" data-widget="todo-list">
                                <li>
                                    <!-- drag handle -->
                                    <span class="handle">
                                        <i class="fas fa-ellipsis-v"></i>
                                        <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <!-- checkbox -->
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" value="" name="todo1" id="todoCheck1">
                                        <label for="todoCheck1"></label>
                                    </div>
                                    <!-- todo text -->
                                    <span class="text">Design a nice theme</span>
                                    <!-- Emphasis label -->
                                    <small class="badge badge-danger"><i class="far fa-clock"></i> 2 mins</small>
                                    <!-- General tools such as edit or delete-->
                                    <div class="tools">
                                        <i class="fas fa-edit"></i>
                                        <i class="fas fa-trash-o"></i>
                                    </div>
                                </li>
                                <li>
                                    <span class="handle">
                                        <i class="fas fa-ellipsis-v"></i>
                                        <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" value="" name="todo2" id="todoCheck2" checked>
                                        <label for="todoCheck2"></label>
                                    </div>
                                    <span class="text">Make the theme responsive</span>
                                    <small class="badge badge-info"><i class="far fa-clock"></i> 4 hours</small>
                                    <div class="tools">
                                        <i class="fas fa-edit"></i>
                                        <i class="fas fa-trash-o"></i>
                                    </div>
                                </li>
                                <li>
                                    <span class="handle">
                                        <i class="fas fa-ellipsis-v"></i>
                                        <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" value="" name="todo3" id="todoCheck3">
                                        <label for="todoCheck3"></label>
                                    </div>
                                    <span class="text">Let theme shine like a star</span>
                                    <small class="badge badge-warning"><i class="far fa-clock"></i> 1 day</small>
                                    <div class="tools">
                                        <i class="fas fa-edit"></i>
                                        <i class="fas fa-trash-o"></i>
                                    </div>
                                </li>
                                <li>
                                    <span class="handle">
                                        <i class="fas fa-ellipsis-v"></i>
                                        <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" value="" name="todo4" id="todoCheck4">
                                        <label for="todoCheck4"></label>
                                    </div>
                                    <span class="text">Let theme shine like a star</span>
                                    <small class="badge badge-success"><i class="far fa-clock"></i> 3 days</small>
                                    <div class="tools">
                                        <i class="fas fa-edit"></i>
                                        <i class="fas fa-trash-o"></i>
                                    </div>
                                </li>
                                <li>
                                    <span class="handle">
                                        <i class="fas fa-ellipsis-v"></i>
                                        <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" value="" name="todo5" id="todoCheck5">
                                        <label for="todoCheck5"></label>
                                    </div>
                                    <span class="text">Check your messages and notifications</span>
                                    <small class="badge badge-primary"><i class="far fa-clock"></i> 1 week</small>
                                    <div class="tools">
                                        <i class="fas fa-edit"></i>
                                        <i class="fas fa-trash-o"></i>
                                    </div>
                                </li>
                                <li>
                                    <span class="handle">
                                        <i class="fas fa-ellipsis-v"></i>
                                        <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" value="" name="todo6" id="todoCheck6">
                                        <label for="todoCheck6"></label>
                                    </div>
                                    <span class="text">Let theme shine like a star</span>
                                    <small class="badge badge-secondary"><i class="far fa-clock"></i> 1 month</small>
                                    <div class="tools">
                                        <i class="fas fa-edit"></i>
                                        <i class="fas fa-trash-o"></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <button type="button" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add
                                item</button>
                        </div>
                    </div>
                    <!-- /.card -->

                </section>
                <!-- right col -->
            </div>

            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 grid-margin stretch-card">
                    <div class="card card-statistics">
                        <div class="card-body chart-box">
                            <section class="panel">
                                <div class="panel-body text-center" id="line">
                                    <canvas height="300" width="450"></canvas>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['line']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Day');
            data.addColumn('number', 'Leads');
            data.addColumn('number', 'Quotations');
            data.addColumn('number', 'P.O.');
            data.addColumn('number', 'A/c Closed');

            data.addRows([
                <?php
                for ($i = 0; $i < 7; $i++) {
                    if (!isset($total_counts[$i])) {
                        $date = '';
                        $leads_per_day = $quot_per_day = $po_per_day = $ac_per_day = 0;
                    } else {
                        $date = $total_counts[$i]['date'];
                        $leads_per_day = $total_counts[$i]['leads_per_day'];
                        $quot_per_day = $total_counts[$i]['quot_per_day'];
                        $po_per_day = $total_counts[$i]['po_per_day'];
                        $ac_per_day = $total_counts[$i]['ac_per_day'];
                    }
                    echo "['$date', $leads_per_day, $quot_per_day, $po_per_day, $ac_per_day],";
                }
                ?>
            ]);
            var options = {
                chart: {
                    title: 'Last 7 Day Activity',
                    subtitle: ''
                },
                axes: {
                    x: {
                        0: {
                            side: 'top'
                        }
                    }
                },
            };

            var chart = new google.charts.Line(document.getElementById('line'));

            chart.draw(data, google.charts.Line.convertOptions(options));
        }
    </script>
@endpush
