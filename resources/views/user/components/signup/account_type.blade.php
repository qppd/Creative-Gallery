<div class="row mb-2 justify-content-center">
    <div class="col-sm-4 text-center d-flex align-items-stretch">
        <div class="card flex-fill">
            <div class="card-header d-flex align-items-center justify-content-center">
                <h6>Are you an art enthusiast?</h6>
            </div>
            <div class="card-body">
                <img src="{{ asset('../storage/images/lover.png') }}" alt="Art Lover Image">
                <button onclick="handleCreateAccount()" class="btn btn-success btn-flat">
                    Create Account
                </button>
            </div>
        </div>
    </div>
    <div class="col-sm-4 text-center d-flex align-items-stretch">
        <div class="card flex-fill">
            <div class="card-header d-flex align-items-center justify-content-center">
                <h6>Are you an artist?</h6>
            </div>
            <div class="card-body">
                <img src="{{ asset('../storage/images/artist.png') }}" alt="Artist Image">
                <button onclick="handleCreateAccount2()" class="btn btn-success btn-flat">
                    Create Account
                </button>
            </div>
        </div>
    </div>
</div>
