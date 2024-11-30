@extends('layouts.dashboard')

@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Jadwal Pelajaran</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                            <tr>
                                <td>{{ $schedule->day }}</td>
                                <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                <td>{{ $schedule->subject->name }}</td>
                                <td>{{ $schedule->teacher->name }}</td>
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
