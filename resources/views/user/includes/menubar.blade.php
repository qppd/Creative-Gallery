<aside class="main-sidebar sidebar-light-primary elevation-4">
    <a href="{{ url('/home') }}" class="brand-link">
        <img src="{{ url('storage/images/blacklogo.png') }}" alt="Creative Gallery"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Creative<b>Gallery</b></span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Home -->
                <li class="nav-item">
                    <a href="{{ url('/home') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>
                <!-- Messages -->
                {{-- <li class="nav-item">
                    <a href="{{ url('/messages') }}" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-message"></i>
                        <p>
                            Messages
                        </p>
                    </a>
                </li> --}}
                <!-- Categories -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-list-check"></i>
                        <p>
                            Categories
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach ($categories as $category)
                            <li class="nav-item">
                                <label class="nav-link">
                                    <input type="checkbox" name="category_id[]" value="{{ $category['id'] }}">
                                    {{ $category['name'] }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <!-- My offers -->
                @if (Auth::user()->subscription_status == 1 && Auth::user()->role == 1)
                    <li class="nav-item">
                        <a href="{{ url('/offers') }}" class="nav-link">
                            <i class="nav-icon fas fa-handshake"></i>
                            <p>
                                My Offers
                            </p>
                        </a>
                    </li>
                @endif

                <!-- My Artworks -->

                <!-- My Artworks -->
                @if (Auth::user()->subscription_status == 1 && Auth::user()->role == 2)
                    <li id="menuArtworks" class="nav-item">
                        <a href="" class="nav-link">
                            <i class="nav-icon fas fa-palette"></i>
                            <p>
                                My Artworks
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <label class="nav-link" id="available-filter">
                                    <input type="radio" name="art-status" value="1">
                                    Available
                                </label>
                            </li>
                            <li class="nav-item">
                                <label class="nav-link" id="sold-filter">
                                    <input type="radio" name="art-status" value="3">
                                    Sold
                                </label>
                            </li>
                        </ul>
                        
                    </li>
                @endif

                {{-- @if (Auth::user()->subscription_status == 1 && Auth::user()->role == 2)
                    <li class="nav-item">
                        <a href="{{ url('/artworks') }}" class="nav-link">
                            <i class="nav-icon fas fa-palette"></i>
                            <p>
                                My Artworks
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-palette"></i>
                            <p>
                                My Artworks
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <label class="nav-link">
                                    <input type="checkbox" name="available" value="1">
                                    Available
                                </label>
                            </li>

                            <li class="nav-item">
                                <label class="nav-link">
                                    <input type="checkbox" name="sold" value="3">
                                    Sold
                                </label>
                            </li>
                        </ul>
                    </li>
    
                @endif --}}

                <!-- Create -->
                <li class="nav-item">
                    @if (Auth::user()->subscription_status == 0 && Auth::user()->role == 2)
                        <a href="#view_as_artist_sub" id="artist_sub" data-toggle="modal" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-plus"></i>
                            <p>
                                Create
                            </p>
                        </a>
                    @elseif (Auth::user()->subscription_status == 1 && Auth::user()->role == 2)
                        <a href="#add" data-toggle="modal" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-plus"></i>
                            <p>
                                Create
                            </p>
                        </a>
                    @endif

                </li>


            </ul>
        </nav>

        <hr>

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('../storage/images/avatars/' . session('photo')) }}" class="img-circle elevation-2"
                    height="22" width="22" alt="User Image">
            </div>
            <div class="info">
                <a href="#profile" data-toggle="modal" id="my_profile" class="d-block">{{ session('name') }}</a>
                {{-- <a href="#" class="d-block">Alexander Pierce</a> --}}
            </div>
        </div>

        <!-- Terms and Rules -->
        <li class="nav-item">
            <a href="https://creative-gallery.online/storage/docs/Creative-Gallery-Auction-Terms-and-Rules.docx"
                class="nav-link">
                <p>
                    Terms & Rules
                </p>
            </a>
        </li>

        {{-- <li class="nav-item">
            <a href="{{ url('/messages') }}" class="nav-link">
                <i class="nav-icon fas fa-solid fa-message"></i>
                <p>
                   -
                </p>
            </a>
        </li> --}}
    </div>
</aside>

@include('user.modals.modal_profile')
@include('user.modals.modal_subscription')
