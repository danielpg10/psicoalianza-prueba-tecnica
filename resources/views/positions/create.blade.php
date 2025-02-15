@extends('layouts.app')

@section('content')
<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">Registrar Nuevo Cargo</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('positions.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-bold">Nombre del Cargo</label>
                <input type="text" 
                       name="name" 
                       class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name') }}" 
                       minlength="3"
                       maxlength="30"
                       required>
                <div class="invalid-feedback">
                    @if($errors->has('name'))
                        {{ $errors->first('name') }}
                    @else
                        El nombre debe tener entre 3 y 30 caracteres
                    @endif
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('positions.index') }}" class="btn btn-outline-dark">
                    <i class="fas fa-times me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-dark">
                    <i class="fas fa-save me-2"></i>Guardar Cargo
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