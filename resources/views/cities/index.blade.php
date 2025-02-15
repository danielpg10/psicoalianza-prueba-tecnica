@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Listado de Ciudades</h1>
    <a href="{{ route('cities.create') }}" class="btn btn-success">Nueva Ciudad</a>
</div>

<div class="card shadow">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>País</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cities as $city)
                <tr>
                    <td>{{ $city->name }}</td>
                    <td>{{ $city->country->name }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('cities.edit', $city->id) }}" 
                               class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('cities.destroy', $city->id) }}" method="POST">
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