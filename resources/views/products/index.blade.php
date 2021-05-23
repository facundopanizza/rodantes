@extends('layouts.layout')

@section('title', 'Productos')

@section('main')
<x-card header="Productos">
  @error('constrained')
  <div class="mb-3">
    <h2 class="text-danger">{{ $message }}</h2>
  </div>
  @enderror

  <x-table>
    <thead>
      <tr>
        <td>Código</td>
        <td>Nombre</td>
        <td>Descripción</td>
        <td>Proveedor</td>
        <td>Stock</td>
        @if (Auth::user()->role === "admin")
          <td>Precios</td>
        @endif
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
        <td>{{ $product->getStock() }}</td>
        @if (Auth::user()->role === "admin")
          <td>@money($product->prices->min("price"))-@money($product->prices->max("price"))</td>
        @endif
        <td class="notexport">
          <div class="d-flex flex-nowrap justify-content-between">
            @if(Auth::user()->role === "admin" || Auth::user()->role === "moderator" || Auth::user()->role === "employee")
              <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info mx-1">Ver</a>
            @endif

            @if(Auth::user()->role === "admin" || Auth::user()->role === "employee")
              <a href="{{ route('products.addToCaravan', $product->id) }}" class="btn btn-sm text-nowrap btn-success">Agregar a Caravana</a>
            @endif

            @if(Auth::user()->role === "admin" || Auth::user()->role === "moderator")
              <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-success mx-1">Editar</a>
              <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                data-bs-target="#confirmDelete{{ $product->id }}">Borrar</button>
            @endif
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
        <th>Stock</th>
        @if (Auth::user()->role === "admin")
          <th>Precios</th>
        @endif
        <th class="notexport">Botones</th>
      </tr>
    </tfoot>
  </x-table>
</x-card>
@endsection