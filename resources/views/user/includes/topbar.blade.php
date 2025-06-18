<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <div class="container">
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <form class="form-inline ml-0 ml-md-3" id="searchForm" method="GET">
                @csrf
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" id="searchInput" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            {{-- @if (Auth::user()->subscription_status == 1 && Auth::user()->role == 2)
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-primary navbar-badge">0</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">0 Notifications</span>
                        <div class="dropdown-divider"></div>

                        <div class="dropdown-divider"></div>
                        
                    </div>
                </li>
            @endif --}}
            <li class="nav-item">
                <a href="/logout" id="logout" class="nav-link">Logout</a>
            </li>
        </ul>
    </div>
</nav>

{{-- <script>
    function sendRequest() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);

                var notifications = JSON.parse(this.responseText);
                updateNotificationsDropdown(notifications);

                updateNotificationCount(notifications.length);

            }
        };
        var csrfToken = '{{ csrf_token() }}';
        var url = "/notifications?_token=" + encodeURIComponent(csrfToken);

        xhr.open("GET", url, true);
        xhr.send();
    }

    function updateNotificationCount(count) {
        var notificationCountBadge = document.querySelector('.badge.navbar-badge');
        notificationCountBadge.textContent = count;
    }

    function updateNotificationsDropdown(notifications) {
        var dropdownMenu = document.querySelector('.dropdown-menu.dropdown-menu-lg.dropdown-menu-right');

        // Clear existing notifications
        dropdownMenu.innerHTML = '';

        // Notification header
        var notificationHeader = document.createElement('span');
        notificationHeader.classList.add('dropdown-item', 'dropdown-header');
        notificationHeader.textContent = notifications.length + ' Notifications';
        dropdownMenu.appendChild(notificationHeader);

        // Divider
        var divider = document.createElement('div');
        divider.classList.add('dropdown-divider');
        dropdownMenu.appendChild(divider);

        // Append notifications
        notifications.forEach(function(notification) {
            //console.log(notification.highest_bidder_offer);
            var notificationItem = document.createElement('a');
            notificationItem.classList.add('dropdown-item', 'd-flex', 'align-items-center');
            notificationItem.href = '#';
            notificationItem.setAttribute('data-notification-id', notification.highest_bidding_id);

            var icon = document.createElement('i');
            icon.classList.add('fas', 'fa-handshake', 'mr-2');
            notificationItem.appendChild(icon);

            var notificationContent = document.createElement('div');
            notificationContent.classList.add('flex-grow-1');
            notificationItem.appendChild(notificationContent);

            var notificationText = document.createElement('p');
            //notificationText.textContent = notification.highest_bidder_name + " won " + notification.art_name;
            notificationText.textContent = notification.highest_bidder_name + " is the highest bidder for " +
                notification.art_name;
            notificationContent.appendChild(notificationText);

            var amountBadge = document.createElement('span');
            amountBadge.classList.add('badge', 'badge-success', 'ml-auto', 'text-sm');
            amountBadge.textContent = '₱' + notification.highest_bidder_offer; // Format amount as needed
            notificationContent.appendChild(amountBadge);

            

            dropdownMenu.appendChild(notificationItem);
        });

        // Divider
        var finalDivider = document.createElement('div');
        finalDivider.classList.add('dropdown-divider');
        dropdownMenu.appendChild(finalDivider);

        // Footer link (optional)
        // var seeAllLink = document.createElement('a');
        // seeAllLink.classList.add('dropdown-item', 'dropdown-footer');
        // seeAllLink.href = '#';
        // seeAllLink.textContent = 'See All Notifications';
        // dropdownMenu.appendChild(seeAllLink);
    }
    sendRequest();
    setInterval(sendRequest, 60000);
</script> --}}
