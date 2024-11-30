@extends('layouts.dashboard')

@section('title', 'Tambah Mata Pelajaran')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Mata Pelajaran Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.subjects.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Kode Mata Pelajaran</label>
                        <input type="text" name="code"
                               class="form-control @error('code') is-invalid @enderror"
                               value="{{ old('code') }}">
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Mata Pelajaran</label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jam Pelajaran</label>
                        <input type="number" name="credits"
                               class="form-control @error('credits') is-invalid @enderror"
                               value="{{ old('credits') }}">
                        @error('credits')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 
