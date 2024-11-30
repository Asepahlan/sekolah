@extends('layouts.dashboard')

@section('title', 'Manajemen Jadwal')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Jadwal Pelajaran</h4>
                <div>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                        Import Excel
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            Export
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.schedules.export.pdf', request()->all()) }}">
                                    Export PDF
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.schedules.export.excel', request()->all()) }}">
                                    Export Excel
                                </a>
                            </li>
                        </ul>
                    </div>
                    <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">Tambah Jadwal</a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="mb-3">
                    <form action="{{ route('admin.schedules.index') }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <select name="class_id" class="form-control">
                                <option value="">Pilih Kelas</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}"
                                            {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="day" class="form-control">
                                <option value="">Pilih Hari</option>
                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
                                    <option value="{{ $day }}"
                                            {{ request('day') == $day ? 'selected' : '' }}>
                                        {{ $day }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                            <tr>
                                <td>{{ $schedule->day }}</td>
                                <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                <td>{{ $schedule->class->name }}</td>
                                <td>{{ $schedule->subject->name }}</td>
                                <td>{{ $schedule->teacher->name }}</td>
                                <td>
                                    <a href="{{ route('admin.schedules.edit', $schedule) }}"
                                       class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.schedules.destroy', $schedule) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $schedules->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.schedules.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">File Excel</label>
                        <input type="file" name="file" class="form-control" required>
                        <small class="form-text text-muted">
                            Format: Kelas, Mata Pelajaran, Guru, Hari, Jam Mulai, Jam Selesai
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<a href="{{ route('admin.schedules.index') }}">Jadwal</a>
@endsection
