@extends('layouts.layout')

@section('title', "Editar Producto")

@section('main')
<x-card header="Editar Producto">
  <form method="POST" action="{{ route("products.update", $product->id) }}" enctype="multipart/form-data">
    @csrf
    @method("patch")

    <div class="mb-3">
      <label for="name" class="form-label">Nombre</label>
      <input required name="name" type="text" class="form-control @error('name') is-invalid @enderror"
        placeholder="Ruedas" value="{{ old('name') ? old('name') : $product->name }}">
      @error("name")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Descripción (Opcional)</label>
      <textarea name="description" type="text" class="form-control @error('description') is-invalid @enderror"
        placeholder="Ruedas">{{ old("description") ? old("description") : $product->description }}</textarea>
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
        <option value="{{ $supplier->id }}" @if ($supplier->id === $product->supplier_id) selected
          @endif>{{ $supplier->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="category" class="form-label">Categoría</label>
      <select name="category_id" class="form-control">
        <option>Sin Categoría</option>
        @foreach ($categories as $category)
          <option value="{{ $category->id }}" @if ($category->id === $product->category_id) selected @endif>{{ $category->name }}</option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn btn-success">Editar</button>
  </form>
</x-card>
@endsection