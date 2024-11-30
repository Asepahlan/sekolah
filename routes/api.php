<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; // Menambahkan import Request
use App\Http\Controllers\Api\ScheduleController; // Tambahkan ini
use App\Http\Controllers\Api\LeaveController; // Tambahkan ini

// Public routes
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('/user', [App\Http\Controllers\Api\AuthController::class, 'user']);

    // Device Token
    Route::post('/device-token', function (Request $request) {
        $request->validate(['token' => 'required|string']);
        $request->user()->updateDeviceToken($request->token);
        return response()->json(['message' => 'Token berhasil diperbarui']);
    });

    // Attendance
    Route::get('/attendances', [App\Http\Controllers\Api\AttendanceController::class, 'index']);
    Route::get('/attendances/summary', [App\Http\Controllers\Api\AttendanceController::class, 'summary']);
    Route::post('/attendances', [App\Http\Controllers\Api\AttendanceController::class, 'store']);

    // Schedule
    Route::get('/schedule', [ScheduleController::class, 'index']); // Contoh penggunaan ScheduleController
    Route::get('/schedules/today', [ScheduleController::class, 'today']);

    // Leaves
    Route::post('/leave', [LeaveController::class, 'store']); // Contoh penggunaan LeaveController
    Route::apiResource('leaves', App\Http\Controllers\Api\LeaveController::class);

    // Chat
    Route::post('/chat/send', [App\Http\Controllers\Api\ChatController::class, 'sendMessage']);
    Route::get('/chat/{receiverId}', [App\Http\Controllers\Api\ChatController::class, 'getMessages']);
    Route::delete('/chat/message/{id}', [App\Http\Controllers\Api\ChatController::class, 'deleteMessage']);
});
