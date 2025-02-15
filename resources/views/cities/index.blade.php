@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="bg-dark text-white p-4 rounded-top mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 fw-bold">Gestión de Ciudades</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item active text-light" aria-current="page">Ciudades</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('cities.create') }}" class="btn btn-outline-light">
                <i class="fas fa-plus-circle me-2"></i>Nueva Ciudad
            </a>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-dark text-white">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" id="searchCity" placeholder="Buscar ciudad...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="mb-0 fw-bold">Lista de Ciudades</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Ciudad</th>
                            <th class="py-3">País</th>
                            <th class="py-3 text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cities as $city)
                        <tr>
                            <td class="px-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-initial rounded-circle bg-dark text-white me-3">
                                        {{ strtoupper(substr($city->name, 0, 1)) }}
                                    </div>
                                    <span class="fw-bold">{{ $city->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-dark text-white">
                                    {{ $city->country->name }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-end gap-2 pe-4">
                                    <a href="{{ route('cities.edit', $city->id) }}" 
                                       class="btn btn-sm btn-outline-dark"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger delete-city"
                                            title="Eliminar"
                                            data-id="{{ $city->id }}"
                                            data-name="{{ $city->name }}"
                                            data-country="{{ $city->country->name }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<style>
.avatar-initial {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
}

.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

.btn-outline-dark:hover, 
.btn-outline-danger:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.2s;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

.bg-dark {
    background-color: #343a40 !important;
}

.card-header {
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
}

.swal2-popup {
    border-radius: 20px !important;
    background-color: rgba(30, 30, 30, 0.95) !important;
    backdrop-filter: blur(10px) !important;
    -webkit-backdrop-filter: blur(10px) !important;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3) !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    color: #ffffff !important;
}

.swal2-title {
    font-size: 1.5rem !important;
    font-weight: 600 !important;
    color: #ffffff !important;
}

.swal2-html-container {
    font-size: 1rem !important;
    color: #ffffff !important;
}

.swal2-icon {
    border: none !important;
    font-size: 4rem !important;
}

.swal2-confirm, .swal2-cancel {
    border-radius: 12px !important;
    padding: 12px 24px !important;
    font-weight: 600 !important;
    letter-spacing: 0.5px !important;
    text-transform: uppercase !important;
    transition: all 0.3s ease !important;
}

.swal2-confirm {
    background-color: #dc3545 !important;
    color: #ffffff !important;
}

.swal2-cancel {
    background-color: #6c757d !important;
    color: #ffffff !important;
}

.swal2-confirm:hover, .swal2-cancel:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2) !important;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchCity');
    searchInput.addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchText) ? '' : 'none';
        });
    });

    document.querySelectorAll('.delete-city').forEach(button => {
        button.addEventListener('click', function() {
            const cityId = this.getAttribute('data-id');
            const cityName = this.getAttribute('data-name');
            const countryName = this.getAttribute('data-country');

            Swal.fire({
                title: '¿Eliminar ciudad?',
                html: `
                    <div class="text-center">
                        <div class="mb-4">
                            <i class="fas fa-city text-danger" style="font-size: 4rem;"></i>
                        </div>
                        <p style="font-size: 1.1rem; margin-bottom: 0.5rem;">
                            Estás a punto de eliminar:
                        </p>
                        <p style="font-size: 1.2rem; font-weight: 600; margin-bottom: 0.5rem;">
                            ${cityName}
                        </p>
                        <p style="font-size: 1rem; color: #a7a7a7; margin-bottom: 1rem;">
                            País: ${countryName}
                        </p>
                        <p style="color: #a7a7a7; font-size: 0.9rem;">
                            Esta acción no se puede deshacer
                        </p>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'swal2-confirm',
                    cancelButton: 'swal2-cancel'
                },
                buttonsStyling: false,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/cities/${cityId}`;
                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
@endsection