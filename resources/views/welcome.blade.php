@extends('layouts.app')

@section('content')
<div class="d-flex align-items-start justify-content-center" style="min-height: 100vh; padding-top: 5rem; background: #ffffff;">
    <div class="container px-4">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold mb-3">Sistema de Nómina</h1>
            <p class="lead text-muted mb-5">Prueba técnica para PsicoAlianza - Marlon Daniel Portuguez Gomez</p>
            <div class="d-flex justify-content-center gap-3 mb-5">
                <a href="{{ route('employees.create') }}" class="btn btn-primary px-4 py-2 rounded-4 fw-bold">
                    Nuevo Empleado
                </a>
            </div>
        </div>

        <div class="row g-5 justify-content-center">
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 border-0 rounded-4 shadow-custom transition-all">
                    <div class="card-body p-4 text-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-flex mb-3" style="width: 70px; height: 70px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-people text-primary" viewBox="0 0 16 16">
                                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                            </svg>
                        </div>
                        <h5 class="fw-bold mb-2">Empleados</h5>
                        <p class="text-muted mb-4">Gestiona tu equipo con facilidad</p>
                        <a href="{{ route('employees.index') }}" class="btn btn-primary w-100 rounded-4 fw-semibold">
                            Ver Empleados
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 border-0 rounded-4 shadow-custom transition-all">
                    <div class="card-body p-4 text-center">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3 d-inline-flex mb-3" style="width: 70px; height: 70px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-globe text-success" viewBox="0 0 16 16">
                                <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z"/>
                            </svg>
                        </div>
                        <h5 class="fw-bold mb-2">Países</h5>
                        <p class="text-muted mb-4">Explora nuestra cobertura global</p>
                        <a href="{{ route('countries.index') }}" class="btn btn-success w-100 rounded-4 fw-semibold">
                            Explorar Países
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 border-0 rounded-4 shadow-custom transition-all">
                    <div class="card-body p-4 text-center">
                        <div class="rounded-circle bg-info bg-opacity-10 p-3 d-inline-flex mb-3" style="width: 70px; height: 70px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-building text-info" viewBox="0 0 16 16">
                                <path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1ZM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Z"/>
                                <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V1Zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3V1Z"/>
                            </svg>
                        </div>
                        <h5 class="fw-bold mb-2">Ciudades</h5>
                        <p class="text-muted mb-4">Descubre nuestras ubicaciones</p>
                        <a href="{{ route('cities.index') }}" class="btn btn-info w-100 rounded-4 fw-semibold">
                            Explorar Ciudades
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 border-0 rounded-4 shadow-custom transition-all">
                    <div class="card-body p-4 text-center">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 d-inline-flex mb-3" style="width: 70px; height: 70px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-briefcase text-warning" viewBox="0 0 16 16">
                                <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v8A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5zm1.886 6.914L15 7.151V12.5a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5V7.15l6.614 1.764a1.5 1.5 0 0 0 .772 0zM1.5 4h13a.5.5 0 0 1 .5.5v1.616L8.129 7.948a.5.5 0 0 1-.258 0L1 6.116V4.5a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                        </div>
                        <h5 class="fw-bold mb-2">Cargos</h5>
                        <p class="text-muted mb-4">Organiza tu estructura laboral</p>
                        <a href="{{ route('positions.index') }}" class="btn btn-warning w-100 rounded-4 fw-semibold">
                            Ver Cargos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.shadow-custom {
    box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.2);
}

.shadow-custom:hover {
    box-shadow: 0 1.5rem 3rem rgba(0, 0, 0, 0.25);
}

.transition-all {
    transition: all .3s ease;
}

.rounded-4 {
    border-radius: 1rem !important;
}

.btn {
    font-weight: 600;
    padding: 0.6rem 1rem;
}

.card {
    background: #ffffff;
}

.text-muted {
    font-weight: 400;
}

.display-4 {
    font-weight: 700;
}

.lead {
    font-weight: 400;
}
</style>
@endsection