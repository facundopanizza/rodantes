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
        <td class="notexport"></td>
        <td>Código</td>
        <td>Nombre</td>
        <td>Descripción</td>
        <td>Proveedor</td>
        <td>Stock</td>
        @if (Auth::user()->role === "admin" || Auth::user()->role === "moderator")
          <td>Precios</td>
        @endif
      </tr>
    </thead>
    <tbody>
      @foreach ($products as $product)
      <tr>
        <td class="notexport">
          <div class="d-flex ">
            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info mx-1">Ver</a>

            <a href="{{ route('products.addToCaravan', $product->id) }}" class="btn btn-sm text-nowrap btn-success">Agregar a Caravana</a>

            @if(Auth::user()->role === "admin" || Auth::user()->role === "moderator")
              <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-success mx-1">Editar</a>
              <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                data-bs-target="#confirmDelete{{ $product->id }}">Borrar</button>
            @endif
          </div>
        </td>
        <td>{{ $product->id }}</td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->description }}</td>
        <td>{{ $product->supplier ? $product->supplier->name : "" }}</td>
        <td>{{ $product->getStock() }}</td>
        @if (Auth::user()->role === "admin" || Auth::user()->role === "moderator")
          <td>@money($product->prices->min("price"))-@money($product->prices->max("price"))</td>
        @endif
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
  </x-table>
</x-card>
@endsection