@extends('layouts.layout')

@section('title', "Crear Product")

@section('main')
<x-card header="Agregar producto a caravana">
  <form method="POST" action="{{ route('products.storeToCaravan', $product->id) }}">
    @csrf

    <input type="hidden" name="term" value="{{ $product->id }}">

    <div class="mb-3">
      <label for="caravan_id" class="form-label">Caravana</label>
      <select class="form-control" name="caravan_id">
        @foreach ($caravans as $caravan)
          @if($caravan->client)
            <option value="{{ $caravan->id }}">{{ $caravan->vehicle }} / {{ $caravan->client->getFullName() }}</option>
          @endif
        @endforeach
      </select>
      @error("caravan_id")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="quantity" class="form-label">Cantidad</label>
      <input placeholder="3" type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
        value="{{ old('quantity') ? old('quantity') : '' }}" min="1" required>
      @error('quantity')
      <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>

    <button type="submit" class="btn btn-success">Agregar</button>
  </form>
</x-card>
@endsection