@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="bg-dark text-white p-4 rounded-top mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 fw-bold">Editar Empleado: {{ $employee->name }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{ route('employees.index') }}" class="text-light text-decoration-none">Empleados</a></li>
                        <li class="breadcrumb-item active text-light" aria-current="page">Editar Empleado</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card shadow border-0">
        <div class="card-body p-4">
            <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombres</label>
                        <input type="text" name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $employee->name) }}"
                               pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
                               maxlength="20"
                               required>
                        <div class="invalid-feedback">
                            @error('name')
                                {{ $message }}
                            @else
                                Por favor ingrese un nombre válido (máximo 20 caracteres, solo letras)
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Apellidos</label>
                        <input type="text" name="surname" 
                               class="form-control @error('surname') is-invalid @enderror" 
                               value="{{ old('surname', $employee->surname) }}"
                               pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
                               maxlength="20"
                               required>
                        <div class="invalid-feedback">
                            @error('surname')
                                {{ $message }}
                            @else
                                Por favor ingrese apellidos válidos (máximo 20 caracteres, solo letras)
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Identificación</label>
                        <input type="text" name="identification" 
                               class="form-control @error('identification') is-invalid @enderror" 
                               value="{{ old('identification', $employee->identification) }}"
                               pattern="[0-9]{5,12}"
                               required>
                        <div class="invalid-feedback">
                            @error('identification')
                                {{ $message }}
                            @else
                                La identificación debe tener entre 5 y 12 números
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Teléfono</label>
                        <input type="tel" name="phone" 
                               class="form-control @error('phone') is-invalid @enderror" 
                               value="{{ old('phone', $employee->phone) }}"
                               pattern="[0-9]{7,12}"
                               required>
                        <div class="invalid-feedback">
                            @error('phone')
                                {{ $message }}
                            @else
                                El teléfono debe tener entre 7 y 12 números
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label fw-bold">Dirección</label>
                        <input type="text" name="address" 
                               class="form-control @error('address') is-invalid @enderror" 
                               value="{{ old('address', $employee->address) }}"
                               maxlength="20"
                               required>
                        <div class="invalid-feedback">
                            @error('address')
                                {{ $message }}
                            @else
                                La dirección no puede exceder los 20 caracteres
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">País</label>
                        <select class="form-select @error('country_id') is-invalid @enderror" 
                                id="country_id" name="country_id" required>
                            <option value="">Seleccione un país</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" 
                                    {{ old('country_id', $employee->city->country_id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione un país
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Ciudad</label>
                        <select class="form-select @error('city_id') is-invalid @enderror" 
                                id="city_id" name="city_id" required>
                            <option value="">Seleccione una ciudad</option>
                            @foreach($employee->city->country->cities as $city)
                                <option value="{{ $city->id }}" 
                                    {{ old('city_id', $employee->city_id) == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione una ciudad
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold mb-3">Cargo</label>
                        <div class="border rounded-3 p-4">
                            <div class="row g-3">
                                @foreach($positions as $position)
                                <div class="col-md-4">
                                    <div class="position-relative">
                                        <input type="radio"
                                            class="btn-check" 
                                            name="positions[]" 
                                            value="{{ $position->id }}"
                                            id="position{{ $position->id }}"
                                            {{ $position->isPresidenteOccupied() && !in_array($position->id, $employee->positions->pluck('id')->toArray()) ? 'disabled' : '' }}
                                            {{ in_array($position->id, old('positions', $employee->positions->pluck('id')->toArray())) ? 'checked' : '' }}
                                            required>
                                        <label class="btn btn-outline-secondary w-100 text-start position-relative {{ $position->isPresidenteOccupied() && !in_array($position->id, $employee->positions->pluck('id')->toArray()) ? 'opacity-50' : '' }}" for="position{{ $position->id }}">
                                            <span class="position-absolute top-50 start-0 translate-middle-y ms-2">
                                                <i class="far fa-circle"></i>
                                            </span>
                                            <span class="ms-4">{{ $position->name }}</span>
                                            @if($position->isPresidenteOccupied() && !in_array($position->id, $employee->positions->pluck('id')->toArray()))
                                                <span class="badge bg-danger position-absolute top-50 end-0 translate-middle-y me-2">Ocupado</span>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @error('positions')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div id="bossField" class="col-12" style="{{ old('is_president', $employee->is_president) ? 'display: none;' : '' }}">
                        <label class="form-label fw-bold">Jefe Inmediato</label>
                        <select class="form-select @error('boss_id') is-invalid @enderror" 
                                name="boss_id">
                            <option value="">Seleccione un jefe</option>
                            @foreach($employees as $boss)
                                <option value="{{ $boss->id }}" 
                                    {{ old('boss_id', $employee->boss_id) == $boss->id ? 'selected' : '' }}>
                                    {{ $boss->full_name }} 
                                    @if($boss->is_president)
                                        (Presidente)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('boss_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="d-flex align-items-center border rounded-3 p-3 bg-light">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       name="is_president" id="is_president"
                                       {{ old('is_president', $employee->is_president) ? 'checked' : '' }}>
                                <label class="form-check-label ms-2" for="is_president">
                                    <span class="fw-bold">¿Es el presidente de la empresa?</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('employees.index') }}" class="btn btn-outline-dark me-2">Cancelar</a>
                    <button type="submit" class="btn btn-dark px-4">
                        <i class="fas fa-save me-2"></i>Actualizar Empleado
                    </button>
                </div>
            </form>
        </div>
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

    $(document).ready(function() {
        const countrySelect = $('#country_id');
        const citySelect = $('#city_id');
        
        if (countrySelect.val()) {
            loadCities(countrySelect.val(), {{ json_encode(old('city_id', $employee->city_id)) }});
        }
        
        countrySelect.on('change', function() {
            loadCities($(this).val());
        });

        function loadCities(countryId, selectedCityId = null) {
            citySelect.prop('disabled', true);
            
            if (!countryId) {
                citySelect.empty().append('<option value="">Primero seleccione un país</option>');
                return;
            }

            $.get(`/api/cities/${countryId}`, function(data) {
                citySelect.empty().append('<option value="">Seleccione una ciudad</option>');
                
                data.forEach(city => {
                    const selected = (city.id == selectedCityId) ? 'selected' : '';
                    citySelect.append(`<option value="${city.id}" ${selected}>${city.name}</option>`);
                });
                
                citySelect.prop('disabled', false);
            }).fail(() => {
                citySelect.empty().prop('disabled', true);
            });
        }

        $('#is_president').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('#bossField').toggle(!isChecked);
            $('[name="boss_id"]').prop('required', !isChecked).val('').trigger('change');
        }).trigger('change');
    });
</script>
@endpush
@endsection