@extends('layouts.layout')

@section('title', 'Caravana - ' . $caravan->model)

@section('main')
<x-card :header="$caravan->vehicle">
  <div class="row g-0 mb-4">
    <div class="col-md-4">
      <a class="btn p-0 border-0" data-bs-toggle="modal" data-bs-target="#photo{{ $caravan->id }}">
        <img class="img-fluid rounded" style="" src="{{ $caravan->picture ? asset($caravan->picture) : asset('img/placeholder.png') }}" alt="{{ $caravan->model }}">
      </a>
      <x-photo :key="$caravan->id" :link="$caravan->picture ? $caravan->picture : 'img/placeholder.png'" />
    </div>
    <div class="col-md-8 px-4">
      <div>
        <p>Vehículo: <strong>{{ $caravan->vehicle }}</strong></p>
      </div>
      @if($caravan->client)
        <div>
          <p>Cliente: <strong>{{ $caravan->client->getFullName() }}</strong></p>
        </div>
      @endif
      <div>
        <p>Tipo de Carrozado: <strong>{{ $caravan->type }}</strong></p>
      </div>
      <div>
        <p>Modelo de Carrozado: <strong>{{ $caravan->model }}</strong></p>
      </div>
      <div>
        <p>Gasto Total: @money($caravan->getTotal())</p>
      </div>
    </div>
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
        <td>Producto</td>
        <td>Fecha</td>
        <td>Cantidad</td>
        <td>Precio</td>
        <td>IVA</td>
        <td>Total (Con IVA)</td>
        <td class="notexport"></td>
      </tr>
    </thead>
    <tbody>
      @foreach ($caravan->products as $product)
      <tr>
        <td>{{ $product->product->name }}</td>
        <td class="notexport">{{ $product->pivot->updated_at }}</td>
        <td>{{ $product->pivot->quantity }}</td>
        <td>@money($product->price)</td>
        <td>{{ $product->iva }}%</td>
        <td>@money($product->getTotal())</td>
        <td class="notexport">
          <div class="d-flex flex-nowrap justify-content-between">
            <a href="{{ route('caravans.add_product_form', [ $caravan, $product ]) }}"
              class="btn btn-sm btn-success mx-1">Agregar</a>
            <a href="{{ route('caravans.sub_product_form', [ $caravan, $product ]) }}"
              class="btn btn-sm btn-outline-danger">Quitar</a>
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
        <td></td>
        <td>@money($caravan->getTotal())</td>
        <td class="notexport"></td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <th>Producto</th>
        <th>Fecha</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>IVA</th>
        <th>Total</th>
        <th class="notexport">Botones</th>
      </tr>
    </tfoot>
  </x-table>
</x-card>
@endsection