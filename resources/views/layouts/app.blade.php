<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba Técnica - Marlon Daniel Portuguez Gomez</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .navbar {
            background-color: #1a1a1a !important;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .navbar-brand {
            font-weight: 700;
            color: #ffffff !important;
        }
        .nav-link {
            color: #b0b0b0 !important;
            transition: color 0.3s ease, transform 0.3s ease;
            position: relative;
            padding: 0.5rem 1rem !important;
        }
        .nav-link:hover {
            color: #ffffff !important;
            transform: translateY(-2px);
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #ffffff;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .navbar-toggler {
            border-color: #ffffff;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                PsicoAlianza
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employees.index') }}">
                            <i class="fas fa-users me-1"></i>Empleados
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('countries.index') }}">
                            <i class="fas fa-globe-americas me-1"></i>Países
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('positions.index') }}">
                            <i class="fas fa-briefcase me-1"></i>Cargos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route ('cities.index') }}">
                            <i class="fas fa-city me-1"></i>Ciudades
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>