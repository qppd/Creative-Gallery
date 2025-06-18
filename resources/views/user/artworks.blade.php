@include('user/includes/header')
@include('user/modals/modal_artworks')
{{-- @include('user/modals/modal_subscription') --}}
<style>
    .fixed-size-img {
        height: 200px;
        width: 100%;
        object-fit: cover;
    }

    .image-container {
        position: relative;
        display: inline-block;
    }

    .product-image {
        display: block;
        width: 100%;
        /* Adjust as needed */
    }

    .watermark {
        position: absolute;
        bottom: 50%;
        /* Center vertically */
        left: 50%;
        /* Center horizontally */
        transform: translate(-50%, 50%);
        /* Adjust the center alignment */
        color: rgba(255, 255, 255, 0.5);
        /* Adjust color and opacity */
        font-size: 30px;
        /* Adjust as needed */
        font-weight: bold;
        text-align: center;
        /* Center the text */
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
        /* Optional shadow for better visibility */
        white-space: nowrap;
        /* Prevent the text from wrapping */
        max-width: 100%;
        /* Ensure the text fits within the image */
        overflow: hidden;
        /* Hide overflow if text is too long */
        text-overflow: ellipsis;
        /* Add ellipsis for overflowing text */
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ url('storage/images/blacklogo.png') }}" alt="Creative Gallery"
                height="180" width="180">
            <h1>Creative Gallery</h1>
        </div>
        @include('user/includes/menubar')
        @include('user/includes/topbar')
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
                    <div id="artwork-container" class="row">
                        @foreach ($arts as $index => $art)
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                                @if ($art['has_active_bid'] == 1)
                                    <div class="card" data-id="{{ $art['id'] }}" data-name="{{ $art['art_name'] }}"
                                        data-category_name="{{ $art['category_name'] }}"
                                        data-description="{{ $art['description'] }}"
                                        data-photo="{{ url('../storage/images/arts/' . $art['photo']) }}"
                                        data-starting-price="{{ $art['starting_price'] }}"
                                        data-latest-offer="{{ $art['highest_offer'] }}"
                                        data-start-date="{{ $art['start_date'] }}"
                                        data-end-date="{{ $art['end_date'] }}">
                                        @if ($art['art_status'] == 3)
                                            <div class="ribbon-wrapper ribbon-lg">
                                                <div class="ribbon bg-primary">
                                                    Sold
                                                </div>
                                            </div>
                                        @elseif ($art['has_active_bid'] == 1)
                                            <div class="ribbon-wrapper ribbon-lg">
                                                <div class="ribbon bg-danger">
                                                    For Payment
                                                </div>
                                            </div>
                                        @endif
                                        <div class="image-container">

                                            <img oncontextmenu="return false;"
                                                src="{{ url('../storage/images/arts/' . $art['photo']) }}"
                                                alt="ID" class="img-fluid fixed-size-img mb-2 product-image" />
                                            <div class="watermark">Creative Gallery</div>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <p class="d-flex flex-column">
                                                    <span class="text-bold text-lg">{{ $art['art_name'] }}</span>
                                                    <span>{{ $art['category_name'] }}</span>

                                                </p>
                                            </div>
                                            <div class="d-flex flex-row justify-content-between">
                                                <span>₱ {{ number_format($art['starting_price'], 2) }}</span>
                                                {{-- <span class="mr-2">
                                                <a href="#" class="btn btn-primary btn-flat btn-sm">VIEW</a>
                                            </span> --}}
                                            </div>
                                        </div>
                                    </div>
                                @elseif ($art['has_active_bid'] == 0)
                                    <div class="card @if ($art['art_status'] == 2 || ($art['art_status'] == 1 && session('role') == 1)) art-card @endif"
                                        data-id="{{ $art['id'] }}" data-name="{{ $art['art_name'] }}"
                                        data-category_name="{{ $art['category_name'] }}"
                                        data-description="{{ $art['description'] }}"
                                        data-photo="{{ url('../storage/images/arts/' . $art['photo']) }}"
                                        data-starting-price="{{ $art['starting_price'] }}"
                                        data-latest-offer="{{ $art['highest_offer'] }}"
                                        data-start-date="{{ $art['start_date'] }}"
                                        date-art_status="{{ $art['art_status'] }}"
                                        data-end-date="{{ $art['end_date'] }}">
                                        @if ($art['art_status'] == 3)
                                            <div class="ribbon-wrapper ribbon-lg">
                                                <div class="ribbon bg-primary">
                                                    Sold
                                                </div>
                                            </div>
                                        @elseif ($art['has_active_bid'] == 1 && $art['buyer_id'] == Auth::id())
                                            <div class="ribbon-wrapper ribbon-lg">
                                                <div class="ribbon bg-danger">
                                                    Waiting for Payment
                                                </div>
                                            </div>
                                        @elseif ($art['has_active_bid'] == 1)
                                            <div class="ribbon-wrapper ribbon-lg">
                                                <div class="ribbon bg-warning">
                                                    Not Available
                                                </div>
                                            </div>
                                        @endif



                                        <div class="image-container">

                                            <img oncontextmenu="return false;"
                                                src="{{ url('../storage/images/arts/' . $art['photo']) }}"
                                                alt="ID" class="img-fluid fixed-size-img mb-2 product-image" />
                                            <div class="watermark">Creative Gallery</div>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <p class="d-flex flex-column">
                                                    <span class="text-bold text-lg">{{ $art['art_name'] }}</span>
                                                    <span>{{ $art['category_name'] }}</span>

                                                </p>
                                            </div>
                                            <div class="d-flex flex-row justify-content-between">
                                                <span>₱ {{ number_format($art['starting_price'], 2) }}</span>
                                                {{-- <span class="mr-2">
                                                <a href="#" class="btn btn-primary btn-flat btn-sm">VIEW</a>
                                            </span> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endif


                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
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
        var user = @json(Auth::user());

        $(function() {
            $('.select2').select2()
            $('#start_date').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });
            $('#end_date').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });
        });

        $(document).ready(function() {
            //document.addEventListener('contextmenu', event => event.preventDefault());
            $('.art-card').on('click', function(e) {
                e.preventDefault();
                let card = $(this).closest('.art-card');

                if (user.subscription_status == false && user.role == 2) {
                    $('#view_as_artist_sub').modal('show');
                } else if (user.subscription_status == true && user.role == 2) {
                    $('#view_as_artist #view_photo').attr('src', card.data('photo'));
                    $('#view_as_artist #view_title').html(card.data('name'));
                    $('#view_as_artist #view_description').html(card.data('description'));
                    $('#view_as_artist #view_category').html(card.data('category_name'));
                    $('#view_as_artist #view_duration').html(card.data('duration'));
                    $('#view_as_artist #view_start_date').html(card.data('start-date'));
                    //$('#view_as_artist #view_end_date').html(card.data('end-date'));
                    $('#view_as_artist #view_start_price').html("₱" + card.data('starting-price'));
                    $('#view_as_artist #view_video').attr('src', card.data('video'));

                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            console.log(this.responseText);

                            var offers = JSON.parse(this.responseText);
                            productList.innerHTML = '';
                            var x = 0;
                            offers.forEach(element => {
                                console.log(element.id);
                                var li = document.createElement('li');
                                li.classList.add('item', 'd-flex', 'align-items-center',
                                    'justify-content-between');

                                var productImg = document.createElement('div');
                                productImg.classList.add('product-img');
                                var img = document.createElement('img');
                                img.src = '../storage/images/avatars/' + element.avatar;
                                img.alt = 'Product Image';
                                img.classList.add('img-size-50');
                                productImg.appendChild(img);

                                var productInfo = document.createElement('div');
                                productInfo.classList.add('product-info', 'd-flex',
                                    'flex-grow-1',
                                    'align-items-center', 'justify-content-between');
                                var productDetails = document.createElement('div');
                                productDetails.classList.add('product-details');

                                var productTitle = document.createElement('a');
                                productTitle.href = 'javascript:void(0)';
                                productTitle.classList.add('product-title');
                                productTitle.textContent = element.name;

                                var productDescription = document.createElement('span');
                                productDescription.classList.add('product-description');
                                productDescription.textContent = element.contact;

                                productDetails.appendChild(productTitle);
                                productDetails.appendChild(productDescription);
                                productInfo.appendChild(productDetails);

                                if (x == 0) {
                                    x++;

                                    var btnGroupContainer = document.createElement('div');
                                    btnGroupContainer.classList.add('d-flex',
                                        'align-items-start',
                                        'ml-auto');

                                    var badge = document.createElement('span');
                                    badge.classList.add('badge', 'badge-success', 'mr-2');
                                    badge.textContent = '₱' + element.offer;

                                    var btnGroup = document.createElement('div');
                                    btnGroup.classList.add('btn-group', 'role-group');

                                    var rejectBtn = document.createElement('button');
                                    rejectBtn.type = 'button';
                                    rejectBtn.classList.add('btn', 'btn-danger', 'btn-xs',
                                        'reject');
                                    rejectBtn.innerHTML = '<i class="fas fa-close"></i>';
                                    rejectBtn.setAttribute('data-id', element.id);
                                    btnGroup.appendChild(rejectBtn);

                                    var acceptBtn = document.createElement('button');
                                    acceptBtn.type = 'button';
                                    acceptBtn.classList.add('btn', 'btn-success', 'btn-xs',
                                        'accept');
                                    acceptBtn.innerHTML = '<i class="fas fa-check"></i>';
                                    acceptBtn.setAttribute('data-id', element.id);
                                    btnGroup.appendChild(acceptBtn);

                                    btnGroupContainer.appendChild(badge);
                                    btnGroupContainer.appendChild(btnGroup);

                                    productInfo.appendChild(btnGroupContainer);
                                }

                                li.appendChild(productImg);
                                li.appendChild(productInfo);
                                productList.appendChild(li);
                            });


                            $('#view_as_artist').modal('show');
                        }
                    };
                    var url = "/home/offers";

                    var params = "id=" + card.data('id') + "&_token=" +
                        encodeURIComponent(
                            '{{ csrf_token() }}');

                    console.log(params);
                    xhr.open("POST", url, true);

                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.send(params);

                }
            });
        });
    </script>

    <script>
        $(function() {
            // Event delegation for accept button click
            $(document).on('click', '.accept', function(e) {
                e.preventDefault();
                // var notificationId = $(this).closest('.dropdown-item').data('notification-id');
                var id = $(this).data('id');

                console.log("ACCEPT ID:" + id);

                $('#accept').modal('show');
                var formAction = '/accept-offer/' + id;
                $('#formAccept').attr('action', formAction);

            });
            // Event delegation for reject button click
            $(document).on('click', '.reject', function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                $('#rejectId').val(id);

                console.log("REJECT ID:" + id);
                $('#reject').modal('show');
                // var formAction = '/reject-offer/' + notificationId;
                // $('#formReject').attr('action', formAction);

            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const availableFilter = document.getElementById('available-filter');
            const soldFilter = document.getElementById('sold-filter');

            availableFilter.addEventListener('click', function() {
                console.log("Available");

                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var arts = JSON.parse(this.responseText);
                        var container = document.getElementById('artwork-container');
                        container.innerHTML = ''; // Clear previous content

                        arts.forEach(art => {
                            var card = document.createElement('div');
                            card.classList.add('col-lg-3', 'col-md-3', 'col-sm-12',
                            'col-xs-12');

                            var ribbon = '';
                            if (art.has_active_bid == 1) {
                                if (art.art_status == 3) {
                                    ribbon = `<div class="ribbon-wrapper ribbon-lg">
                                  <div class="ribbon bg-primary">Sold</div>
                              </div>`;
                                } else if (art.has_active_bid == 1) {
                                    ribbon = `<div class="ribbon-wrapper ribbon-lg">
                                  <div class="ribbon bg-danger">For Payment</div>
                              </div>`;
                                }
                            } else if (art.art_status == 3) {
                                ribbon = `<div class="ribbon-wrapper ribbon-lg">
                              <div class="ribbon bg-primary">Sold</div>
                          </div>`;
                            } else if (art.has_active_bid == 1 && art.buyer_id == Auth
                                .id) { // Adjust this as per your auth logic
                                ribbon = `<div class="ribbon-wrapper ribbon-lg">
                              <div class="ribbon bg-danger">Waiting for Payment</div>
                          </div>`;
                            } else if (art.has_active_bid == 1) {
                                ribbon = `<div class="ribbon-wrapper ribbon-lg">
                              <div class="ribbon bg-warning">Not Available</div>
                          </div>`;
                            }

                            var photoUrl = '/storage/images/arts/' + art.photo;

                            card.innerHTML = `
                <div class="card" data-id="${art.id}" data-name="${art.art_name}"
                    data-category_name="${art.category_name}"
                    data-description="${art.description}"
                    data-photo="${photoUrl}"
                    data-starting-price="${art.starting_price}"
                    data-latest-offer="${art.highest_offer}"
                    data-start-date="${art.start_date}"
                    data-end-date="${art.end_date}">
                    ${ribbon}
                    <div class="image-container">
                        <img oncontextmenu="return false;" src="${photoUrl}"
                            alt="ID" class="img-fluid fixed-size-img mb-2 product-image" />
                        <div class="watermark">Creative Gallery</div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">${art.art_name}</span>
                                <span>${art.category_name}</span>
                            </p>
                        </div>
                        <div class="d-flex flex-row justify-content-between">
                            <span>₱ ${parseFloat(art.starting_price).toFixed(2)}</span>
                        </div>
                    </div>
                </div>
            `;

                            container.appendChild(card);
                        });
                    }
                };

                var url = "/artworks/available?_token=" + encodeURIComponent('{{ csrf_token() }}');
                xhr.open("GET", url, true);
                xhr.send();


            });

            soldFilter.addEventListener('click', function() {
                console.log("Sold");

                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var arts = JSON.parse(this.responseText);
                        var container = document.getElementById('artwork-container');
                        container.innerHTML = ''; // Clear previous content

                        arts.forEach(art => {
                            var card = document.createElement('div');
                            card.classList.add('col-lg-3', 'col-md-3', 'col-sm-12',
                                'col-xs-12');

                            var ribbon = '';
                            if (art.has_active_bid == 1) {
                                if (art.art_status == 3) {
                                    ribbon = `<div class="ribbon-wrapper ribbon-lg">
                                  <div class="ribbon bg-primary">Sold</div>
                              </div>`;
                                } else if (art.has_active_bid == 1) {
                                    ribbon = `<div class="ribbon-wrapper ribbon-lg">
                                  <div class="ribbon bg-danger">For Payment</div>
                              </div>`;
                                }
                            } else if (art.art_status == 3) {
                                ribbon = `<div class="ribbon-wrapper ribbon-lg">
                              <div class="ribbon bg-primary">Sold</div>
                          </div>`;
                            } else if (art.has_active_bid == 1 && art.buyer_id == Auth
                                .id) { // Adjust this as per your auth logic
                                ribbon = `<div class="ribbon-wrapper ribbon-lg">
                              <div class="ribbon bg-danger">Waiting for Payment</div>
                          </div>`;
                            } else if (art.has_active_bid == 1) {
                                ribbon = `<div class="ribbon-wrapper ribbon-lg">
                              <div class="ribbon bg-warning">Not Available</div>
                          </div>`;
                            }

                            var photoUrl = '/storage/images/arts/' + art.photo;

                            card.innerHTML = `
                <div class="card" data-id="${art.id}" data-name="${art.art_name}"
                    data-category_name="${art.category_name}"
                    data-description="${art.description}"
                    data-photo="${photoUrl}"
                    data-starting-price="${art.starting_price}"
                    data-latest-offer="${art.highest_offer}"
                    data-start-date="${art.start_date}"
                    data-end-date="${art.end_date}">
                    ${ribbon}
                    <div class="image-container">
                        <img oncontextmenu="return false;" src="${photoUrl}"
                            alt="ID" class="img-fluid fixed-size-img mb-2 product-image" />
                        <div class="watermark">Creative Gallery</div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">${art.art_name}</span>
                                <span>${art.category_name}</span>
                            </p>
                        </div>
                        <div class="d-flex flex-row justify-content-between">
                            <span><b>Starting Price:</b><br>₱ ${parseFloat(art.starting_price).toFixed(2)}</span>
                        </div>

                         <div class="d-flex flex-row justify-content-between">
                            <span><b>Date:</b><br>${art.bid_at}</span>
                        </div>

                        <div class="d-flex flex-row justify-content-between">
                            <span><b>Sold:</b><br>₱ ${parseFloat(art.highest_offer).toFixed(2)}</span>
                        </div>

                       
                    </div>
                </div>
            `;

                            container.appendChild(card);
                        });
                    }
                };

                var url = "/artworks/sold?_token=" + encodeURIComponent('{{ csrf_token() }}');
                xhr.open("GET", url, true);
                xhr.send();


            });


        });
    </script>

</body>

</html>
