@extends('layouts.layout')

@section('title', "Editar Caravana")

@section('main')
<x-card header="Editar Caravana">
  <form method="POST" action="{{ route('caravans.update', $caravan->id) }}" enctype="multipart/form-data">
    @csrf
    @method("patch")

    <div class="mb-3">
      <label for="vehicle" class="form-label">Vehículo</label>
      <input required name="vehicle" type="text" class="form-control @error('vehicle') is-invalid @enderror"
        placeholder="Vehículo" value="{{  old('vehicle') ? old('vehicle') : $caravan->vehicle }}">
      @error("vehicle")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="type" class="form-label">Tipo de Carrozado</label>
      <input required name="type" type="text" class="form-control @error('type') is-invalid @enderror"
        placeholder="Tipo de Carrozado" value="{{  old('type') ? old('type') : $caravan->type }}">
      @error("type")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="model" class="form-label">Modelo de Carrozado</label>
      <input required name="model" type="text" class="form-control @error('model') is-invalid @enderror"
        placeholder="Modelo de Carrozado" value="{{ old('model') ? old('model') : $caravan->model }}">
      @error("model")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="picture" class="form-label">Foto (Opcional)</label>
      <input name="picture" type="file" class="form-control @error('picture') is-invalid @enderror"
        value="{{ old('picture') ? old('picture') : $caravan->picture }}">
      @error("picture")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="supplier" class="form-label">Cliente</label>
      <select name="client_id" class="form-control">
        <option value="null">Sin Cliente</option>
        @foreach ($clients as $client)
        <option value="{{ $client->id }}" @if ($caravan->client && $client->id === $caravan->client->id) selected
          @endif>{{ $client->getFullName() }}</option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn btn-success">Editar</button>
  </form>
</x-card>
@endsection