@include('user/includes/header')
@include('user/modals/modal_signup')
<style type="text/css">
    .card-body img {
        width: 100%;
        height: auto;
        max-height: 200px;
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



            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-default">
                                <div class="card-body p-0">
                                    <div class="bs-stepper">
                                        <div class="bs-stepper-header" role="tablist">
                                            <div class="step" data-target="#choose-part">
                                                <button type="button" class="step-trigger" role="tab"
                                                    aria-controls="choose-part" id="choose-part-trigger">
                                                    <span class="bs-stepper-circle">1</span>
                                                    <span class="bs-stepper-label">Account Type</span>
                                                </button>
                                            </div>
                                            <div class="line"></div>
                                            <div class="step" data-target="#logins-part">
                                                <button type="button" class="step-trigger" role="tab"
                                                    aria-controls="logins-part" id="logins-part-trigger">
                                                    <span class="bs-stepper-circle">2</span>
                                                    <span class="bs-stepper-label">Personal Information</span>
                                                </button>
                                            </div>
                                            <div class="line"></div>
                                            <div class="step" data-target="#information-part">
                                                <button type="button" class="step-trigger" role="tab"
                                                    aria-controls="information-part" id="information-part-trigger">
                                                    <span class="bs-stepper-circle">3</span>
                                                    <span class="bs-stepper-label">Proof of Identity</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="bs-stepper-content">
                                            <form class="form-horizontal" id="signup_form" method="POST"
                                                action="/signup/add" enctype="multipart/form-data">
                                                @csrf
                                                <div id="choose-part" class="content" role="tabpanel"
                                                    aria-labelledby="choose-part-trigger">
                                                    <hr>
                                                    @include('user/components/signup/account_type')

                                                </div>
                                                <div id="logins-part" class="content" role="tabpanel"
                                                    aria-labelledby="logins-part-trigger">
                                                    <hr>
                                                    @include('user/components/signup/account_personal_information')

                                                    <button class="btn btn-primary"
                                                        onclick="stepper.previous()">Previous</button>
                                                    <!-- /.container-fluid -->
                                                    <button class="btn btn-primary"
                                                        onclick="stepper.next()">Next</button>
                                                </div>
                                                <div id="information-part" class="content" role="tabpanel"
                                                    aria-labelledby="information-part-trigger">
                                                    <hr>
                                                    @include('user/components/signup/account_proof_of_identity')
                                                    <button class="btn btn-primary"
                                                        onclick="stepper.previous()">Previous</button>
                                                    <button type="submit" class="btn btn-primary">Register</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('user/includes/footer')
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @include('user/includes/scripts')
    <script>
        document.getElementById('signup_form').addEventListener('submit', function(event) {
            var checkbox = document.getElementById('consentCheckbox');
            if (!checkbox.checked) {
                event.preventDefault(); // Prevent the form from submitting
                //alert('You must consent to the collection, use, and storage of your personal data.');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'));
        });

        $('#birthdate').datetimepicker({
            format: 'L'
        });
    </script>
    <script>
        function handleCreateAccount() {

            var placePhotoDiv = document.getElementById('place-photo-div');
            placePhotoDiv.style.display = 'none';

            $('#acc_type').val(1);
            // Proceed to the next step in your stepper (if needed)
            window.stepper.next(); // Assuming stepper is defined globally as in your original code
        }

        function handleCreateAccount2() {

            $('#acc_type').val(2);
            // Proceed to the next step in your stepper (if needed)
            window.stepper.next(); // Assuming stepper is defined globally as in your original code
        }
    </script>
    <script>
        $(function() {
            $('#signup_form').validate({
                rules: {
                    firstname: {
                        required: true,
                        minlength: 1,
                        maxlength: 50,
                        lettersOnly: true
                    },
                    lastname: {
                        required: true,
                        minlength: 2,
                        maxlength: 50,
                        lettersOnly: true
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 100
                    },
                    password: {
                        required: true,
                        minlength: 8,
                        maxlength: 20,
                        strongPassword: true
                    },
                    confirm_password: {
                        required: true,
                        minlength: 8,
                        maxlength: 20,
                        equalTo: "#password"
                    },
                    contact: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 15
                    },
                    birthday: {
                        required: true,
                        date: true,
                        validAge: true
                    },
                    avatar_photo: {
                        required: true,
                        accept: "image/*",
                        filesize: 2 * 1024 * 1024
                    },
                    place_photo: {
                        required: true,
                        accept: "image/*",
                        filesize: 2 * 1024 * 1024
                    },
                    id_photo: {
                        required: true,
                        accept: "image/*",
                        filesize: 2 * 1024 * 1024
                    },
                    selfie_photo: {
                        required: true,
                        accept: "image/*",
                        filesize: 2 * 1024 * 1024
                    },
                    terms: {
                        required: true
                    }
                },
                messages: {
                    firstname: {
                        required: "Please provide your first name",
                        minlength: "Your name must be at least 1 character long",
                        maxlength: "Your name cannot be longer than 50 characters",
                        lettersOnly: "Your name can only contain letters"
                    },
                    lastname: {
                        required: "Please provide your last name",
                        minlength: "Your name must be at least 2 characters long",
                        maxlength: "Your name cannot be longer than 50 characters",
                        lettersOnly: "Your name can only contain letters"
                    },
                    email: {
                        required: "Please enter an email address",
                        email: "Please enter a valid email address",
                        maxlength: "Your email cannot be longer than 100 characters"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 8 characters long",
                        maxlength: "Your password cannot be longer than 20 characters",
                        strongPassword: "Your password must contain at least one uppercase letter, one lowercase letter, one number, and one special character"
                    },
                    confirm_password: {
                        required: "Please confirm your password",
                        minlength: "Your confirmation password must be at least 8 characters long",
                        maxlength: "Your confirmation password cannot be longer than 20 characters",
                        equalTo: "Passwords do not match"
                    },
                    contact: {
                        required: "Please provide a contact number",
                        digits: "Your contact number must be digits only",
                        minlength: "Your contact number must be at least 10 characters long",
                        maxlength: "Your contact number cannot be longer than 15 characters"
                    },
                    birthday: {
                        required: "Please provide your birthdate",
                        date: "Please enter a valid date",
                        validAge: "You must be at least 18 years old"
                    },
                    avatar_photo: {
                        required: "Please upload your avatar photo",
                        accept: "Only image files are allowed",
                        filesize: "File size must be less than 2MB"
                    },
                    place_photo: {
                        required: "Please upload a place photo",
                        accept: "Only image files are allowed",
                        filesize: "File size must be less than 2MB"
                    },
                    id_photo: {
                        required: "Please upload your ID photo",
                        accept: "Only image files are allowed",
                        filesize: "File size must be less than 2MB"
                    },
                    selfie_photo: {
                        required: "Please upload a selfie photo",
                        accept: "Only image files are allowed",
                        filesize: "File size must be less than 2MB"
                    },
                    terms: "Please accept our terms"
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
            $.validator.addMethod("lettersOnly", function(value, element) {
                return this.optional(element) || /^[a-zA-Z ]+$/.test(value);
            }, "Please enter letters only");
            $.validator.addMethod("strongPassword", function(value, element) {
                    return this.optional(element) ||
                        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d])[A-Za-z\d@$!%*?&#^=+\-_`~(){}\[\]:;"'<>,.?\/\\|]{8,}$/
                        .test(value);
                },
                "Your password must contain at least one uppercase letter, one lowercase letter, one number, and one special character"
            );
            $.validator.addMethod("validAge", function(value, element) {
                console.log(value);
                var today = new Date();
                var birthDate = new Date(value);
                var age = today.getFullYear() - birthDate.getFullYear();
                var monthDifference = today.getMonth() - birthDate.getMonth();
                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate
                        .getDate())) {
                    age--;
                }
                return age >= 18;
            }, "You must be at least 18 years old");
            $.validator.addMethod("filesize", function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param);
            }, "File size must be less than 2MB");
        });
    </script>

    <script>
        @if (session()->has('success'))
            $(function() {
                $('#successModal').modal('show');
            });
        @endif
    </script>

</body>

</html>
