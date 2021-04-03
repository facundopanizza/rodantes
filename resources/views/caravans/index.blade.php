@extends('layouts.layout')

@section('title', 'Caravanas')

@section('main')
<x-card header="Caravanas">
  <x-table>
    <thead>
      <tr>
        <td>#</td>
        <td>Tipo de Carrozado</td>
        <td>Modelo de Carrozado</td>
        <td>Cliente</td>
        <td class="notexport"></td>
      </tr>
    </thead>
    <tbody>
      @foreach ($caravans as $caravan)
      <tr>
        <td>{{ $caravan->id }}</td>
        <td>{{ $caravan->type }}</td>
        <td>{{ $caravan->model }}</td>
        <td>{{ $caravan->client ? $caravan->client->getFullName() : "" }}</td>
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
        <th>#</th>
        <th>Tipo de Carrozado</th>
        <th>Modelo de Carrozado</th>
        <th>Cliente</th>
        <th class="notexport">Botones</th>
      </tr>
    </tfoot>
  </x-table>
</x-card>
@endsection