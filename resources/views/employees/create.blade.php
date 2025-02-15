@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-dark text-white py-3">
            <h4 class="mb-0">Registrar Nuevo Empleado</h4>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('employees.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombres</label>
                        <input type="text" name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" 
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
                        <label class="form-label">Apellidos</label>
                        <input type="text" name="surname" 
                               class="form-control @error('surname') is-invalid @enderror" 
                               value="{{ old('surname') }}" 
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
                        <label class="form-label">Identificación</label>
                        <input type="text" name="identification" 
                               class="form-control @error('identification') is-invalid @enderror" 
                               value="{{ old('identification') }}" 
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
                        <label class="form-label">Teléfono</label>
                        <input type="tel" name="phone" 
                               class="form-control @error('phone') is-invalid @enderror" 
                               value="{{ old('phone') }}" 
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
                        <label class="form-label">Dirección</label>
                        <input type="text" name="address" 
                               class="form-control @error('address') is-invalid @enderror" 
                               value="{{ old('address') }}"
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
                        <label class="form-label">País</label>
                        <select class="form-select @error('country_id') is-invalid @enderror" 
                                id="country_id" name="country_id" required>
                            <option value="">Seleccione un país</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" 
                                    {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione un país
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ciudad</label>
                        <select class="form-select @error('city_id') is-invalid @enderror" 
                                id="city_id" name="city_id" required 
                                {{ old('country_id') ? '' : 'disabled' }}>
                            <option value="">Primero seleccione un país</option>
                            @if(old('country_id'))
                                @foreach(\App\Models\City::where('country_id', old('country_id'))->get() as $city)
                                    <option value="{{ $city->id }}" 
                                        {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione una ciudad
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Cargo</label>
                        <div class="border rounded p-3">
                            @foreach($positions as $position)
                            <div class="form-check">
                                <input type="radio"
                                    class="form-check-input" 
                                    name="positions[]" 
                                    value="{{ $position->id }}"
                                    id="position{{ $position->id }}"
                                    {{ $position->isPresidenteOccupied() ? 'disabled' : '' }}
                                    {{ in_array($position->id, old('positions', [])) ? 'checked' : '' }}
                                    required>
                                <label class="form-check-label" for="position{{ $position->id }}">
                                    {{ $position->name }}
                                    @if($position->isPresidenteOccupied())
                                        <span class="badge bg-danger">Ocupado</span>
                                    @endif
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @error('positions')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div id="bossField" class="col-12" style="{{ old('is_president') ? 'display: none;' : '' }}">
                        <label class="form-label">Jefe Inmediato</label>
                        <select class="form-select @error('boss_id') is-invalid @enderror" 
                                name="boss_id">
                            <option value="">Seleccione un jefe</option>
                            @foreach($employees as $boss)
                                <option value="{{ $boss->id }}" 
                                    {{ old('boss_id') == $boss->id ? 'selected' : '' }}>
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

                    <div class="col-12 mt-4">
                        <div class="alert alert-info d-flex align-items-center">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       name="is_president" id="is_president" style="transform: scale(1.4);"
                                       {{ old('is_president') ? 'checked' : '' }}>
                                <label class="form-check-label ms-2 fw-bold" for="is_president">
                                    ¿Es el presidente de la empresa?
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        Guardar Empleado
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
            loadCities(countrySelect.val(), {{ json_encode(old('city_id')) }});
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