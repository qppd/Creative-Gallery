<!-- Approve -->
<div class="modal fade" id="approve">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Verification | Approve</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formApprove" class="form-horizontal" method="GET" action="">
                    @csrf
                    <div class="text-center">
                        <h2 class="bold"> Are you sure you want to approve this User?</h2>
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
<!-- Approve -->

<!-- Reject -->
<div class="modal fade" id="reject">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Verification | Reject</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formReject" class="form-horizontal" method="GET" action="">
                    @csrf
                    <div class="text-center">
                        <h2 class="bold"> Are you sure you want to reject this Account?</h2>
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

<!-- View -->
<div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="viewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="viewLabel">Verification | View</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row mb-3">
                        <div class="col-12 text-center">
                            <h5>Avatar Photo</h5>
                            <img src="{{ asset('../storage/images/blacklogo.png') }}" id="view_avatar_photo"
                                class="img-fluid" alt="Avatar Photo">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 text-center">
                            <h5>Place Photo</h5>
                            <img src="{{ asset('../storage/images/blacklogo.png') }}" id="view_place_photo"
                                class="img-fluid" alt="Place Photo">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 text-center">
                            <h5>ID Photo</h5>
                            <img src="{{ asset('../storage/images/blacklogo.png') }}" id="view_id_photo"
                                class="img-fluid" alt="ID Photo">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 text-center">
                            <h5>Selfie Photo</h5>
                            <img src="{{ asset('../storage/images/blacklogo.png') }}" id="view_selfie_photo"
                                class="img-fluid" alt="Selfie Photo">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- View -->
