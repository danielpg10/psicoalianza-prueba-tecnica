@extends('layouts.app')

@section('content')
<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">Editar País: {{ $country->name }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('countries.update', $country->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label fw-bold">Nombre del País</label>
                <input type="text" 
                       name="name" 
                       class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name', $country->name) }}" 
                       minlength="1"
                       maxlength="30"
                       required>
                <div class="invalid-feedback">
                    @if($errors->has('name'))
                        {{ $errors->first('name') }}
                    @else
                        El nombre debe tener entre 1 y 30 caracteres
                    @endif
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('countries.index') }}" class="btn btn-outline-dark">
                    <i class="fas fa-times me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-dark">
                    <i class="fas fa-save me-2"></i>Actualizar País
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@endpush
@endsection