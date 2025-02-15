@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Listado de Empleados</h1>
    <a href="{{ route('employees.create') }}" class="btn btn-success">Nuevo Empleado</a>
</div>

<div class="card shadow">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Identificación</th>
                    <th>Cargos</th>
                    <th>Ciudad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->name }} {{ $employee->surname }}</td>
                    <td>{{ $employee->identification }}</td>
                    <td>
                        @foreach($employee->positions as $position)
                            <span class="badge bg-primary">{{ $position->name }}</span>
                        @endforeach
                    </td>
                    <td>{{ $employee->city->name }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('employees.edit', $employee->id) }}" 
                               class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection