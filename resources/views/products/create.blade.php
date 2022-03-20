@extends('layouts.layout')

@section('title', "Crear Product")

@section('main')
<x-card header="Crear Producto">
  <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
      <label for="name" class="form-label">Nombre</label>
      <input required name="name" type="text" class="form-control @error('name') is-invalid @enderror"
        placeholder="Ruedas" value="{{ old('name') }}">
      @error("name")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="name" class="form-label">Descripción (Opcional)</label>
      <textarea name="description" type="text" class="form-control @error('description') is-invalid @enderror"
        placeholder="Ruedas">{{ old("description") }}</textarea>
      @error("description")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="picture" class="form-label">Foto (Opcional)</label>
      <input name="picture" type="file" class="form-control @error('picture') is-invalid @enderror" />
      @error("picture")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="supplier" class="form-label">Proveedor</label>
      <select name="supplier_id" class="form-control">
        <option>Sin Proveedor</option>
        @foreach ($suppliers as $supplier)
        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="category" class="form-label">Categoría</label>
      <select name="category_id" class="form-control">
        <option>Sin Categoría</option>
        @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn btn-success">Crear</button>
  </form>
</x-card>
@endsection