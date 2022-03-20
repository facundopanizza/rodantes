@extends('layouts.layout')

@section('title', 'Crear Proveedor')

@section('main')
<x-card header="Crear Proveedor">
  <form method="POST" action="{{ route('suppliers.store') }}">
    @csrf
    <div class="mb-3">
      <label for="name" class="form-label">Nombre</label>
      <input required name="name" type="text" class="form-control @error('name') is-invalid @enderror"
        placeholder="Proveedor" value="{{ old('name')}}">
      @error("name")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="phone" class="form-label">Teléfono (Opcional)</label>
      <input name="phone" type="number" class="form-control @error('phone') is-invalid @enderror"
        placeholder="113457345" value="{{ old('phone')}}">
      @error("phone")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="address" class="form-label">Dirección (Opcional)</label>
      <textarea name="address" type="text" class="form-control @error('address') is-invalid @enderror"
        placeholder="El Pato, Berazategui. 530  entre 631 y 630">{{ old('address')}}</textarea>
      @error("address")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <button class="btn btn-success">Crear</button>
  </form>
</x-card>
@endsection