@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Listado de Países</h1>
    <a href="{{ route('countries.create') }}" class="btn btn-success">Nuevo País</a>
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
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($countries as $country)
                <tr>
                    <td>{{ $country->name }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('countries.edit', $country->id) }}" 
                               class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('countries.destroy', $country->id) }}" method="POST">
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