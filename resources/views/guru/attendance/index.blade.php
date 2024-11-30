@extends('layouts.dashboard')

@section('title', 'Input Presensi')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Input Presensi</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('guru.attendance.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Pilih Jadwal</label>
                                <select name="schedule_id" class="form-control" required>
                                    <option value="">Pilih Jadwal</option>
                                    @foreach($schedules as $schedule)
                                        <option value="{{ $schedule->id }}"
                                                {{ request('schedule_id') == $schedule->id ? 'selected' : '' }}>
                                            {{ $schedule->subject->name }} - {{ $schedule->class->name }}
                                            ({{ $schedule->day }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="date" class="form-control"
                                       value="{{ request('date', date('Y-m-d')) }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary d-block">Tampilkan</button>
                            </div>
                        </div>
                    </div>
                </form>

                @if($selectedSchedule)
                    <form action="{{ route('guru.attendance.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="schedule_id" value="{{ $selectedSchedule->id }}">
                        <input type="hidden" name="date" value="{{ request('date') }}">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>
                                            <input type="hidden"
                                                   name="attendances[{{ $loop->index }}][student_id]"
                                                   value="{{ $student->id }}">
                                            <select name="attendances[{{ $loop->index }}][status]"
                                                    class="form-control" required>
                                                @foreach(['hadir', 'izin', 'sakit', 'alpha'] as $status)
                                                    <option value="{{ $status }}"
                                                        {{ $attendances->get($student->id)?->status === $status ? 'selected' : '' }}>
                                                        {{ ucfirst($status) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text"
                                                   name="attendances[{{ $loop->index }}][note]"
                                                   class="form-control"
                                                   value="{{ $attendances->get($student->id)?->note }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Simpan Presensi</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 
