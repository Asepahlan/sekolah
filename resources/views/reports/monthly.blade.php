<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bulanan Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 20px;
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
        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN BULANAN SISWA</h2>
        <h3>{{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }}</h3>
    </div>

    <div class="section">
        <h4>Data Siswa</h4>
        <table>
            <tr>
                <td width="200">Nama</td>
                <td>: {{ $student->name }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>: {{ $student->class->name }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h4>Rekap Kehadiran</h4>
        <table>
            <tr>
                <th>Status</th>
                <th>Jumlah</th>
            </tr>
            <tr>
                <td>Hadir</td>
                <td>{{ $attendanceStats['hadir'] ?? 0 }}</td>
            </tr>
            <tr>
                <td>Sakit</td>
                <td>{{ $attendanceStats['sakit'] ?? 0 }}</td>
            </tr>
            <tr>
                <td>Izin</td>
                <td>{{ $attendanceStats['izin'] ?? 0 }}</td>
            </tr>
            <tr>
                <td>Alpha</td>
                <td>{{ $attendanceStats['alpha'] ?? 0 }}</td>
            </tr>
        </table>
    </div>

    @if($notes->isNotEmpty())
    <div class="section">
        <h4>Catatan Perilaku</h4>
        <table>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Keterangan</th>
                <th>Poin</th>
            </tr>
            @foreach($notes as $note)
            <tr>
                <td>{{ $note->date->format('d/m/Y') }}</td>
                <td>{{ ucfirst($note->type) }}</td>
                <td>{{ $note->description }}</td>
                <td>{{ $note->point }}</td>
            </tr>
            @endforeach
        </table>
        <p>Total Poin: {{ $totalPoints }}</p>
    </div>
    @endif

    <div class="footer">
        <p>Laporan ini digenerate otomatis oleh sistem pada {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html> 
