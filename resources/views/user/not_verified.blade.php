@include('user/includes/header')
<style>
    .fixed-size-img {
        height: 200px;
        width: 100%;
        object-fit: cover;
    }
</style>

<body class="hold-transition layout-top-nav control-sidebar-push-slide">
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ url('storage/images/blacklogo.png') }}" alt="Creative Gallery"
                height="180" width="180">
            <h1>Creative Gallery</h1>
        </div>
        @include('user/includes/navbar')
        <div class="content-wrapper">
            <section class="content-header">
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
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        @foreach ($arts as $index => $art)
                            <div class="col-lg-3">
                                <div class="card">
                                    <img src="{{ url('../storage/images/arts/' . $art['photo']) }}" alt="ID"
                                        class="img-fluid fixed-size-img mb-2" />
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <p class="d-flex flex-column">
                                                <span class="text-bold text-lg">{{ $art['name'] }}</span>
                                                <span>{{ $art['category_id'] }}</span>
                                                <span>{{ $art['description'] }}</span>
                                            </p>
                                        </div>
                                        <div class="d-flex flex-row justify-content-between">
                                            <span>₱ {{ number_format($art['starting_price'], 2) }}</span>
                                            <span class="mr-2">
                                                <a href="/signup" class="btn btn-primary btn-flat btn-sm"> BID</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
    </section>
    </div>
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    @include('user/includes/footer')
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    </div>
    @include('user/includes/scripts')
    <script>
        $(document).ready(function() {
            document.addEventListener('contextmenu', event => event.preventDefault());

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            alert(
                'Your account is still undergoing the verification process. Please wait until we have finished verifying it.'
                );
        });
    </script>
</body>

</html>
