<!DOCTYPE html>
<html>
<head>
    <title>Pengingat Tugas</title>
</head>
<body>
    <h1>Pengingat Tugas: {{ $task->title }}</h1>
    <p>Deskripsi: {{ $task->description }}</p>
    <p>Tanggal Tenggat: {{ $task->due_date->format('d/m/Y') }}</p>
    <p>Silakan selesaikan tugas ini sebelum tenggat waktu.</p>
</body>
</html>
