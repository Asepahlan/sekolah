@extends('layouts.dashboard')

@section('title', $announcement->title)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">{{ $announcement->title }}</h2>
                <p class="text-muted">
                    Dipublikasikan oleh {{ $announcement->user->name }}
                    pada {{ $announcement->published_at->format('d/m/Y H:i') }}
                </p>
                <hr>
                <div class="announcement-content">
                    {{ $announcement->content }}
                </div>
                <div class="mt-4">
                    <a href="{{ route('announcements.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
