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
    <button class="btn btn-success">Editar</button>
    </div>
  </form>
</x-card>
@endsection