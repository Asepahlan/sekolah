@extends('layouts.dashboard')

@section('title', 'Tambah Jadwal')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Jadwal Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.schedules.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <select name="class_id" class="form-control @error('class_id') is-invalid @enderror">
                            <option value="">Pilih Kelas</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}"
                                        {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        <select name="subject_id" class="form-control @error('subject_id') is-invalid @enderror">
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}"
                                        {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Guru</label>
                        <select name="teacher_id" class="form-control @error('teacher_id') is-invalid @enderror">
                            <option value="">Pilih Guru</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}"
                                        {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('teacher_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hari</label>
                        <select name="day" class="form-control @error('day') is-invalid @enderror">
                            <option value="">Pilih Hari</option>
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
                                <option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }}>
                                    {{ $day }}
                                </option>
                            @endforeach
                        </select>
                        @error('day')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jam Mulai</label>
                                <input type="time" name="start_time"
                                       class="form-control @error('start_time') is-invalid @enderror"
                                       value="{{ old('start_time') }}">
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jam Selesai</label>
                                <input type="time" name="end_time"
                                       class="form-control @error('end_time') is-invalid @enderror"
                                       value="{{ old('end_time') }}">
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 
