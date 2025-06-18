<style>
    .fixed-size-upload {
        height: 450px;
        width: 100%;
        object-fit: cover;
    }
</style>

<!-- Add -->
<div class="modal fade" id="profile">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">My Profile</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="/profile/edit" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Widget: user widget style 1 -->
                            <div class="card card-widget widget-user">
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header bg-info">
                                    <h3 class="widget-user-username">{{ session('name') }}</h3>
                                    <h5 class="widget-user-desc">{{ session('type') }}</h5>
                                </div>
                                <div class="widget-user-image">
                                    <img class="img-circle elevation-2" height="64" width="64"
                                        src="{{ asset('../storage/images/avatars/' . session('photo')) }}"
                                        alt="User Avatar">
                                </div>
                                <div class="card-footer p-0">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                CONTACT <span
                                                    class="float-right badge bg-primary">{{ session('contact') }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                EMAIL <span
                                                    class="float-right badge bg-info">{{ session('email') }}</span>
                                            </a>
                                        </li>
                                        {{-- <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                Completed Projects <span class="float-right badge bg-success">12</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                Followers <span class="float-right badge bg-danger">842</span>
                                            </a>
                                        </li> --}}
                                    </ul>
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->
                    </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">UPDATE</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add -->

<!-- View -->
<div class="modal fade" id="view_as_artist">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <h3 class="d-inline-block d-sm-none" id="view_title"></h3>
                            <div class="col-12">
                                <img src="{{ asset('../storage/images/blacklogo.png') }}" id="view_photo"
                                    class="product-image" alt="Product Image">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <h3 class="my-3" id="view_title"></h3>
                            <div class="row">
                                <div class="col">
                                    <p id="view_category">Category</p>
                                </div>
                                <div class="col">
                                    <p id="view_start_date">Start Date</p>
                                </div>
                            </div>
                            <p id="view_description"></p>
                            <hr>
                            <div class="bg-gray py-2 px-3 mt-4">
                                <h2 class="mb-0" id="view_start_price">
                                </h2>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<!-- View -->
