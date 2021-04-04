@extends('layouts.layout')

@section('title', 'Editar Proveedor')

@section('main')
<x-card header="Editar Proveedor">
  <form method="POST" action="{{ route('suppliers.update', $supplier->id) }}">
    @csrf
    @method("patch")
    <div class="mb-3">
      <label for="name" class="form-label">Nombre</label>
      <input required name="name" type="text" class="form-control @error('name') is-invalid @enderror"
        placeholder="Samsung" value="{{ old('name') ? old('name') : $supplier->name }}">
      @error("name")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="phone" class="form-label">Teléfono</label>
      <input required name="phone" type="number" class="form-control @error('phone') is-invalid @enderror"
        placeholder="113457345" value="{{ old('phone') ? old('phone') : $supplier->phone }}">
      @error("phone")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="address" class="form-label">Dirección</label>
      <textarea required name="address" type="text" class="form-control @error('address') is-invalid @enderror"
        placeholder="El Pato, Berazategui. 530  entre 631 y 630">{{ old('address') ? old('address') : $supplier->address }}</textarea>
      @error("address")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <button class="btn btn-success">Editar</button>
    </div>
  </form>
</x-card>
@endsection