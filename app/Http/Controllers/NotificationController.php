<?php

namespace App\Http\Controllers;

use App\Models\Notification; // Pastikan Anda memiliki model Notification
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    // Mengambil semua notifikasi
    public function index()
    {
        $notifications = Notification::all();
        return response()->json($notifications);
    }

    // Menambah notifikasi baru
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'required|integer|exists:users,id', // Pastikan ada relasi dengan tabel users
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Membuat notifikasi baru
        $notification = Notification::create([
            'title' => $request->title,
            'message' => $request->message,
            'user_id' => $request->user_id,
        ]);

        return response()->json($notification, 201);
    }

    // Mengambil notifikasi berdasarkan ID
    public function show($id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        return response()->json($notification);
    }

    // Memperbarui notifikasi
    public function update(Request $request, $id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'message' => 'sometimes|required|string',
            'user_id' => 'sometimes|required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Memperbarui notifikasi
        $notification->update($request->all());

        return response()->json($notification);
    }

    // Menghapus notifikasi
    public function destroy($id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        $notification->delete();
        return response()->json(['message' => 'Notification deleted successfully']);
    }
}
