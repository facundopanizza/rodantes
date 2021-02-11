@extends('layouts.layout')

@section('title', 'Editar Precio')

@section('main')
<x-card header="Editar Precio">
  <form method="POST" action="{{ route("prices.update", $price->id) }}">
    @csrf
    @method("patch")

    <div class="mb-3">
      <label for="price" class="form-label">Precio (Decimal separado por un punto, máximo 2 decimales)</label>
      <input required name="price" type="text" class="form-control @error('price') is-invalid @enderror"
        placeholder="100" value="{{ old('price') ? old('price') : $price->price}}" min="0">
      @error("price")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="stock" class="form-label">Stock</label>
      <input name="stock" type="number" class="form-control @error('stock') is-invalid @enderror" placeholder="2"
        value="{{old('stock') ? old('stock') : $price->stock}}" min="0">
      @error("stock")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button class="btn btn-success">Editar</button>
  </form>
</x-card>
@endsection