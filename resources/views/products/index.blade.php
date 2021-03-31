@extends('layouts.layout')

@section('title', 'Productos')

@section('main')
<x-card header="Productos">
  <x-table>
    <thead>
      <tr>
        <td>Código</td>
        <td>Nombre</td>
        <td>Descripción</td>
        <td>Proveedor</td>
        <td>Precios</td>
        <td>Stock</td>
        <td class="notexport"></td>
      </tr>
    </thead>
    <tbody>
      @foreach ($products as $product)
      <tr>
        <td>{{ $product->id }}</td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->description }}</td>
        <td>{{ $product->supplier ? $product->supplier->name : "" }}</td>
        <td>@money($product->prices->min("price"))-@money($product->prices->max("price"))</td>
        <td>{{ $product->getStock() }}</td>
        <td class="notexport">
          <div class="d-flex flex-nowrap justify-content-between">
            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">Ver</a>
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-success mx-1">Editar</a>
            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
              data-bs-target="#confirmDelete{{ $product->id }}">Borrar</button>
          </div>
        </td>
      </tr>
      <x-modal-action :key="$product->id" message="Esta seguro que desea borrar este producto?">
        <form method="POST" action="{{ route('products.destroy', $product->id) }}">
          @csrf
          @method("delete")
          <button type="submit" class="btn btn-outline-danger">Si, borrar</button>
        </form>
      </x-modal-action>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th>Código</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Proveedor</th>
        <th>Precios</th>
        <th>Stock</th>
        <th class="notexport">Botones</th>
      </tr>
    </tfoot>
  </x-table>
</x-card>
@endsection