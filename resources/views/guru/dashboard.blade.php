@extends('layouts.dashboard')

@section('title', 'Guru Dashboard')

@section('navbar-menu')
<li class="nav-item">
    <a class="nav-link" href="#">Input Nilai</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="#">Jadwal Mengajar</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="#">Data Siswa</a>
</li>
@endsection

@section('content')
<div class="row">
    <div class="mb-4 col-md-12">
        <h2>Dashboard Guru</h2>
    </div>

    <div class="mb-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Jadwal Hari Ini</h5>
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Matematika</h6>
                            <small>07:00 - 08:30</small>
                        </div>
                        <p class="mb-1">Kelas X-A</p>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Matematika</h6>
                            <small>09:00 - 10:30</small>
                        </div>
                        <p class="mb-1">Kelas X-B</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tugas Belum Dinilai</h5>
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Tugas Matematika</h6>
                            <small>Kelas X-A</small>
                        </div>
                        <p class="mb-1">25 submission</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pengumuman Terbaru</h5>
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Rapat Guru</h6>
                            <small>2 hari yang lalu</small>
                        </div>
                        <p class="mb-1">Rapat evaluasi pembelajaran...</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
