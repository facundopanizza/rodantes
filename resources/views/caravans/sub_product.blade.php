@extends('layouts.layout')

@section('title', 'Caravana - ' . $caravan->name)

@section('main')
<x-card header="Quitar Productos">
  <form method="POST" action="{{ route('caravans.sub_product', $caravan->id) }}">
    @csrf
    @method("PATCH")
    <input type="hidden" name="price_id" value="{{ $price->id }}">
    <input type="hidden" name="employee_id" value="{{ $employee_id }}">

    <div class="input-group">
      <input placeholder="3" type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
        value="{{ old('quantity') ? old('quantity') : '' }}" min="0" required>
      <button type="submit" class="btn btn-success">Quitar</button>
    </div>
    @error('quantity')
    <span class="text-danger">{{ $message }}</span>
    @enderror
  </form>
</x-card>
@endsection
