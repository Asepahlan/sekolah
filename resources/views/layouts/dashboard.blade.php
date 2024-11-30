<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Dashboard Admin - SI Sekolah</title>
    <style>
        body {
            background-color: #f8f9fa; /* Warna latar belakang */
        }
        .navbar {
            background-color: #007bff; /* Warna navbar */
        }
        footer {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand text-white" href="#">SI Sekolah</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route(auth()->user()->role->name . '.dashboard') }}">Dashboard</a>
                </li>
                @if(auth()->user()->hasRole('admin'))
                <li class="nav-item">
                    <a class="nav-link text-white {{ Request::is('admin/users*') ? 'active' : '' }}"
                       href="{{ route('admin.users.index') }}">
                        Manajemen User
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link text-white {{ Request::is('announcements*') ? 'active' : '' }}"
                       href="{{ route('announcements.index') }}">
                        Pengumuman
                    </a>
                </li>
                @if(auth()->user()->hasRole('admin'))
                <li class="nav-item">
                    <a class="nav-link text-white {{ Request::is('admin/announcements*') ? 'active' : '' }}"
                       href="{{ route('admin.announcements.index') }}">
                        Manajemen Pengumuman
                    </a>
                </li>
                @endif
                @yield('navbar-menu')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ auth()->user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5 pt-4">
        @yield('content')
    </div>

    <footer>
        <p>&copy; 2024 SI Sekolah. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
