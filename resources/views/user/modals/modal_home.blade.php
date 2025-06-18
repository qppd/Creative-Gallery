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

<!-- Add -->
<div class="modal fade" id="add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="/artwork/add" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="form-group">
                                <img src="{{ asset('../storage/images/blacklogo.png') }}" id="upload_photo"
                                    name="upload_photo" class="fixed-size-upload" />
                                <input type="file" placeholder="" class="file-chooser"
                                    onchange="document.getElementById('upload_photo').src = window.URL.createObjectURL(this.files[0])"
                                    id="photo" name="photo" alt="Upload photo" required>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="title" class="col-sm-12 control-label">Title of the Artwork</label>
                                <div class="col-xs-12">
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="Enter artwork's name here..."
                                        oninput="this.value = this.value.replace(/[^A-Z a-z ]/g, '');" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-sm-12 control-label">Description</label>
                                <div class="col-xs-12">
                                    <textarea rows="5" class="form-control" id="description" name="description"
                                        placeholder="Enter artwork's full description here..."
                                        oninput="this.value = this.value.replace(/[^A-Z a-z ]/g, '');" required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="category" class="col-sm-12 control-label">Category</label>
                                <div class="col-xs-12">
                                    <select class="form-control select2" id="category" name="category"
                                        style="width: 100%;">
                                        <option selected="selected">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="start_date" class="col-sm-12 control-label">Bidding Date</label>
                                <div class="col-xs-12">
                                    <div class="input-group date" id="start_date" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input"
                                            name="start_date" data-target="#start_date"
                                            placeholder="Enter bidding's date here..."
                                            oninput="this.value = this.value.replace(/[^0-9 / : P A M ]/g, '');" />
                                        <div class="input-group-append" data-target="#start_date"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="end_date" class="col-sm-12 control-label">End Date</label>
                                <div class="col-xs-12">
                                    <div class="input-group date" id="end_date" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input"
                                            placeholder="Enter bidding's end date here..." data-target="#end_date"
                                            name="end_date"
                                            oninput="this.value = this.value.replace(/[^0-9 / : P A M ]/g, '');" />
                                        <div class="input-group-append" data-target="#end_date"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="start_price" class="col-sm-12 control-label">Starting Price</label>
                                <div class="col-xs-12">
                                    <input type="text" class="form-control" id="start_price" name="start_price"
                                        placeholder="Enter artwork's price here..."
                                        oninput="this.value = this.value.replace(/[^0-9 ]/g, '');" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="video" class="col-sm-12 control-label">Proof of Authenticity</label>
                                <div class="col-xs-12">
                                    <input type="file" id="video" name="video" accept="video/*" required>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add -->

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
                                    <div class="watermark">Creative <br> Gallery</div>
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
                            <div class="row">
                                <div class="col">
                                    <h5 id="enthusiast_duration">Duration</h5>
                                </div>
                                {{-- <div class="col">
                                    <h5 id="enthusiast_end_date">End Date</h5>
                                </div> --}}
                            </div>
                            <p id="enthusiast_description"></p>
                            <hr>
                            <div class="bg-gray py-2 px-3 mt-4">
                                <h2 class="mb-0" id="enthusiast_start_price">
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

<!-- Accept -->
<div class="modal fade" id="accept">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Offer | Accept</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAccept" class="form-horizontal" method="GET" action="">
                    @csrf
                    <div class="text-center">
                        <h2 class="bold"> Are you sure you want to accept this Offer?</h2>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                <button type="submit" class="btn btn-success"> Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Accept -->

<!-- Reject -->
<div class="modal fade" id="reject">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Offer | Reject</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formReject" class="form-horizontal" method="POST" action="/reject-offer">
                    @csrf
                    <input type="hidden" id="rejectId" name="id" />
                    <div class="text-center">
                        <h2 class="bold"> Are you sure you want to reject this Offer?</h2>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Enter reason..." 
                                rows="3" id="rejectReason" name="reason"></textarea>
                            </div>

                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                <button type="submit" class="btn btn-danger"> Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Reject -->
