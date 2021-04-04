@extends('layouts.layout')

@section('title', 'Caravanas')

@section('main')
<x-card header="Caravanas">
  @error('constrained')
  <div class="mb-3">
    <h2 class="text-danger">{{ $message }}</h2>
  </div>
  @enderror

  <x-table>
    <thead>
      <tr>
        <th class="notexport">Foto</th>
        <td>Cliente</td>
        <td>Vehículo</td>
        <td>Tipo de Carrozado</td>
        <td>Modelo de Carrozado</td>
        <td class="notexport"></td>
      </tr>
    </thead>
    <tbody>
      @foreach ($caravans as $caravan)
      <tr>
        <td class="notexport">
          <a class="btn p-0 border-0" data-bs-toggle="modal" data-bs-target="#photo{{ $caravan->id }}">
            <img width="50" height="50" style="border-radius: 50%; object-fit: cover"
              src="{{ asset($caravan->picture ? $caravan->picture : 'img/placeholder.png') }}" alt="{{ $caravan->vehicle }}">
          </a>
          <x-photo :key="$caravan->id" :link="$caravan->picture ? $caravan->picture : 'img/placeholder.png'" />
        </td>
        <td>{{ $caravan->client ? $caravan->client->getFullName() : "" }}</td>
        <td>{{ $caravan->vehicle }}</td>
        <td>{{ $caravan->type }}</td>
        <td>{{ $caravan->model }}</td>
        <td class="notexport">
          <div class="d-flex flex-nowrap justify-content-between">
            <a href="{{ route('caravans.show', $caravan->id) }}" class="btn btn-sm btn-info">Ver</a>
            <a href="{{ route('caravans.edit', $caravan->id) }}" class="btn btn-sm btn-success mx-1">Editar</a>
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
    </tbody>
    <tfoot>
      <tr>
        <td class="notexport">Foto</td>
        <th>Cliente</th>
        <th>Vehículo</th>
        <th>Tipo de Carrozado</th>
        <th>Modelo de Carrozado</th>
        <th class="notexport">Botones</th>
      </tr>
    </tfoot>
  </x-table>
</x-card>
@endsection