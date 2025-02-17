@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="bg-dark text-white p-4 rounded-top mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 fw-bold">Gestión de Empleados</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item active text-light" aria-current="page">Empleados</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('employees.create') }}" class="btn btn-outline-light">
                <i class="fas fa-plus-circle me-2"></i>Nuevo Empleado
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
                        <input type="text" class="form-control" id="searchEmployee" placeholder="Buscar empleado...">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="mb-0 fw-bold">Lista de Empleados</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">ID/Nombre</th>
                            <th class="py-3">Apellidos</th>
                            <th class="py-3">Identificación</th>
                            <th class="py-3">Dirección</th>
                            <th class="py-3">Teléfono</th>
                            <th class="py-3">Ciudad</th>
                            <th class="py-3 text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                        <tr>
                            <td class="px-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-initial rounded-circle bg-dark text-white me-3 position-relative">
                                        {{ strtoupper(substr($employee->name, 0, 1)) }}
                                        <small class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle px-2" 
                                               style="font-size: 0.6rem; transform: translate(30%, 30%);">
                                            {{ $employee->id }}
                                        </small>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $employee->name }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h6 class="mb-0 fw-bold">{{ $employee->surname }}</h6>
                            </td>
                            <td>{{ $employee->identification }}</td>
                            <td>{{ $employee->address }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td>
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                {{ $employee->city->name }}
                            </td>
                            <td>
                                <div class="d-flex justify-content-end gap-2 pe-4">
                                    <a href="{{ route('employees.edit', $employee->id) }}" 
                                       class="btn btn-sm btn-outline-dark"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger delete-employee"
                                            title="Eliminar"
                                            data-id="{{ $employee->id }}"
                                            data-name="{{ $employee->name }} {{ $employee->surname }}">
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
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        position: relative;
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

    .position-absolute {
        min-width: 20px;
        text-align: center;
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

    .swal2-confirm {
        background-color: #dc3545 !important;
    }

    .swal2-cancel {
        background-color: #6c757d !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchEmployee');
    searchInput.addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchText) ? '' : 'none';
        });
    });
    document.querySelectorAll('.delete-employee').forEach(button => {
        button.addEventListener('click', function() {
            const employeeId = this.getAttribute('data-id');
            const employeeName = this.getAttribute('data-name');

            Swal.fire({
                title: '¿Eliminar empleado?',
                html: `
                    <div class="text-center">
                        <div class="mb-4">
                            <i class="fas fa-user-times text-danger" style="font-size: 4rem;"></i>
                        </div>
                        <p style="font-size: 1.1rem; margin-bottom: 0.5rem;">
                            Estás a punto de eliminar a:
                        </p>
                        <p style="font-size: 1.2rem; font-weight: 600; margin-bottom: 1rem;">
                            ${employeeName}
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
                    form.action = `/employees/${employeeId}`;
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