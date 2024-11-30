@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Tugas</h2>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">Tambah Tugas</a>
    <table class="table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Tanggal Tenggat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->due_date->format('d/m/Y') }}</td>
                <td>{{ ucfirst($task->status) }}</td>
                <td>
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
