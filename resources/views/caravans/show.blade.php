@extends('layouts.layout')

@section('title', 'Caravana - ' . $caravan->name)

@section('main')
<x-card :header="$caravan->name">
  <div class="my-4 d-flex justify-content-center">
    <p class="mx-4">Patente: <strong>{{ $caravan->plate }}</strong></p>
    @if($caravan->client)
    <p>Cliente: <strong>{{ $caravan->client->getFullName() }}</strong></p>
    @endif
  </div>

  <div class="mb-3">
    <form method="POST" action="{{ route("caravans.add_product", $caravan->id) }}">
      @csrf

      <div class="mb-2">
        <label for="form-label">Cantidad</label>
        <input placeholder="3" type="number" name="quantity"
          class="form-control @error('quantity') is-invalid @enderror"
          value="{{ old('quantity') ? old('quantity') : '' }}" min="1" required>
        @error('quantity')
        <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <div class="mb-2">
        <label for="form-label">Código de Barras o Nombre del producto</label>
        <input placeholder="Ruedas" class="form-control @error('term') is-invalid @enderror" type="text" name="term"
          value="{{ old('term') ? old('term') : '' }}" required>
        @error('term')
        <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>
      <button type="submit" class="btn btn-success">Agregar Producto</button>
    </form>
  </div>

  <x-table>
    <thead>
      <tr>
        <td class="notexport">#</td>
        <td>Nombre</td>
        <td>Cantidad</td>
        <td>Precio</td>
        <td>Total</td>
        <td class="notexport"></td>
      </tr>
    </thead>
    <tbody>
      @foreach ($caravan->products as $product)
      <tr>
        <td class="notexport">{{ $product->pivot->id }}</td>
        <td>{{ $product->product->name }}</td>
        <td>{{ $product->pivot->quantity }}</td>
        <td>@money($product->price)</td>
        <td>@money($product->getTotal())</td>
        <td class="notexport">
          <div class="d-flex flex-nowrap justify-content-between">
            <a href="{{ route('caravans.add_product_form', [ $caravan, $product ]) }}"
              class="btn btn-sm btn-success">Agregar</a>
            <a href="{{ route('caravans.sub_product_form', [ $caravan, $product ]) }}"
              class="btn btn-sm btn-outline-success">Quitar</a>
            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
              data-bs-target="#confirmDelete{{ $caravan->id }}">Borrar</button>
          </div>
        </td>
      </tr>
      <x-modal-action :key="$caravan->id" message="Esta seguro que desea borrar este caravana?">
        <form method="POST" action="{{ route('caravans.destroy', $caravan->id) }}">
          @csrf
          @method("delete")
          <button type="submit" class="btn btn-outline-danger">Si, borrar</button>
        </form>
      </x-modal-action>
      @endforeach
      <tr>
        <td>Total</td>
        <td></td>
        <td></td>
        <td></td>
        <td>@money($caravan->getTotal())</td>
        <td class="notexport"></td>
      </tr>
    </tbody>
  </x-table>
</x-card>
@endsection