<div class="row mb-2">
    <input type="hidden" id="acc_type" name="role" class="form-control" />
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="firstname" class="control-label">First
                Name</label>
            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Ex: John">
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="lastname" class="control-label">Last
                Name</label>
            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Ex: Mendoza">
        </div>

    </div>
</div>

<div class="row mb-2">
    <div class="col-12 col-sm-3 mb-2">

        <div class="form-group">
            <label for="birthdate" class="col-sm-12 control-label">Date of Birth</label>
            <div class="col-xs-12">
                <div class="input-group date" id="birthdate" data-target-input="nearest">
                    <input type="text" id="birthdateinput" name="birthdate" class="form-control datetimepicker-input" data-target="#birthdate"
                        placeholder="Ex: 05/07/1995" required />
                    <div class="input-group-append" data-target="#birthdate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-12 col-sm-3 mb-2">
        <div class="form-group">
            <label for="contact" class="col-sm-12 control-label">Contact No.</label>
            <div class="col-xs-12">
                <input type="text" class="form-control" id="contact" name="contact" placeholder="Ex: 09634905586"
                    oninput="this.value = this.value.replace(/[^0-9 ]/g, '');">
            </div>
        </div>

    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="email" class="col-sm-12 control-label">Email Address</label>
            <div class="col-xs-12">
                <input type="email" class="form-control" id="email" name="email"
                    placeholder="Ex: john@gmail.com">
            </div>
        </div>

    </div>
</div>

<div class="row mb-2">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" class="form-control"
                required="true" />
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <label for="confirm_password"> Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password"
                class="form-control" required="true" />
        </div>
    </div>
</div>

<hr>

<div class="row mb-2">
    <div class="col-12 col-sm-6 mb-2">
        <div class="form-group">
            <img src="{{ asset('../storage/images/avatars/user.jpg') }}" id="avatar_photo"
                class="" />
            <input type="file" placeholder="" class="file-chooser"
                onchange="document.getElementById('avatar_photo').src = window.URL.createObjectURL(this.files[0])"
                name="avatar_photo" alt="Avatar photo" required>
        </div>
        <label>* This will serve as your avatar photo on Creative Gallery</label>

    </div>

    <div class="col-12 col-sm-6 mb-2" id="place-photo-div">
        <div class="form-group">
            <img src="{{ asset('../storage/images/blacklogo.png') }}" id="place_photo"
                class="" />
            <input type="file" placeholder="" class="file-chooser"
                onchange="document.getElementById('place_photo').src = window.URL.createObjectURL(this.files[0])"
                name="place_photo" alt="Place photo" required>
        </div>
        <label>* This will serve as proof of work and workplace of the artist.</label>
    </div>
</div>
