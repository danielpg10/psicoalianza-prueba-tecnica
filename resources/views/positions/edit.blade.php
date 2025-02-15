@extends('layouts.app')

@section('content')
<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">Editar Cargo: {{ $position->name }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('positions.update', $position->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Nombre del Cargo</label>
                <input type="text" 
                       name="name" 
                       class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name', $position->name) }}" 
                       required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-warning btn-lg">Actualizar Cargo</button>
            </div>
        </form>
    </div>
</div>
@endsection