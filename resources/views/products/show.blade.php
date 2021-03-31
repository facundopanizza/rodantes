@extends('layouts.layout')

@section('title', 'Producto - ' . $product->name)

@section('main')
<x-card :header="$product->name">
  <div class="card mb-3 rounded">
    <div class="row g-0">
      <div class="col-md-4">
        <a class="btn p-0 border-0" data-bs-toggle="modal" data-bs-target="#photo{{ $product->id }}">
          <img class="img-fluid rounded" style="" src="{{ $product->picture ? asset($product->picture) : asset('img/placeholder.png') }}" alt="{{ $product->name }}">
        </a>
        <x-photo :key="$product->id" :link="$product->picture ? $product->picture : 'img/placeholder.png'" />
      </div>
      <div class="col-md-8">
        <div class="card-body">
          @if($product->supplier)
            <p class="">Proveedor: <strong>{{ $product->supplier->name }}</strong></p>
          @endif
          <p>{{ $product->description }}</p>
          <a href="data:image/png;base64,{{ DNS1D::getBarcodePNG(strval($product->id ), 'C128A', 3, 50, array(0, 0, 0), true) }}"
            download="producto-{{ $product->id }}.png" class="btn btn-success">Descargar
            código de barras</a>
          <p class="mt-3">Codigo: {{ $product->id }}</p>
        </div>
      </div>
    </div>
  </div>

  <x-table>
    <div class="my-3">
      <a href="{{ route('prices.create', $product->id) }}" class="btn btn-sm btn-success">Agregar Precio</a>
    </div>
    <thead>
      <tr>
        <td>Precio</td>
        <td>Iva</td>
        <td>Stock</td>
        <td>Fecha</td>
        <td class="notexport"></td>
      </tr>
    </thead>
    <tbody>
      @foreach ($product->prices as $price)
      @if ($price->stock !== 0)
      <tr>
        <td>@money($price->price)</td>
        <td>{{ $price->iva }}</td>
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
      @endif
      @endforeach
    </tbody>
      <tfoot>
        <tr>
          <th>Precio</th>
          <th>Iva</th>
          <th>Stock</th>
          <th>Fecha</th>
          <th class="notexport">Botones</th>
        </tr>
      </tfoot>
  </x-table>
</x-card>
@endsection