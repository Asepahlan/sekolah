<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule; // Pastikan Anda memiliki model Schedule
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    // Mengambil semua jadwal
    public function index()
    {
        $schedules = Schedule::all();
        return response()->json($schedules);
    }

    // Menambah jadwal baru
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Membuat jadwal baru
        $schedule = Schedule::create([
            'title' => $request->title,
            'date' => $request->date,
            'time' => $request->time,
        ]);

        return response()->json($schedule, 201);
    }

    // Mengambil jadwal berdasarkan ID
    public function show($id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found'], 404);
        }

        return response()->json($schedule);
    }

    // Memperbarui jadwal
    public function update(Request $request, $id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found'], 404);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'date' => 'sometimes|required|date',
            'time' => 'sometimes|required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Memperbarui jadwal
        $schedule->update($request->all());

        return response()->json($schedule);
    }

    // Menghapus jadwal
    public function destroy($id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found'], 404);
        }

        $schedule->delete();
        return response()->json(['message' => 'Schedule deleted successfully']);
    }
}
