<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Leave; // Pastikan Anda memiliki model Leave
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaveController extends Controller
{
    // Mengambil semua pengajuan cuti
    public function index()
    {
        $leaves = Leave::all();
        return response()->json($leaves);
    }

    // Menambah pengajuan cuti baru
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|integer|exists:users,id', // Pastikan ada relasi dengan tabel users
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Membuat pengajuan cuti baru
        $leave = Leave::create([
            'employee_id' => $request->employee_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
        ]);

        return response()->json($leave, 201);
    }

    // Mengambil pengajuan cuti berdasarkan ID
    public function show($id)
    {
        $leave = Leave::find($id);

        if (!$leave) {
            return response()->json(['message' => 'Leave request not found'], 404);
        }

        return response()->json($leave);
    }

    // Memperbarui pengajuan cuti
    public function update(Request $request, $id)
    {
        $leave = Leave::find($id);

        if (!$leave) {
            return response()->json(['message' => 'Leave request not found'], 404);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'employee_id' => 'sometimes|required|integer|exists:users,id',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'reason' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Memperbarui pengajuan cuti
        $leave->update($request->all());

        return response()->json($leave);
    }

    // Menghapus pengajuan cuti
    public function destroy($id)
    {
        $leave = Leave::find($id);

        if (!$leave) {
            return response()->json(['message' => 'Leave request not found'], 404);
        }

        $leave->delete();
        return response()->json(['message' => 'Leave request deleted successfully']);
    }
}
