import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

// Mendapatkan ID penerima (misalnya dari URL atau state)
const receiverId = /* ID penerima yang sesuai */;

// Mendengarkan pesan baru
Echo.private(`chat.${receiverId}`)
    .listen('MessageSent', (e) => {
        displayMessage(e.message);
        if (Notification.permission === 'granted') {
            new Notification(`Pesan baru dari ${e.message.sender.name}`, {
                body: e.message.content
            });
        }
    });

// Fungsi untuk menampilkan pesan
function displayMessage(message) {
    const messagesContainer = document.getElementById('messages');
    const messageElement = document.createElement('div');
    messageElement.textContent = `${message.sender.name}: ${message.content}`;

    // Tambahkan tombol hapus
    const deleteButton = document.createElement('button');
    deleteButton.textContent = 'Hapus';
    deleteButton.onclick = function() {
        fetch(`/api/chat/message/${message.id}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        })
        .then(response => {
            if (response.ok) {
                messagesContainer.removeChild(messageElement);
            }
        });
    };

    messageElement.appendChild(deleteButton);
    messagesContainer.appendChild(messageElement);
}

document.getElementById('search-input').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const messages = document.querySelectorAll('#messages div');

    messages.forEach(message => {
        if (message.textContent.toLowerCase().includes(searchTerm)) {
            message.style.display = '';
        } else {
            message.style.display = 'none';
        }
    });
});

if (Notification.permission !== 'granted') {
    Notification.requestPermission();
}
