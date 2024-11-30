<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ScheduleController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rute autentikasi (login, register, dll)
Auth::routes();

// Rute untuk Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard admin
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Manajemen pengguna
    Route::resource('admin/users', App\Http\Controllers\Admin\UserController::class, ['as' => 'admin']);

    // Manajemen pengumuman
    Route::resource('admin/announcements', App\Http\Controllers\Admin\AnnouncementController::class, ['as' => 'admin']);

    // Manajemen kelas
    Route::resource('admin/classes', App\Http\Controllers\Admin\ClassController::class, ['as' => 'admin']);

    // Manajemen mata pelajaran
    Route::resource('admin/subjects', App\Http\Controllers\Admin\SubjectController::class, ['as' => 'admin']);

    // Manajemen jadwal
    Route::resource('admin/schedules', App\Http\Controllers\Admin\ScheduleController::class, ['as' => 'admin']);
    Route::get('admin/schedules/export/pdf', [App\Http\Controllers\Admin\ScheduleController::class, 'exportPdf'])
        ->name('admin.schedules.export.pdf');
    Route::get('admin/schedules/export/excel', [App\Http\Controllers\Admin\ScheduleController::class, 'exportExcel'])
        ->name('admin.schedules.export.excel');
    Route::post('admin/schedules/import', [App\Http\Controllers\Admin\ScheduleController::class, 'import'])
        ->name('admin.schedules.import');

    // Manajemen kalender akademik
    Route::resource('admin/calendar', App\Http\Controllers\Admin\AcademicCalendarController::class);

    // Rute untuk manajemen user
    Route::resource('users', UserController::class);
});

// Rute untuk Guru
Route::middleware(['auth', 'role:guru'])->group(function () {
    // Dashboard guru
    Route::get('/guru/dashboard', [App\Http\Controllers\Guru\DashboardController::class, 'index'])
        ->name('guru.dashboard');

    // Jadwal mengajar
    Route::get('/guru/schedule', [App\Http\Controllers\Guru\ScheduleController::class, 'index'])
        ->name('guru.schedule');
    Route::get('guru/schedule/export/pdf', [App\Http\Controllers\Guru\ScheduleController::class, 'exportPdf'])
        ->name('guru.schedule.export.pdf');
    Route::get('guru/schedule/export/excel', [App\Http\Controllers\Guru\ScheduleController::class, 'exportExcel'])
        ->name('guru.schedule.export.excel');

    // Manajemen presensi
    Route::get('guru/attendance', [App\Http\Controllers\Guru\AttendanceController::class, 'index'])
        ->name('guru.attendance.index');
    Route::post('guru/attendance', [App\Http\Controllers\Guru\AttendanceController::class, 'store'])
        ->name('guru.attendance.store');
    Route::get('guru/attendance/report', [App\Http\Controllers\Guru\AttendanceController::class, 'report'])
        ->name('guru.attendance.report');
    Route::get('guru/attendance/export', [App\Http\Controllers\Guru\AttendanceController::class, 'export'])
        ->name('guru.attendance.export');

    // Manajemen izin
    Route::resource('walikelas/leaves', App\Http\Controllers\WaliKelas\LeaveController::class)
        ->only(['index', 'show', 'update']);

    // Routes untuk wali kelas
    Route::get('walikelas/dashboard', [App\Http\Controllers\WaliKelas\DashboardController::class, 'index'])
        ->name('walikelas.dashboard');
    Route::get('walikelas/students', [App\Http\Controllers\WaliKelas\DashboardController::class, 'students'])
        ->name('walikelas.students');
    Route::get('walikelas/students/{student}', [App\Http\Controllers\WaliKelas\DashboardController::class, 'studentDetail'])
        ->name('walikelas.students.detail');
    Route::post('walikelas/students/{student}/notes', [App\Http\Controllers\WaliKelas\StudentNoteController::class, 'store'])
        ->name('walikelas.students.notes.store');
    Route::delete('walikelas/notes/{note}', [App\Http\Controllers\WaliKelas\StudentNoteController::class, 'destroy'])
        ->name('walikelas.notes.destroy');
    Route::get('walikelas/students/{student}/report', [App\Http\Controllers\WaliKelas\DashboardController::class, 'generateReport'])
        ->name('walikelas.students.report');
});

// Rute untuk Siswa
Route::middleware(['auth', 'role:siswa'])->group(function () {
    // Dashboard siswa
    Route::get('/siswa/dashboard', [App\Http\Controllers\Siswa\DashboardController::class, 'index'])
        ->name('siswa.dashboard');

    // Jadwal pelajaran
    Route::get('/siswa/schedule', [App\Http\Controllers\Siswa\ScheduleController::class, 'index'])
        ->name('siswa.schedule');

    // Presensi siswa
    Route::get('siswa/attendance', [App\Http\Controllers\Siswa\AttendanceController::class, 'index'])
        ->name('siswa.attendance.index');
    Route::get('siswa/attendance/export', [App\Http\Controllers\Siswa\AttendanceController::class, 'export'])
        ->name('siswa.attendance.export');

    // Manajemen izin
    Route::resource('siswa/leaves', App\Http\Controllers\Siswa\LeaveController::class)
        ->except(['edit', 'update']);

    Route::get('/siswa/chat', function () {
        return view('siswa.chat');
    })->name('siswa.chat');
});

// Rute untuk Orang Tua
Route::middleware(['auth', 'role:ortu'])->group(function () {
    // Dashboard orang tua
    Route::get('/ortu/dashboard', [App\Http\Controllers\Ortu\DashboardController::class, 'index'])
        ->name('ortu.dashboard');
});

// Rute untuk semua pengguna yang sudah login
Route::middleware(['auth'])->group(function () {
    // Pengumuman
    Route::get('/announcements', [App\Http\Controllers\AnnouncementController::class, 'index'])
        ->name('announcements.index');
    Route::get('/announcements/{announcement}', [App\Http\Controllers\AnnouncementController::class, 'show'])
        ->name('announcements.show');

    // Notifikasi
    Route::post('notifications/{notification}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])
        ->name('notifications.read');
    Route::get('notifications', [App\Http\Controllers\NotificationController::class, 'index'])
        ->name('notifications.index');
});

// Rute home dan dashboard
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/notifications', [NotificationController::class, 'index']);
Route::post('/notifications', [NotificationController::class, 'store']);

Route::resource('schedules', ScheduleController::class);
