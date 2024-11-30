@extends('layouts.dashboard')

@section('title', 'Dashboard Admin - SI Sekolah')

@section('navbar-menu')
<li class="nav-item">
    <a class="nav-link text-white" href="#">Dashboard</a>
</li>
<li class="nav-item">
    <a class="nav-link text-white" href="#">Manajemen User</a>
</li>
<li class="nav-item">
    <a class="nav-link text-white" href="#">Pengumuman</a>
</li>
<li class="nav-item">
    <a class="nav-link text-white" href="#">Jadwal</a>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Admin User
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="#">Logout</a>
    </div>
</li>
@endsection

@section('content')
<div class="container mt-5 pt-4">
    <h2 class="text-center mb-4">Dashboard Admin</h2>
    <div class="row">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Siswa</h5>
                    <p class="card-text">150</p>
                    <a href="#" class="btn btn-detail">Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Guru</h5>
                    <p class="card-text">25</p>
                    <a href="#" class="btn btn-detail">Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Kelas</h5>
                    <p class="card-text">12</p>
                    <a href="#" class="btn btn-detail">Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Pengumuman</h5>
                    <p class="card-text">5</p>
                    <a href="#" class="btn btn-detail">Detail</a>
                </div>
            </div>
        </div>
    </div>
    <div class="chart-container">
        <h3 class="text-center">Statistik Siswa dan Guru</h3>
        <canvas id="myChart"></canvas>
    </div>
</div>

<footer>
    <p>&copy; 2024 SI Sekolah. All rights reserved.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
