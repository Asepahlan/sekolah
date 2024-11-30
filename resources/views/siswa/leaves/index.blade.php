@extends('layouts.dashboard')

@section('title', 'Pengajuan Izin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Riwayat Pengajuan Izin</h4>
                <a href="{{ route('siswa.leaves.create') }}" class="btn btn-primary">
                    Ajukan Izin
                </a>
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
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Status</th>
                                <th>Disetujui Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leaves as $leave)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $leave->start_date->format('d/m/Y') }}
                                    @if($leave->start_date != $leave->end_date)
                                        - {{ $leave->end_date->format('d/m/Y') }}
                                    @endif
                                    <br>
                                    <small class="text-muted">{{ $leave->duration }} hari</small>
                                </td>
                                <td>{{ ucfirst($leave->type) }}</td>
                                <td>
                                    <span class="badge bg-{{
                                        $leave->status === 'approved' ? 'success' :
                                        ($leave->status === 'rejected' ? 'danger' : 'warning')
                                    }}">
                                        {{ ucfirst($leave->status) }}
                                    </span>
                                </td>
                                <td>{{ $leave->approver?->name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('siswa.leaves.show', $leave) }}"
                                       class="btn btn-sm btn-info">Detail</a>
                                    @if($leave->status === 'pending')
                                        <form action="{{ route('siswa.leaves.destroy', $leave) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus?')">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $leaves->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 
