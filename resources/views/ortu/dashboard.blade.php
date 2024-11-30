@extends('layouts.dashboard')

@section('title', 'Orang Tua Dashboard')

@section('navbar-menu')
<li class="nav-item">
    <a class="nav-link" href="#">Nilai Anak</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="#">Kehadiran</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="#">Pembayaran</a>
</li>
@endsection

@section('content')
<div class="row">
    <div class="mb-4 col-md-12">
        <h2>Dashboard Orang Tua</h2>
    </div>

    <div class="mb-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Info Anak</h5>
                <div class="list-group">
                    <div class="list-group-item">
                        <h6>Nama: Ahmad Siswa</h6>
                        <p class="mb-1">Kelas: X-A</p>
                        <p class="mb-1">NIS: 123456</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nilai Terbaru</h5>
                <div class="list-group">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Matematika</h6>
                            <small>85</small>
                        </div>
                        <p class="mb-1">Ulangan Harian 1</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pengumuman Sekolah</h5>
                <div class="list-group">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Rapat Orang Tua</h6>
                            <small>2 hari lagi</small>
                        </div>
                        <p class="mb-1">Pembahasan program semester...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
