<aside class="main-sidebar sidebar-light-primary elevation-4">
    <a href="{{ url('/admin/dashboard') }}" class="brand-link">
        <img src="{{ url('storage/images/blacklogo.png') }}" alt="Creative Gallery"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Creative<b>Gallery</b></span>
    </a>
    <div class="sidebar">
        <br>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ url('/admin/dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <!-- Dashboard -->

                <!-- Accounts -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/admin/accounts') }}" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Accounts
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/verification') }}" class="nav-link">
                                <i class="nav-icon fas fa-id-card"></i>
                                <p>
                                    Verification Requests
                                </p>
                            </a>
                        </li>

                    </ul>
                </li>
                <!-- Accounts -->

                <!-- Biddings -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-palette"></i>
                        <p>
                            Biddings
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/admin/bidding/requests') }}" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Requests
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/biddings') }}" class="nav-link">
                                <i class="nav-icon fas fa-hourglass-start"></i>
                                <p>
                                    On Bidding
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/bidding/sold') }}" class="nav-link">
                                <i class="nav-icon fas fa-receipt"></i>
                                <p>
                                    Sold
                                </p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ url('/admin/verification') }}" class="nav-link">
                                <i class="nav-icon fas fa-id-card"></i>
                                <p>
                                    Paid
                                </p>
                            </a>
                        </li> --}}


                    </ul>
                </li>
                <!-- Biddings -->

                <!-- Categories -->
                <li class="nav-item">
                    <a href="{{ url('/admin/categories') }}" class="nav-link">
                        <i class="nav-icon fas fa-list-check"></i>
                        <p>
                            Categories
                        </p>
                    </a>
                </li>
                <!-- Categories -->

                <!-- Payments -->
                <li class="nav-item">
                    <a href="{{ url('/admin/payments') }}" class="nav-link">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>
                            Payments
                        </p>
                    </a>
                </li>
                <!-- Payments -->
            </ul>
        </nav>
    </div>
</aside>