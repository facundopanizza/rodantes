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
      @if (Auth::user()->role === "admin")
        <div>
          <p>Gasto Total: @money($caravan->getTotal())</p>
        </div>
      @endif
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

        <div class="mb-3">
        <label for="employee_id" class="form-label">Empleado</label>
        <select class="form-control" name="employee_id">
            @foreach (\App\Models\Employee::all() as $employee)
                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
            @endforeach
        </select>
        @error("employee_id")
        <div class="text-danger">{{ $message }}</div>
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
        <td class="notexport"></td>
        <td>Producto</td>
        <td>Fecha</td>
        <td>Cantidad</td>
        <td>Empleado</td>
        @if (Auth::user()->role === "admin")
          <td>Precio</td>
          <td>IVA</td>
          <td>Total (Con IVA)</td>
        @endif
      </tr>
    </thead>
    <tbody>
      @foreach ($caravan->products as $product)
      <tr>
        <td class="notexport">
          <div class="d-flex ">
            <a href="{{ route('caravans.add_product_form', [ $caravan, $product ]) }}"
              class="btn btn-sm btn-success mx-1">Agregar</a>
            @if (Auth::user()->role === "admin" || Auth::user()->role === "moderator")
              <a href="{{ route('caravans.sub_product_form', [ $caravan, $product, "employee_id" => $product->pivot->employee_id ]) }}"
                class="btn btn-sm btn-outline-danger">Quitar</a>
            @endif
          </div>
        </td>
        <td>{{ $product->product->name }}</td>
        <td class="notexport">{{ \Carbon\Carbon::parse($product->pivot->updated_at)->format("d/m/Y") }}</td>
        <td>{{ $product->pivot->quantity }}</td>
        <td>{{ $product->pivot->employee_id ? \App\Models\Employee::find($product->pivot->employee_id)->name : "" }}</td>
        @if (Auth::user()->role === "admin")
          <td>@money($product->price)</td>
          <td>{{ $product->iva }}%</td>
          <td>@money($product->getTotal())</td>
        @endif
      </tr>
      <x-modal-action :key="$caravan->id" message="Esta seguro que desea borrar este caravana?">
        <form method="POST" action="{{ route('caravans.destroy', $caravan->id) }}">
          @csrf
          @method("delete")
          <button type="submit" class="btn btn-outline-danger">Si, borrar</button>
        </form>
      </x-modal-action>
      @endforeach
      @if (Auth::user()->role === "admin")
        <tr>
          <td class="notexport"></td>
          <td>Total</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>@money($caravan->getTotal())</td>
        </tr>
      @endif
    </tbody>
  </x-table>
</x-card>
@endsection
