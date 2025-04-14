<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') {{ auth()->user()->user_name }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="d-flex flex-column vh-100">

    <nav class="navbar navbar-expand-md navbar-dark bg-dark px-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('lobby.index') }}">
                <i class="bi bi-chat-dots-fill fs-4"></i>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavbar" aria-controls="topNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="topNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <livewire:section-block/>
                </ul>

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="https://static.vecteezy.com/system/resources/previews/002/275/847/original/male-avatar-profile-icon-of-smiling-caucasian-man-vector.jpg" alt="Avatar" width="40" height="40" class="rounded-circle">
                        {{ auth()->user()->user_name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item">{{ auth()->user()->user_name }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Perfil</a></li>
                        <li><a class="dropdown-item" href="#">Configurações</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('auth.logout') }}">Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-fill overflow-hidden">
        @yield('content')
    </main>



    @livewireScripts
</body>
</html>
