@extends('layouts.layout')

@section('title', "Crear Caravana")

@section('main')
<x-card header="Crear Caravana">
  <form method="POST" action="{{ route("caravans.store") }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
      <label for="name" class="form-label">Nombre</label>
      <input required name="name" type="text" class="form-control @error('name') is-invalid @enderror"
        placeholder="Caravan Ford 1510" value="{{ old('name') }}">
      @error("name")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="plate" class="form-label">Patente</label>
      <input required name="plate" type="text" class="form-control @error('plate') is-invalid @enderror"
        placeholder="AA123AA" value="{{ old('plate') }}">
      @error("plate")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button type="submit" class="btn btn-success">Crear</button>
  </form>
</x-card>
@endsection