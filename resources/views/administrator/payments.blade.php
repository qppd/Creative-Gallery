@include('administrator/includes/header')
{{-- @include('administrator/modals/payments') --}}

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
                            <h1>Payments</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                                <li class="breadcrumb-item active">Payments</li>
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

                        <div class="card" style="width:100%;">
                            <div class="card-header">
                                {{-- <a href="#add" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i
                                        class="fas fa-plus"></i> New</a> --}}
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Reference No.</th>
                                            {{-- <th>URL</th> --}}
                                            <th>Artwork</th>
                                            <th>Artist</th>
                                            <th>Amount</th>
                                            <th>Buyer</th>
                                            <th>Payment Status</th>
                                            <th>Created At</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($payments as $index => $payment)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $payment['reference_id'] }}</td>
                                                {{-- <td>{{ $payment['url'] }}</td> --}}
                                                <td>{{ $payment['art_name'] }}</td>
                                                <td>{{ $payment['artist_name'] }}</td>
                                                <td>{{ $payment['bidding_offer'] }}</td>
                                                <td>{{ $payment['enthusiast_name'] }}</td>
                                                @if ($payment['status'] == 1)
                                                    <td><span class="badge badge-success">Paid</span></td>
                                                @elseif ($payment['status'] == 0)
                                                    <td><span class="badge badge-danger">Unpaid</span></td>
                                                @endif
                                                <td>{{ $payment['created_at'] }}</td>
                                               
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

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

    {{-- <script>
        $(function() {

            $('#example1 tbody').on("click", ".edit", function() {
                $('#edit').modal('show');

                var id = $(this).data('id');
                var name = $(this).data('name');
                var status = $(this).data('status');

                console.log(id, name, status);

                $('#edit_id').val(id);
                $('#edit_name').val(name);
                $('#edit_status').val(status).change();

            });

            $('#example1 tbody').on("click", ".delete", function() {
                $('#delete').modal('show');
                var id = $(this).data('id');

                //$('#delete_id').val(id);

                var formAction = '/administrator/category/delete/' + id;
                $('#formDelete').attr('action', formAction);
            });


        });
    </script> --}}

</body>

</html>
