@extends('layouts.dashboard')

@section('title', 'Tambah Kelas')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Kelas Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.classes.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Kelas</label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tingkat</label>
                        <select name="level" class="form-control @error('level') is-invalid @enderror">
                            <option value="">Pilih Tingkat</option>
                            <option value="X" {{ old('level') === 'X' ? 'selected' : '' }}>X</option>
                            <option value="XI" {{ old('level') === 'XI' ? 'selected' : '' }}>XI</option>
                            <option value="XII" {{ old('level') === 'XII' ? 'selected' : '' }}>XII</option>
                        </select>
                        @error('level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kapasitas</label>
                        <input type="number" name="capacity"
                               class="form-control @error('capacity') is-invalid @enderror"
                               value="{{ old('capacity') }}">
                        @error('capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 
