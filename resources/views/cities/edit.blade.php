@extends('layouts.app')

@section('content')
<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">Editar Ciudad: {{ $city->name }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('cities.update', $city->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">País</label>
                    <select name="country_id" class="form-select @error('country_id') is-invalid @enderror" required>
                        <option value="">Seleccione un país</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" 
                                {{ $country->id == $city->country_id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        @if($errors->has('country_id'))
                            {{ $errors->first('country_id') }}
                        @else
                            Por favor seleccione un país
                        @endif
                    </div>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nombre de la Ciudad</label>
                    <input type="text" 
                           name="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $city->name) }}" 
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
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('cities.index') }}" class="btn btn-outline-dark">
                    <i class="fas fa-times me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-dark">
                    <i class="fas fa-save me-2"></i>Actualizar Ciudad
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