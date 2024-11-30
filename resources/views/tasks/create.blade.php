@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Tugas</h2>
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Tanggal Tenggat</label>
            <input type="date" class="form-control" id="due_date" name="due_date" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
