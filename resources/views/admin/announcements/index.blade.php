@extends('layouts.dashboard')

@section('title', 'Manajemen Pengumuman')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Daftar Pengumuman</h4>
                <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">Tambah Pengumuman</a>
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
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Tanggal Publikasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($announcements as $announcement)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $announcement->title }}</td>
                                <td>
                                    <span class="badge bg-{{ $announcement->status === 'published' ? 'success' : 'warning' }}">
                                        {{ $announcement->status }}
                                    </span>
                                </td>
                                <td>{{ $announcement->published_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.announcements.edit', $announcement) }}"
                                       class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.announcements.destroy', $announcement) }}"
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

                {{ $announcements->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 
