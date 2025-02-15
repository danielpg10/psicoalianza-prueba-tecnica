@extends('layouts.app')

@section('content')
<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">Registrar Nueva Ciudad</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('cities.store') }}" method="POST">
            @csrf
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">País</label>
                    <select name="country_id" class="form-select @error('country_id') is-invalid @enderror" required>
                        <option value="">Seleccione un país</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('country_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Nombre de la Ciudad</label>
                    <input type="text" 
                           name="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" 
                           required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary btn-lg">Guardar Ciudad</button>
            </div>
        </form>
    </div>
</div>
@endsection