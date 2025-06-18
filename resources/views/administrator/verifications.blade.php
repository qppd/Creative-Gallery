@include('administrator/includes/header')
@include('administrator/modals/modal_verification')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ url('storage/images/blacklogo.png') }}" alt="Creative Gallery"
                height="180" width="180">
            <h1>Creative Gallery</h1>
        </div>
        @include('administrator/includes/navbar')
        @include('administrator/includes/menubar')
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Verification Requests</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                                <li class="breadcrumb-item active">Verification Requests</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
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
                    <div class="row">
                        <div class="card" style="width:100%;">
                            {{-- <div class="card-header">
                            </div> --}}
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Full Name</th>
                                            <th>Email Address</th>
                                            <th>Contact No.</th>
                                            <th>Account Type</th>
                                            <th>Status</th>
                                            <th>Date of Registration</th>
                                            <th>Tools</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($unverified_accounts as $index => $unverified_account)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $unverified_account['name'] }}</td>
                                                <td>{{ $unverified_account['email'] }}</td>
                                                <td>{{ $unverified_account['contact'] }}</td>
                                                @if ($unverified_account['role'] == 2)
                                                    <td><span class="badge badge-warning">Artist</span></td>
                                                @elseif ($unverified_account['role'] == 1)
                                                    <td><span class="badge badge-primary">Enthusiast/Buyer</span></td>
                                                @endif
                                                @if ($unverified_account['verification_status'] == 0)
                                                    <td><span class="badge badge-success">New</span></td>
                                                @endif
                                                <td>{{ $unverified_account['created_at'] }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm view"
                                                        data-id="{{ $unverified_account['id'] }}"
                                                        data-avatar="{{ $unverified_account['avatar'] }}"
                                                        data-place="{{ $unverified_account['place'] }}"
                                                        data-valid_id="{{ $unverified_account['valid_id'] }}"
                                                        data-selfie="{{ $unverified_account['selfie'] }}"><i
                                                            class="fas fa-eye"></i> View</button>
                                                    <button type="button" class="btn btn-danger btn-sm reject"
                                                        data-id="{{ $unverified_account['id'] }}"><i
                                                            class="fas fa-close"></i> Reject</button>
                                                    <button type="button" class="btn btn-success btn-sm approve"
                                                        data-id="{{ $unverified_account['id'] }}"><i
                                                            class="fas fa-check"></i> Approve</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
            </section>
        </div>
    </div>
    </section>
    </div>
    @include('administrator/includes/footer')
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    </div>
    @include('administrator/includes/scripts')
    <script>
        $(function() {
            $('#example1 tbody').on("click", ".view", function() {
                $('#view').modal('show');
                var avatar_photo = $(this).data('avatar');
                var place_photo = $(this).data('place');
                var id_photo = $(this).data('valid_id');
                var selfie_photo = $(this).data('selfie');
                $('#view_avatar_photo').attr('src', '../storage/images/avatars/' + avatar_photo);
                $('#view_place_photo').attr('src', '../storage/images/places/' + place_photo);
                $('#view_id_photo').attr('src', '../storage/images/ids/' + id_photo);
                $('#view_selfie_photo').attr('src', '../storage/images/selfies/' + selfie_photo);
            });
            $('#example1 tbody').on("click", ".approve", function() {
                $('#approve').modal('show');
                var id = $(this).data('id');
                var formAction = '/admin/verification/approve/' + id;
                $('#formApprove').attr('action', formAction);
            });
            $('#example1 tbody').on("click", ".reject", function() {
                $('#reject').modal('show');
                var id = $(this).data('id');
                var formAction = '/admin/verification/reject/' + id;
                $('#formReject').attr('action', formAction);
            });
        });
    </script>
</body>

</html>
