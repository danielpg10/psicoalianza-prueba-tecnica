@extends('layouts.app')

@section('content')
<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">Editar Ciudad: {{ $city->name }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('cities.update', $city->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">País</label>
                    <select name="country_id" class="form-select @error('country_id') is-invalid @enderror" required>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" 
                                {{ $country->id == $city->country_id ? 'selected' : '' }}>
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
                           value="{{ old('name', $city->name) }}" 
                           required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-warning btn-lg">Actualizar Ciudad</button>
            </div>
        </form>
    </div>
</div>
@endsection