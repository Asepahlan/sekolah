@extends('layouts.dashboard')

@section('title', 'Manajemen Mata Pelajaran')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Daftar Mata Pelajaran</h4>
                <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary">Tambah Mata Pelajaran</a>
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
                                <th>Kode</th>
                                <th>Nama Mata Pelajaran</th>
                                <th>Jam Pelajaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $subject->code }}</td>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->credits }}</td>
                                <td>
                                    <a href="{{ route('admin.subjects.edit', $subject) }}" 
                                       class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.subjects.destroy', $subject) }}" 
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

                {{ $subjects->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 