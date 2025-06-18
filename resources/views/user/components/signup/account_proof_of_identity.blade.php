<div class="row mb-2">
    <div class="col-12 col-sm-6 mb-2">
        <div class="form-group">
            <img src="{{ asset('../storage/images/ids/id.jpg') }}" id="id_photo" class="" />
            <input type="file" placeholder="" class="file-chooser"
                onchange="document.getElementById('id_photo').src = window.URL.createObjectURL(this.files[0])"
                name="valid_id_photo" alt="ID photo" required>
        </div>
        <label>* Upload any government valid ID.</label>

    </div>

    <div class="col-12 col-sm-6 mb-2">
        <div class="form-group">
            <img src="{{ asset('../storage/images/blacklogo.png') }}" id="selfie_photo" class="" />
            <input type="file" placeholder="" class="file-chooser"
                onchange="document.getElementById('selfie_photo').src = window.URL.createObjectURL(this.files[0])"
                name="selfie_photo" alt="Selfie photo" required>
        </div>
        <label>* Upload a picture while holding your ID.</label>
    </div>
</div>
<div class="row mb-2">
    <div class="col-12 col-sm-12 mb-2">
        <input id="consentCheckbox" type="checkbox"> </input>
        <label for="consentCheckbox">
            I hereby consent to the collection, use, and storage of my personal data in accordance with the Data Privacy
            Act of 2012 (Republic Act No. 10173).
        </label>
    </div>
    {{-- <div class="col-12 col-sm-12 mb-2">



        <input class="" type="checkbox" required />
        <label class="">I hereby consent to the collection, use, and storage of my personal data
            in accordance with the Data Privacy Act of 2012 (Republic Act No. 10173).</label>



    </div> --}}
</div>
