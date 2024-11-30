@extends('layouts.dashboard')

@section('title', 'Siswa Dashboard')

@section('navbar-menu')
<li class="nav-item">
    <a class="nav-link" href="#">Jadwal Pelajaran</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="#">Nilai</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="#">Tugas</a>
</li>
@endsection

@section('content')
<div class="row">
    <div class="mb-4 col-md-12">
        <h2>Dashboard Siswa</h2>
    </div>

    <div class="mb-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Jadwal Hari Ini</h5>
                <div class="list-group">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Matematika</h6>
                            <small>07:00 - 08:30</small>
                        </div>
                        <p class="mb-1">Guru: Bpk. Ahmad</p>
                    </div>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">B. Indonesia</h6>
                            <small>08:30 - 10:00</small>
                        </div>
                        <p class="mb-1">Guru: Ibu Siti</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tugas Pending</h5>
                <div class="list-group">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Matematika</h6>
                            <small class="text-danger">Deadline: Besok</small>
                        </div>
                        <p class="mb-1">Tugas Bab 3</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pengumuman</h5>
                <div class="list-group">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Ujian Tengah Semester</h6>
                            <small>3 hari lagi</small>
                        </div>
                        <p class="mb-1">Persiapan UTS...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
