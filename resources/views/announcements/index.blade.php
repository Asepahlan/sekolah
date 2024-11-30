@extends('layouts.dashboard')

@section('title', 'Pengumuman')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Pengumuman</h4>
            </div>
            <div class="card-body">
                @foreach($announcements as $announcement)
                    <div class="mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $announcement->title }}</h5>
                            <p class="card-text text-muted">
                                Dipublikasikan oleh {{ $announcement->user->name }}
                                pada {{ $announcement->published_at->format('d/m/Y H:i') }}
                            </p>
                            <p class="card-text">{{ Str::limit($announcement->content, 200) }}</p>
                            <a href="{{ route('announcements.show', $announcement) }}"
                               class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                        </div>
                    </div>
                @endforeach

                {{ $announcements->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 
