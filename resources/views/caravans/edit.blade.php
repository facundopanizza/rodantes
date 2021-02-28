@extends('layouts.layout')

@section('title', "Editar Caravana")

@section('main')
<x-card header="Editar Caravana">
  <form method="POST" action="{{ route("caravans.update", $caravan->id) }}" enctype="multipart/form-data">
    @csrf
    @method("patch")

    <div class="mb-3">
      <label for="name" class="form-label">Nombre</label>
      <input required name="name" type="text" class="form-control @error('name') is-invalid @enderror"
        placeholder="Caravan Ford 1510" value="{{ old('name') ? old('name') : $caravan->name }}">
      @error("name")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="plate" class="form-label">Patente</label>
      <input required name="plate" type="text" class="form-control @error('plate') is-invalid @enderror"
        placeholder="Caravan Ford 1510" value="{{ old('plate') ? old('plate') : $caravan->plate }}">
      @error("plate")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="supplier" class="form-label">Cliente</label>
      <select name="client_id" class="form-control">
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