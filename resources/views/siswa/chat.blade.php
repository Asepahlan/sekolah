@extends('layouts.app')

@section('content')
<div id="chat-container">
    <h2>Chat</h2>
    <div id="messages" style="height: 400px; overflow-y: scroll;">
        <!-- Pesan akan ditampilkan di sini -->
    </div>
    <input type="text" id="message-input" placeholder="Ketik pesan...">
    <input type="text" id="search-input" placeholder="Cari pesan...">
    <button id="send-button">Kirim</button>
</div>
@endsection

@section('scripts')
<script src="{{ mix('js/chat.js') }}"></script>
@endsection
