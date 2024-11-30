@extends('layouts.dashboard')

@section('title', 'Manajemen Kelas')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Daftar Kelas</h4>
                <a href="{{ route('admin.classes.create') }}" class="btn btn-primary">Tambah Kelas</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kelas</th>
                                <th>Tingkat</th>
                                <th>Kapasitas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classes as $class)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $class->name }}</td>
                                <td>{{ $class->level }}</td>
                                <td>{{ $class->capacity }}</td>
                                <td>
                                    <a href="{{ route('admin.classes.edit', $class) }}"
                                       class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.classes.destroy', $class) }}"
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

                {{ $classes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 
