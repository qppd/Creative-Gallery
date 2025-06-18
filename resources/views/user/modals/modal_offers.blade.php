<style>
    .fixed-size-upload {
        height: 450px;
        width: 100%;
        object-fit: cover;
    }

    .avatar-upload {
        height: 480px;
        width: 640px;
        object-fit: cover;
    }

    .place-upload {
        height: 480px;
        width: 640px;
        object-fit: cover;
    }
</style>

<!-- View as Artist -->
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

                                <div class="image-container">
                                    <img oncontextmenu="return false;"
                                        src="{{ asset('../storage/images/blacklogo.png') }}" alt="ID"
                                        id="view_photo" class="product-image" />
                                    <div class="watermark">Creative <br> Gallery</div>
                                </div>
                                {{-- <img oncontextmenu="return false;" src="{{ asset('../storage/images/blacklogo.png') }}" id="view_photo"
                                    class="product-image" alt="Product Image"> --}}
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
                            <div class="row">
                                <div class="col">
                                    <h5 id="view_duration">Duration</h5>
                                </div>
                                {{-- <div class="col">
                                    <h5 id="view_end_date">End Date</h5>
                                </div> --}}
                            </div>
                            <p id="view_description"></p>
                            <hr>
                            <div class="bg-gray py-2 px-3 mt-4">
                                <h2 class="mb-0" id="view_start_price">
                                </h2>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">All Offers - Highest to Lowest</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <ul class="products-list product-list-in-card pl-2 pr-2" id="productList">
                                        <!-- List items will be dynamically added here -->
                                    </ul>
                                </div>

                                {{-- <div class="card-footer text-center">
                                    <a href="javascript:void(0)" class="uppercase">View All Offers</a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- View -->

<!-- View as Enthusiast -->
<div class="modal fade" id="view_as_buyer">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="/home/offer">
                    @csrf
                    <input type="hidden" id="enthusiast_art_id" name="art_id" />

                    <p>Note. Same offer is not allowed.</p>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <h3 class="d-inline-block d-sm-none" id="enthusiast_title"></h3>
                            <div class="col-12">
                                <div class="image-container">
                                    <img oncontextmenu="return false;"
                                        src="{{ asset('../storage/images/blacklogo.png') }}" alt="ID"
                                        id="enthusiast_photo" class="product-image" />
                                    <div class="watermark">Creative Gallery</div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-12">
                                <div class="form-group">
                                    <p>Enter your offer here in Philippine currency.</p>
                                    <input type="text" class="form-control form-control-lg" id="offer"
                                        name="offer" placeholder="Ex: 1000">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <h3 class="my-3" id="enthusiast_title"></h3>
                            <div class="row">
                                <div class="col">
                                    <h5 id="enthusiast_category">Category</h5>
                                </div>
                                <div class="col">
                                    <h5 id="enthusiast_start_date">Start Date</h5>
                                </div>
                            </div>
                            <p id="enthusiast_description"></p>
                            <hr>
                            <div class="bg-gray py-2 px-3 mt-4">
                                <label>Starting Price</label>
                                <h2 class="mb-0" id="enthusiast_start_price">
                                </h2>
                            </div>
                            <div class="bg-green py-2 px-3 mt-4">
                                <label>Highest Offer</label>
                                <h2 class="mb-0" id="enthusiast_latest_offer">
                                </h2>
                            </div>
                        </div>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Send Offer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View -->
