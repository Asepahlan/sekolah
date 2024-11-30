<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Pelajaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .header {
            margin-bottom: 30px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Hari</th>
                <th>Jam</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Guru</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $schedule)
            <tr>
                <td>{{ $schedule->day }}</td>
                <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                <td>{{ $schedule->class->name }}</td>
                <td>{{ $schedule->subject->name }}</td>
                <td>{{ $schedule->teacher->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>© {{ date('Y') }} Sistem Informasi Sekolah</p>
    </div>
</body>
</html> 
