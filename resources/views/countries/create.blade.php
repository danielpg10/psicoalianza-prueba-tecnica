@extends('layouts.app')

@section('content')
<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">Registrar Nuevo País</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('countries.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Nombre del País</label>
                <input type="text" 
                       name="name" 
                       class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name') }}" 
                       required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Guardar País</button>
            </div>
        </form>
    </div>
</div>
@endsection