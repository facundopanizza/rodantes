@extends('layouts.layout')

@section('title', 'Caravana - ' . $caravan->name)

@section('main')
<x-card header="Agregar mas Productos">
  <form method="POST" action="{{ route('caravans.add_product_edit', $caravan->id) }}">
    @csrf
    @method("PATCH")
    <input type="hidden" name="price_id" value="{{ $price->id }}">

    <div class="input-group">
      <input placeholder="3" type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
        value="{{ old('quantity') ? old('quantity') : '' }}" min="1" required>
      <button type="submit" class="btn btn-success">Agregar</button>
    </div>
    @error('quantity')
    <span class="text-danger">{{ $message }}</span>
    @enderror
  </form>
</x-card>
@endsection