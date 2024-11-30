@extends('layouts.dashboard')

@section('title', 'Jadwal Mengajar')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Jadwal Mengajar</h4>
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                        Export
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('guru.schedule.export.pdf') }}">
                                Export PDF
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('guru.schedule.export.excel') }}">
                                Export Excel
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                            <tr>
                                <td>{{ $schedule->day }}</td>
                                <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                <td>{{ $schedule->class->name }}</td>
                                <td>{{ $schedule->subject->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $schedules->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
