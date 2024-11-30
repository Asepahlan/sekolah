@extends('layouts.dashboard')

@section('title', 'Daftar Siswa')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Siswa</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kehadiran Bulan Ini</th>
                                <th>Total Alpha</th>
                                <th>Izin Aktif</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->name }}</td>
                                <td>
                                    <div class="progress">
                                        @php
                                            $total = $student->total_present + $student->total_absences;
                                            $percentage = $total > 0 ?
                                                ($student->total_present / $total) * 100 : 0;
                                        @endphp
                                        <div class="progress-bar bg-success"
                                             style="width: {{ $percentage }}%">
                                            {{ number_format($percentage, 1) }}%
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($student->total_absences > 0)
                                        <span class="badge bg-danger">
                                            {{ $student->total_absences }}
                                        </span>
                                    @else
                                        <span class="badge bg-success">0</span>
                                    @endif
                                </td>
                                <td>
                                    @if($student->active_leaves > 0)
                                        <span class="badge bg-info">
                                            {{ $student->active_leaves }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">0</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('walikelas.students.detail', $student) }}"
                                       class="btn btn-sm btn-info">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $students->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 
