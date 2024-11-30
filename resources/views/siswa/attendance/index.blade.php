@extends('layouts.dashboard')

@section('title', 'Rekap Presensi')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Rekap Presensi</h4>
            </div>
            <div class="card-body">
                <!-- Filter Form -->
                <form action="{{ route('siswa.attendance.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Mata Pelajaran</label>
                                <select name="schedule_id" class="form-control">
                                    <option value="">Semua Mata Pelajaran</option>
                                    @foreach($schedules as $schedule)
                                        <option value="{{ $schedule->id }}"
                                                {{ request('schedule_id') == $schedule->id ? 'selected' : '' }}>
                                            {{ $schedule->subject->name }} - {{ $schedule->teacher->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Bulan</label>
                                <select name="month" class="form-control">
                                    <option value="">Semua Bulan</option>
                                    @foreach(range(1, 12) as $month)
                                        <option value="{{ $month }}"
                                                {{ request('month') == $month ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Tahun</label>
                                <select name="year" class="form-control">
                                    @foreach(range(date('Y'), date('Y')-1) as $year)
                                        <option value="{{ $year }}"
                                                {{ request('year', date('Y')) == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary d-block w-100">Filter</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Summary Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Hadir</h5>
                                <h2>{{ $summary['hadir'] }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">Izin</h5>
                                <h2>{{ $summary['izin'] }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h5 class="card-title">Sakit</h5>
                                <h2>{{ $summary['sakit'] }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h5 class="card-title">Alpha</h5>
                                <h2>{{ $summary['alpha'] }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Table -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->date->format('d/m/Y') }}</td>
                                <td>{{ $attendance->schedule->subject->name }}</td>
                                <td>{{ $attendance->schedule->teacher->name }}</td>
                                <td>
                                    <span class="badge bg-{{
                                        $attendance->status === 'hadir' ? 'success' :
                                        ($attendance->status === 'izin' ? 'info' :
                                        ($attendance->status === 'sakit' ? 'warning' : 'danger'))
                                    }}">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </td>
                                <td>{{ $attendance->note }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $attendances->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
