@extends('layouts.dashboard')

@section('title', 'Ajukan Izin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Pengajuan Izin</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('siswa.leaves.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Jenis Izin</label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                            <option value="">Pilih Jenis Izin</option>
                            <option value="sakit" {{ old('type') === 'sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="izin" {{ old('type') === 'izin' ? 'selected' : '' }}>Izin</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="start_date"
                                       class="form-control @error('start_date') is-invalid @enderror"
                                       value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="end_date"
                                       class="form-control @error('end_date') is-invalid @enderror"
                                       value="{{ old('end_date') }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alasan</label>
                        <textarea name="reason" rows="3"
                                  class="form-control @error('reason') is-invalid @enderror"
                                  required>{{ old('reason') }}</textarea>
                        @error('reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lampiran (Opsional)</label>
                        <input type="file" name="attachment"
                               class="form-control @error('attachment') is-invalid @enderror">
                        <small class="form-text text-muted">
                            Format: PDF, JPG, JPEG, PNG (Max: 2MB)
                        </small>
                        @error('attachment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                        <a href="{{ route('siswa.leaves.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 
