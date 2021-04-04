@extends('layouts.layout')

@section('title', "Crear Caravana")

@section('main')
<x-card header="Crear Caravana">
  <form method="POST" action="{{ route('caravans.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
      <label for="vehicle" class="form-label">Vehículo</label>
      <input required name="vehicle" type="text" class="form-control @error('vehicle') is-invalid @enderror"
        placeholder="Vehículo" value="{{ old('vehicle') }}">
      @error("vehicle")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="type" class="form-label">Tipo de Carrozado</label>
      <input required name="type" type="text" class="form-control @error('type') is-invalid @enderror"
        placeholder="Tipo de Carrozado" value="{{ old('type') }}">
      @error("type")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="model" class="form-label">Modelo de Carrozado</label>
      <input required name="model" type="text" class="form-control @error('model') is-invalid @enderror"
        placeholder="Modelo de Carrozado" value="{{ old('model') }}">
      @error("model")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="picture" class="form-label">Foto (Opcional)</label>
      <input name="picture" type="file" class="form-control @error('picture') is-invalid @enderror"
        value="{{ old('picture') }}">
      @error("picture")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="supplier" class="form-label">Cliente</label>
      <select name="client_id" class="form-control">
        <option value="null">Sin Cliente</option>
        @foreach ($clients as $client)
        <option value="{{ $client->id }}">{{ $client->getFullName() }}</option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn btn-success">Crear</button>
  </form>
</x-card>
@endsection