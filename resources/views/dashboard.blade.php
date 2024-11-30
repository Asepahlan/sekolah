@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h1 class="text-center">Dashboard Admin</h1>
    <div class="row text-center">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Siswa</h5>
                    <p class="card-text">150</p>
                    <a href="#" class="btn btn-light">Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Guru</h5>
                    <p class="card-text">25</p>
                    <a href="#" class="btn btn-light">Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Kelas</h5>
                    <p class="card-text">12</p>
                    <a href="#" class="btn btn-light">Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Pengumuman</h5>
                    <p class="card-text">5</p>
                    <a href="#" class="btn btn-light">Detail</a>
                </div>
            </div>
        </div>
    </div>
@endsection
