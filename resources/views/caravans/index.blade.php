@extends('layouts.layout')

@section('title', 'Caravanas')

@section('main')
<x-card header="Caravanas">
  <x-table>
    <thead>
      <tr>
        <td>#</td>
        <td>Nombre</td>
        <td>Patente</td>
        <td>Cliente</td>
        <td class="notexport"></td>
      </tr>
    </thead>
    <tbody>
      @foreach ($caravans as $caravan)
      <tr>
        <td>{{ $caravan->id }}</td>
        <td>{{ $caravan->name }}</td>
        <td>{{ $caravan->plate }}</td>
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
  </x-table>
</x-card>
@endsection