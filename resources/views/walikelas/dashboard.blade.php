@extends('layouts.dashboard')

@section('title', 'Dashboard Wali Kelas')

@section('content')
<div class="row">
    <!-- Statistik Umum -->
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total Siswa</h5>
                <h2>{{ $totalStudents }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Hadir Hari Ini</h5>
                <h2>{{ $todayAttendance['hadir'] ?? 0 }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title">Izin Pending</h5>
                <h2>{{ $pendingLeaves }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h5 class="card-title">Alpha Hari Ini</h5>
                <h2>{{ $todayAttendance['alpha'] ?? 0 }}</h2>
            </div>
        </div>
    </div>

    <!-- Grafik Kehadiran Bulanan -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Statistik Kehadiran Bulan Ini</h5>
            </div>
            <div class="card-body">
                <canvas id="monthlyAttendanceChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Daftar Siswa Bermasalah -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Siswa dengan Kehadiran Rendah</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @foreach($lowAttendanceStudents as $student)
                    <a href="{{ route('walikelas.students.detail', $student) }}"
                       class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">{{ $student->name }}</h6>
                            <small class="text-danger">{{ $student->total_absences }} Alpha</small>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Chart(document.getElementById('monthlyAttendanceChart'), {
        type: 'bar',
        data: {
            labels: ['Hadir', 'Izin', 'Sakit', 'Alpha'],
            datasets: [{
                label: 'Jumlah',
                data: [
                    {{ $monthlyAttendance['hadir'] ?? 0 }},
                    {{ $monthlyAttendance['izin'] ?? 0 }},
                    {{ $monthlyAttendance['sakit'] ?? 0 }},
                    {{ $monthlyAttendance['alpha'] ?? 0 }}
                ],
                backgroundColor: [
                    '#28a745',
                    '#17a2b8',
                    '#ffc107',
                    '#dc3545'
                ]
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endsection 
