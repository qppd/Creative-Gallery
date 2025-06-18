@include('user/includes/header')
@include('user/modals/modal_home')
<style>
    .fixed-size-img {
        height: 200px;
        width: 100%;
        object-fit: cover;
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ url('storage/images/blacklogo.png') }}" alt="Creative Gallery"
                height="180" width="180">
            <h1>Creative Gallery</h1>
        </div>
        <!-- Preloader -->
        @include('user/includes/menubar')
        @include('user/includes/topbar')

        <!-- Content Wrapper. Contains page content -->
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
            <!-- Main content -->
            <section class="content">

                <div id="message">
                    <div class="message_container">
                        <div class="persons">
                            <div class="account_name">
                                <p>{{ Auth::user()->name }}</p>
                                <a data-bs-toggle="modal" data-bs-target="#newMessageModal" style="margin-left:10px;">
                                    <img src="./images/edit.png" alt="edit">
                                </a>
            
                                <!-- New message Modal -->
                                <div class="modal fade" id="newMessageModal" tabindex="-1" aria-labelledby="newMessageModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="newMessageModalLabel">New Message</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
            
                                                @foreach ($users as $user)
                                                    {{-- <ul class="list-group list-unstyled">
                                                        <p>{{ $user['name'] }}</p>
                                                    </ul> --}}
                                                    <div class="cart" data-user-id="{{ $user['id'] }}">
                                                        <div>
                                                            <div class="img">
                                                                <img src="{{ asset('../storage/' . $user['avatar']) }}" alt="">
                                                            </div>
                                                            <div class="info">
                                                                <p class="name">{{ $user['name'] }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
            
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                            </div>
                            <div class="account_message">
                                <div class="desc">
                                    <p>Messages</p>
            
                                </div>
                                @if (count($chats) > 0)
                                    @foreach ($chats as $chat)
                                        <div class="cart" data-user-id="{{ $chat['id'] }}">
                                            <div>
                                                <div class="img">
                                                    <img src="{{ asset('../storage/' . $chat['avatar']) }}" alt="">
                                                </div>
                                                <div class="info">
                                                    <p class="name">{{ $chat['name'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="cart">
                                        <div>
                                            <div class="img">
                                                <img src="./images/info.png" alt="">
                                            </div>
                                            <div class="info">
                                                <p class="name">No message available.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                {{-- <div class="cart">
                                    <div>
                                        <div class="img">
                                            <img src="./images/info.png" alt="">
                                        </div>
                                        <div class="info">
                                            <p class="name">No message available.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart">
                                    <div>
                                        <div class="img">
                                            <img src="./images/profile_img.jpg" alt="">
                                        </div>
                                        <div class="info">
                                            <p class="name">Kristal May Munda</p>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="message">
                            {{-- <div class="options">
                                <div class="cart">
                                    <div>
                                        <div class="img">
                                            <img src="./images/info.png" alt="">
                                        </div>
                                        <div class="info">
                                            <p class="name">No message available.</p>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="options">
                                <div class="cart">
                                    <div>
                                        <div id="chatUserAvatar" class="img">
                                            <img src="./images/blacklogo.png" alt="">
                                        </div>
                                        <div id="chatUserName" class="info">
                                            <p class="name">Creative Gallery</p>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="other">
                                    <a href="#">
                                        <img src="./images/telephone.png" alt="call">
                                    </a>
                                    <a href="#">
                                        <img src="./images/video_call.png" alt="video call">
                                    </a>
                                </div> --}}
                            </div>
                            <div class="content" id="chatContainer">
                                {{-- <div class="my_message">
                                    <p class="p_message">hello how are you?</p>
                                </div>
                                <div class="response_message">
                                    <p class="p_message">hi! i'm fine and you?</p>
                                </div> --}}
            
            
                            </div>
                            <form id="chatForm" class="horizontal-form">
                                <input type="hidden" id="uid" />
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input type="text" id="emoji" placeholder="Write your message" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="col-xs-4">
                                                <button class="btn btn-success" type="submit">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                            </form>
            
            
            
                        </div>
                    </div>
                </div>
                
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>

    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.content-wrapper -->
    @include('user/includes/footer')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    @include('user/includes/scripts')

    <script>
        document.getElementById('chatForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Get the values from the input fields
            var userId = document.getElementById('uid').value;
            var message = document.getElementById('emoji').value;

            // Create the query string
            var params = "user_id=" + encodeURIComponent(userId) + "&message=" + encodeURIComponent(message);

            // Create a new XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Configure it: POST-request for the URL
            xhr.open('POST', '{{ route('chat.sendMessage') }}', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

            // Set up a function to handle the response
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Handle success (you can process the response here)
                        var userId = {{ auth()->id() }};
                        var response = JSON.parse(xhr.responseText);
                        console.log("ID:" + userId);
                        console.log("RES:" + response);
                        displayChat(userId, response);
                        // // // Update UI with user information
                        // console.log(response);
                    } else {
                        // Handle error
                        alert('An error occurred: ' + xhr.statusText);
                    }
                }
            };

            // Send the request with the query string
            xhr.send(params);
        });

        function createElement(sender_id, message) {
            var messageContainer = document.createElement('div');
            var messageParagraph = document.createElement('p');
            var myId = {{ Auth::id() }};
            messageContainer.classList.add(sender_id === myId ? 'my_message' :
                'response_message');
            messageParagraph.classList.add('p_message');
            messageParagraph.textContent = message;

            messageContainer.appendChild(messageParagraph);
            return messageContainer;
        }

        function displayChat(sender_id, message) {
            var chatContainer = document.getElementById('chatContainer');

            var messageElement = createElement(sender_id, message);
            chatContainer.appendChild(messageElement);

        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var carts = document.querySelectorAll('.cart');

            carts.forEach(function(cart) {
                cart.addEventListener('click', function() {
                    var userId = this.dataset.userId;
                    $('#newMessageModal').modal('hide');
                    $('#uid').val(userId);
                    loadUserInfo(userId);
                    loadChatsWithUser(userId);
                });
            });

            function createMessageElement(chat) {
                var messageContainer = document.createElement('div');
                messageContainer.className = 'row';
                if (chat.type == 2) {

                    var photoMessage = document.createElement('img');
                    var photoDiv = document.createElement('div');
                    photoDiv.className = 'row';

                    var buttonPay = document.createElement('button');

                    buttonPay.innerText = 'Pay Now';

                    // Set button class for styling
                    buttonPay.classList.add('button-pay');

                    // Create an image element for the GCash icon
                    var gcashIcon = document.createElement('img');
                    gcashIcon.src = '/storage/images/gcash.png' ; // Replace with the actual path to your GCash icon
                    gcashIcon.alt = 'GCash Icon';
                    gcashIcon.classList.add('icon'); // Add class for styling

                    // Append the GCash icon before the button text
                    buttonPay.prepend(gcashIcon);


                    var messageParagraph = document.createElement('p');
                    var messageDiv = document.createElement('div');
                    messageDiv.className = 'row';

                    photoMessage.style.width = "240px";
                    photoMessage.style.height = "320px";
                    var myId = {{ Auth::id() }};
                    photoDiv.classList.add(chat.sender_id === myId ? 'my_message' :
                        'response_message');
                    photoMessage.classList.add('p_message');
                    photoMessage.src = '/storage/' + chat.media_name;

                    messageDiv.classList.add(chat.sender_id === myId ? 'my_message' :
                        'response_message');
                    messageParagraph.classList.add('p_message');
                    messageParagraph.textContent = "I want to offer " + chat.offer; + " fore this artwork";

                    //messageContainer.appendChild(messageParagraph);
                    messageDiv.appendChild(messageParagraph);
                    photoDiv.appendChild(buttonPay);
                    photoDiv.appendChild(photoMessage);

                    messageContainer.appendChild(photoDiv);
                    messageContainer.appendChild(messageDiv);
                    messageContainer.appendChild(buttonPay);


                } else {
                    var messageParagraph = document.createElement('p');
                    var myId = {{ Auth::id() }};
                    messageContainer.classList.add(chat.sender_id === myId ? 'my_message' :
                        'response_message');
                    messageParagraph.classList.add('p_message');
                    messageParagraph.textContent = chat.message;

                    messageContainer.appendChild(messageParagraph);
                }



                return messageContainer;
            }

            // Function to display chat messages
            function displayChatMessages(response) {
                var chatContainer = document.getElementById('chatContainer');

                // Clear existing messages
                chatContainer.innerHTML = '';

                // Iterate through chat messages and append them to the chat container
                response.chats.forEach(function(chat) {
                    var messageElement = createMessageElement(chat);
                    chatContainer.appendChild(messageElement);
                });
            }

            function sendMessage(userId, messageContent) {
                var xhr = new XMLHttpRequest();
                var url = "{{ route('chat.sendMessage') }}";
                var params = "user_id=" + encodeURIComponent(userId) + "&message=" +
                    encodeURIComponent(message);

                xhr.open('POST', url, true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            console.log("RES:" + response);

                        } else {
                            console.error('Request failed');
                        }
                    }
                };

                xhr.send(params);
            }

            function loadChatsWithUser(userId) {
                var xhr = new XMLHttpRequest();
                var url = "{{ route('chat.fetchMessages') }}";
                var params = "user_id=" + userId;

                xhr.open('POST', url, true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            displayChatMessages(response);

                        } else {
                            console.error('Request failed');
                        }
                    }
                };

                xhr.send(params);
            }


            function loadUserInfo(userId) {
                var xhr = new XMLHttpRequest();
                var url = "{{ route('chat.loadUser') }}";
                var params = "user_id=" + userId;

                xhr.open('POST', url, true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            var user = JSON.parse(xhr.responseText);
                            // Update UI with user information
                            updateUI(user);
                        } else {
                            console.error('Request failed');
                        }
                    }
                };

                xhr.send(params);
            }

            function loadMessages(userId) {
                var xhr = new XMLHttpRequest();
                var url = "{{ route('chat.loadChats') }}";
                var params = "user_id=" + userId;

                xhr.open('POST', url, true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            var chats = JSON.parse(xhr.responseText);
                            // Update UI with chats
                            //updateChats(chats);
                            console.log(chats);
                        } else {
                            console.error('Request failed');
                        }
                    }
                };

                xhr.send(params);
            }

            function updateUI(user) {
                var chatUserAvatar = document.getElementById('chatUserAvatar');
                var chatUserName = document.getElementById('chatUserName');

                chatUserAvatar.innerHTML = '<img src="../storage/' + user.avatar + '" alt="">';
                chatUserName.innerHTML = '<p class="name">' + user.name + '</p>';
            }
        });
    </script>


</body>

</html>
