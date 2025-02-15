@extends('layouts.app')

@section('content')
<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">Editar Empleado: {{ $employee->name }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Nombres</label>
                    <input type="text" name="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $employee->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Apellidos</label>
                    <input type="text" name="surname" 
                           class="form-control @error('surname') is-invalid @enderror" 
                           value="{{ old('surname', $employee->surname) }}" required>
                    @error('surname')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Identificación</label>
                    <input type="text" name="identification" 
                           class="form-control @error('identification') is-invalid @enderror" 
                           value="{{ old('identification', $employee->identification) }}" required>
                    @error('identification')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="phone" 
                           class="form-control @error('phone') is-invalid @enderror" 
                           value="{{ old('phone', $employee->phone) }}" required>
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-12">
                    <label class="form-label">Dirección</label>
                    <textarea name="address" 
                              class="form-control @error('address') is-invalid @enderror" 
                              rows="2" 
                              required>{{ old('address', $employee->address) }}</textarea>
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">País de Nacimiento</label>
                    <select class="form-select @error('country_id') is-invalid @enderror" id="country_id" required>
                        <option value="">Seleccione un país</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" 
                                {{ $country->id == $employee->city->country_id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('country_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Ciudad de Nacimiento</label>
                    <select class="form-select @error('city_id') is-invalid @enderror" 
                            id="city_id" 
                            name="city_id" 
                            required>
                        <option value="">Seleccione una ciudad</option>
                        @foreach($employee->city->country->cities as $city)
                            <option value="{{ $city->id }}" 
                                {{ $city->id == $employee->city_id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('city_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Cargos</label>
                    <div class="border p-3 rounded">
                        @foreach($positions as $position)
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="positions[]" 
                                   value="{{ $position->id }}"
                                   id="position{{ $position->id }}"
                                   {{ in_array($position->id, $employee->positions->pluck('id')->toArray()) ? 'checked' : '' }}>
                            <label class="form-check-label" for="position{{ $position->id }}">
                                {{ $position->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @error('positions')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6">
                    <div class="form-check mb-3">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="is_president" 
                               id="is_president"
                               {{ $employee->is_president ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_president">
                            ¿Es el presidente de la empresa?
                        </label>
                    </div>
                    
                    <div id="bossField" style="{{ $employee->is_president ? 'display:none;' : '' }}">
                        <label class="form-label">Jefe Inmediato</label>
                        <select class="form-select @error('boss_id') is-invalid @enderror" 
                                name="boss_id">
                            <option value="">Seleccione un jefe</option>
                            @foreach($employees as $boss)
                                <option value="{{ $boss->id }}"
                                    {{ $boss->id == $employee->boss_id ? 'selected' : '' }}>
                                    {{ $boss->name }} {{ $boss->surname }}
                                </option>
                            @endforeach
                        </select>
                        @error('boss_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-warning btn-lg">Actualizar Empleado</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#country_id').change(function() {
            const countryId = $(this).val();
            const citySelect = $('#city_id');
            
            if(countryId) {
                citySelect.prop('disabled', false);
                
                $.get(`/api/cities/${countryId}`, function(data) {
                    citySelect.empty().append('<option value="">Seleccione una ciudad</option>');
                    $.each(data, function(key, city) {
                        citySelect.append($('<option></option>').attr('value', city.id).text(city.name));
                    });
                }).fail(function() {
                    citySelect.prop('disabled', true).empty();
                });
            } else {
                citySelect.prop('disabled', true).empty();
            }
        });

        $('#is_president').change(function() {
            $('#bossField').toggle(!this.checked);
            if(this.checked) {
                $('select[name="boss_id"]').val('').prop('required', false);
            } else {
                $('select[name="boss_id"]').prop('required', true);
            }
        });
    });
</script>
@endpush
@endsection