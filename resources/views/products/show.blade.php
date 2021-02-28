@extends('layouts.layout')

@section('title', 'Producto - ' . $product->name)

@section('main')
<x-card :header="$product->name">
  <div class="card mb-3 rounded">
    <div class="row g-0">
      <div class="col-md-4">
        <a class="btn p-0 border-0" data-bs-toggle="modal" data-bs-target="#photo{{ $product->id }}">
          <img class="img-fluid rounded" style="" src="{{ asset($product->picture) }}" alt="{{ $product->name }}">
        </a>
        <x-photo :key="$product->id" :link="$product->picture" />
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <p class="">Proveedor: <strong>{{ $product->supplier->name }}</strong></p>
          <p>{{ $product->description }}</p>
          <a href="data:image/png;base64,{{ DNS1D::getBarcodePNG(strval($product->id ), 'C128A', 3, 33) }}"
            download="producto-{{ $product->id }}.png" class="btn btn-success">Descargar
            código de barras</a>
        </div>
      </div>
    </div>
  </div>

  <x-table>
    <thead>
      <tr>
        <td>Precio</td>
        <td>Stock</td>
        <td>Fecha</td>
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
        <td>{{ $price->created_at }}</td>
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