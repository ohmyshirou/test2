@extends('layouts.app')
@section('judul', 'Inbox')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md mt-6">
        <div style="display: flex; align-items: center;">
            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="1" y="1" width="34" height="34" rx="7" fill="white" />
                <rect x="1" y="1" width="34" height="34" rx="7" stroke="#D9D9D9" stroke-width="2" />
                <path
                    d="M18.0015 28C20.2203 27.9997 22.3759 27.2614 24.1291 25.9015C25.8823 24.5416 27.1334 22.6372 27.6855 20.4882C28.2376 18.3392 28.0593 16.0676 27.1786 14.0311C26.298 11.9945 24.7651 10.3087 22.8212 9.23895C20.8773 8.16923 18.6328 7.77639 16.4412 8.12226C14.2495 8.46814 12.2351 9.53309 10.7151 11.1495C9.1951 12.7658 8.25584 14.8418 8.04518 17.0506C7.83453 19.2593 8.36444 21.4755 9.55149 23.35L8.00149 28L12.6515 26.45C14.251 27.4652 16.107 28.0029 18.0015 28Z"
                    stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            <div style="margin-left: 8px;">
                <h2 class="text-lg font-semibold">Message</h2>
                <p class="text-gray-600">All relevant communications related to proposal organization.</p>
            </div>
        </div>
        <hr class="my-4 border-gray-300" />

        <div class="flex">
            <!-- Sidebar untuk daftar pengguna -->
            <div class="w-1/4 border-r pr-4">
                <input type="text" id="searchInput" class="w-full p-2 border rounded mb-4" placeholder="Search users..."
                    onkeyup="filterUsers()">
                <select id="filterSelect" class="w-full p-2 border rounded mb-4" onchange="filterMessages()">
                    <option value="all">All Inbox</option>
                    <option value="read">Read</option>
                    <option value="unread">Unread</option>
                </select>

                <!-- Scrollable untuk daftar pengguna -->
                <div id="userList" class="max-h-80 overflow-y-auto">
                    @foreach ($users as $user)
                        <div class="user-item p-2 hover:bg-gray-100 cursor-pointer mb-1 {{ $user->hasUnreadMessages ? 'font-bold' : '' }}"
                            onclick="selectUser({{ $user->user_id }}, '{{ $user->username }}')">
                            <div class="flex justify-between">
                                <div>{{ $user->username }}</div>
                                @if ($user->hasUnreadMessages)
                                    <span class="text-red-500">•</span> <!-- Unread indicator -->
                                @endif
                            </div>
                            <div class="text-gray-500 text-sm">
                                {{ $user->lastMessageContent }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            <!-- Chat box -->
            <div class="w-3/4 pl-4">
                <!-- User info section in chat box -->
                <div id="userInfo" class="mb-4 p-4 border rounded bg-wh">
                    <!-- This section will be populated with user information -->
                    <h3 id="userName" class="text-lg font-semibold"></h3>
                    <p id="userEmail" class="text-sm text-gray-600"></p>
                </div>

                <div id="chatBox" class="h-96 overflow-y-auto border-b mb-4 p-4 bg-white">
                    <!-- Area chat box -->
                </div>

                <form id="messageForm" class="flex">
                    <input type="text" id="messageInput" class="w-full p-2 border rounded-l"
                        placeholder="Write your message...">
                    <button type="submit"
                        class="bg-strong-blue text-white px-4 rounded-r hover:bg-slate-600 transition">Send</button>
                </form>
            </div>

        </div>
    </div>

    <style>
        /* Styles untuk chat messages */
        .message-sent {
            background-color: #F6F8FA;
            /* Warna biru muda untuk mengirim messages */
            padding: 10px;
            margin: 10px 0;
            margin-bottom: 6px;
            border-radius: 8px;
            text-align: right;
            border: 2px solid #D9D9D9;
            /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); Bayangan untuk efek kedalaman */
            transition: background-color 0.3s;
            /* Transisi saat hover */
        }

        .message-sent:hover {
            background-color: #ECEEF0;
            /* Warna saat hover */
        }

        .message-received {
            background-color: #FFFFFF;
            /* Warna merah muda untuk menerima messages */
            padding: 10px;
            margin: 10px 0;
            margin-bottom: 6px;
            border-radius: 8px;
            text-align: left;
            border: 2px solid #D9D9D9;
            /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); Bayangan untuk efek kedalaman */
            transition: background-color 0.3s;
            /* Transisi saat hover */
        }

        .message-received:hover {
            background-color: #ECEEF0;
            /* Warna saat hover */
        }
    </style>

    <script>
        let selectedUser = null;
        let hasNewMessages = false;

        function checkForNewMessages() {
            if (!selectedUser) return;

            fetch(`/chat/messages/new/${selectedUser}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (data.newMessages.length > 0) {
                        data.newMessages.forEach(msg => {
                            if (!msg.is_read) {
                                hasNewMessages = true;
                                document.querySelector(
                                        `.user-item[data-user-id="${msg.sender_id}"] .unread-indicator`).style
                                    .display = 'block';
                            }
                        });
                    }
                })
                .catch(error => console.error('Error checking for new messages:', error));
        }

        // Panggil fungsi ini setiap (1 detik = 1000 ms)
        setInterval(checkForNewMessages, 2000);

        function filterUsers() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const userItems = document.querySelectorAll('.user-item');

            userItems.forEach(userItem => {
                const username = userItem.textContent.toLowerCase();
                userItem.style.display = username.includes(searchInput) ? 'block' : 'none';
            });
        }

        function selectUser(user_id, username) {
            document.querySelectorAll('.user-item').forEach(item => item.classList.remove('selected'));
            const selectedItem = document.querySelector(`.user-item[onclick*="${user_id}"]`);
            if (selectedItem) {
                selectedItem.classList.add('selected');
            }

            selectedUser = user_id;
            document.getElementById('chatBox').innerHTML = '';

            // Fetch user information
            fetch(`/chat/user-info/${user_id}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(userInfo => {
                    document.getElementById('userInfo').innerHTML = `
                <h3 class="text-lg font-bold">${userInfo.username}</h3>
                <p>${userInfo.email}</p>
                `;
                })
                .catch(error => console.error('Error fetching user info:', error));

            // Fetch chat messages
            fetch(`/chat/messages/${user_id}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(messages => {
                    messages.forEach(message => {
                        const messageElement = document.createElement('div');
                        messageElement.classList.add(message.sender_id == {{ auth()->id() }} ? 'message-sent' :
                            'message-received');
                        messageElement.textContent =
                            `${message.sender_id == {{ auth()->id() }} ? 'You' : username}: ${message.content}`;
                        document.getElementById('chatBox').appendChild(messageElement);
                    });
                    document.getElementById('chatBox').scrollTop = document.getElementById('chatBox').scrollHeight;
                })
                .catch(error => console.error('Error fetching messages:', error));
        }


        document.getElementById('messageForm').addEventListener('submit', function(e) {
            e.preventDefault();
            if (!selectedUser) {
                alert('Please select a user to send a message.');
                return;
            }

            const messageInput = document.getElementById('messageInput');
            const messageContent = messageInput.value.trim();

            if (messageContent === '') {
                alert('Message cannot be empty.');
                return;
            }

            fetch(`/chat/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        receiver_id: selectedUser,
                        content: messageContent
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    // Mengosongkan input field
                    messageInput.value = '';

                    // Menambahkan pesan terkirim ke kotak obrolan
                    const messageElement = document.createElement('div');
                    messageElement.classList.add('message-sent');
                    messageElement.textContent = `You: ${data.content}`;
                    document.getElementById('chatBox').appendChild(messageElement);
                    document.getElementById('chatBox').scrollTop = document.getElementById('chatBox')
                        .scrollHeight;
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                });
        });
    </script>
@endsection
