@extends('layouts.layout')

@section('title', 'Producto - ' . $product->name)

@section('main')
<x-card :header="$product->name">
  <img class="img-fluid mx-auto d-block rounded" style="max-height: 500px" src="{{ asset($product->picture) }}"
    alt="{{ $product->name }}">
  <div class="my-4 d-flex justify-content-center">
    <p class="mx-4">Proveedor: <strong>{{ $product->supplier->name }}</strong></p>
    <a href="data:image/png;base64,{{ DNS1D::getBarcodePNG(strval($product->id ), 'C128A', 3, 33) }}"
      download="producto-{{ $product->id }}.png" class="btn btn-success mx-4">Descargar
      código de barras</a>
  </div>
  <p>{{ $product->description }}</p>

  <x-table>
    <thead>
      <tr>
        <td>Precio</td>
        <td>Stock</td>
        <td>
          <a href="{{ route('prices.create', $product->id) }}" class="btn btn-sm btn-success">Agregar Precio</a>
        </td>
      </tr>
    </thead>
    <tbody>
      @foreach ($product->prices as $price)
      <tr>
        <td>{{ $price->price }}</td>
        <td>{{ $price->stock }}</td>
        <td>
          <div class="d-flex flex-nowrap justify-content-between">
            <a href="{{ route('prices.edit', $price->id) }}" class="btn btn-sm btn-success mx-1">Editar</a>
            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
              data-bs-target="#confirmDelete{{ $price->id }}">Borrar</button>
          </div>
        </td>
      </tr>
      <x-modal-action :key="$price->id" message="Esta seguro que desea borrar este precio?">
        <form method="POST" action="{{ route('prices.destroy', $price->id) }}">
          @csrf
          @method("delete")
          <button type="submit" class="btn btn-outline-danger">Si, borrar</button>
        </form>
      </x-modal-action>
      @endforeach
    </tbody>
  </x-table>
</x-card>
@endsection