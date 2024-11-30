<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }

    public function getMessages(Request $request, $receiverId)
    {
        $messages = Message::where(function($query) use ($request, $receiverId) {
            $query->where('sender_id', $request->user()->id)
                  ->where('receiver_id', $receiverId);
        })->orWhere(function($query) use ($request, $receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', $request->user()->id);
        })->get();

        return response()->json($messages);
    }

    public function deleteMessage($id)
    {
        $message = Message::findOrFail($id);
        $this->authorize('delete', $message); // Pastikan hanya pengirim yang bisa menghapus

        $message->deleteMessage();

        return response()->json(['message' => 'Pesan berhasil dihapus']);
    }
}
