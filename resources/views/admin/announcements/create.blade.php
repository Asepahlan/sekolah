@extends('layouts.dashboard')

@section('title', 'Tambah Pengumuman')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Pengumuman Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.announcements.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konten</label>
                        <textarea name="content" rows="5"
                                  class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 
