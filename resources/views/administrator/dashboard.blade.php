@include('administrator/includes/header')
{{-- @include('includes/modal_municipalities') --}}

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ url('storage/images/blacklogo.png') }}" alt="Creative Gallery"
                height="180" width="180">
            <h1>Creative Gallery</h1>
        </div>
        <!-- Preloader -->

        @include('administrator/includes/navbar')
        @include('administrator/includes/menubar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Dashboard</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">

                @if ($errors->any())
                    <div class='alert alert-danger alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h4><i class='icon fa fa-warning'></i> Error!</h4>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session()->has('success'))
                    <div class='alert alert-success alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h4><i class='icon fa fa-check'></i> Success!</h4>
                        <ul>
                            {{ session()->get('success') }}
                        </ul>
                    </div>
                @endif

                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">

                        <!-- ./col -->
                        <div class="col-sm-12 col-md-3 col-lg-3">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    @foreach ($users as $user)
                                        <h3>{{ $user['users'] }}</h3>
                                    @endforeach
                                    {{-- <h3>1</h3> --}}
                                    <p>Users</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a href="{{ url('/admin/accounts') }}" class="small-box-footer">More
                                    info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- ./col -->
                        <div class="col-sm-12 col-md-3 col-lg-3">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">

                                    @foreach ($arts as $art)
                                        <h3>{{ $art['arts'] }}</h3>
                                    @endforeach

                                    {{-- <h3>7</h3> --}}
                                    <p>Arts</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-palette"></i>
                                </div>
                                <a href="{{ url('/admin/bidding/requests') }}" class="small-box-footer">More
                                    info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- ./col -->
                        <div class="col-sm-12 col-md-3 col-lg-3">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    {{-- <h3>{{ $employee_count }}</h3> --}}
                                    @foreach ($solds as $sold)
                                        <h3>{{ $sold['arts'] }}</h3>
                                    @endforeach
                                    <p>Sold</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-palette"></i>
                                </div>
                                <a href="{{ url('/admin/bidding/sold') }}" class="small-box-footer">More
                                    info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- ./col -->
                        <div class="col-sm-12 col-md-3 col-lg-3">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    {{-- <h3>{{ $employee_count }}</h3> --}}
                                    @foreach ($biddings as $bidding)
                                        <h3>{{ $bidding['biddings'] }}</h3>
                                    @endforeach
                                    <p>Biddings</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <a href="{{ url('/admin/biddings') }}" class="small-box-footer">More
                                    info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <!-- BAR CHART -->
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Bidding Percentage</h3>

                                    <div class="card-tools">
                                        <select class="form-control select2" id="chartInterval"
                                            onchange="updateChart()">
                                            <option value="daily">Daily</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="monthly">Monthly</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <canvas id="barChart"
                                            style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;"></canvas>
                                        <button class="btn btn-primary btn-sm" onclick="printChart()"><i
                                                class="fas fa-print"></i> Print</button>


                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>


                </div>
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('administrator/includes/footer')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    @include('administrator/includes/scripts')
    <script>
        var biddings = <?php echo json_encode($daily_biddings_percentage); ?>;
        console.log(biddings);
        var labels = biddings.map(bidding => bidding.date);

        function updateChart() {
            var selectedInterval = document.getElementById('chartInterval').value;
            var updatedData = [];

            switch (selectedInterval) {
                case 'daily':
                    labels = biddings.map(bidding => bidding.date)
                    biddings = <?php echo json_encode($daily_biddings_percentage); ?>;
                    console.log(biddings);
                    updatedData = biddings.map(bidding => bidding.percentage);
                    legend = "Daily Percentage";
                    break;
                case 'weekly':
                    labels = biddings.map(bidding => bidding.date)
                    biddings = <?php echo json_encode($weekly_biddings_percentage); ?>;
                    console.log(biddings);
                    updatedData = biddings.map(bidding => bidding.percentage);
                    legend = "Weekly Percentage";

                    break;
                case 'monthly':
                    labels = biddings.map(bidding => bidding.month)
                    biddings = <?php echo json_encode($monthly_biddings_percentage); ?>;
                    console.log(biddings);
                    updatedData = biddings.map(bidding => bidding.percentage);
                    legend = "Monthly Percentage";

                    break;
                default:
                    labels = biddings.map(bidding => bidding.date)
                    biddings = <?php echo json_encode($daily_biddings_percentage); ?>;
                    console.log(biddings);
                    updatedData = biddings.map(bidding => bidding.percentage);
                    legend = "Daily Percentage";
                    break;
            }

            // Update chart data
            barChart.data.labels = labels;
            barChart.data.datasets[0].label = legend;
            barChart.data.datasets[0].data = updatedData;
            barChart.update();
        }


        const percentages = biddings.map(bidding => bidding.percentage);
        var legend = "Daily Percentage";

        const barChartData = {
            labels: labels,
            datasets: [{
                label: legend,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                hoverBackgroundColor: 'rgba(255, 99, 132, 0.4)',
                hoverBorderColor: 'rgba(255, 99, 132, 1)',
                data: percentages
            }]
        };

        var barChartCanvas = $('#barChart').get(0).getContext('2d');
        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        };

        var barChart = new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });
    </script>

</body>

</html>
