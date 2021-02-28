@extends('layouts.layout')

@section('title', 'Productos')

@section('main')
<x-card header="Productos">
  <x-table>
    <thead>
      <tr>
        <td>#</td>
        <td>Nombre</td>
        <td>Descripción</td>
        <td>Proveedor</td>
        <td></td>
      </tr>
    </thead>
    <tbody>
      @foreach ($products as $product)
      <tr>
        <td>{{ $product->id }}</td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->description }}</td>
        <td>{{ $product->supplier->name }}</td>
        <td>
          <div class="d-flex">
            <form action="{{ route('caravans.add_product', $caravan->id) }}" method="POST">
              @csrf

              <input type="hidden" name="term" value="{{ $product->id }}">
              <input type="hidden" name="quantity" value="{{ $quantity }}">

              <button type="submit" class="btn btn-sm btn-success mx-2">Agregar</button>
            </form>

            <a target="_blank" href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">Ver</a>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </x-table>
</x-card>
@endsection