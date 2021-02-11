@extends('layouts.layout')

@section('title', 'Crear Proveedor')

@section('main')
<x-card header="Crear Proveedor">
  <form method="POST" action="{{ route("suppliers.store") }}">
    @csrf
    <div class="mb-3">
      <label for="name" class="form-label">Nombre</label>
      <input required name="name" type="text" class="form-control @error('name') is-invalid @enderror"
        placeholder="Proveedor" value="{{ old('name')}}">
      @error("name")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <button class="btn btn-success">Crear</button>
  </form>
</x-card>
@endsection