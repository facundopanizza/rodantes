@extends('layouts.layout')

@section('title', 'Clientes')

@section('main')
<x-card header="Clientes">
  <x-table>
    <thead>
      <tr>
        <td>#</td>
        <td>Foto</td>
        <td>Nombre</td>
        <td>Apellido</td>
        <td>Email</td>
        <td>DNI</td>
        <td>Dirección</td>
        <td></td>
      </tr>
    </thead>
    <tbody>
      @foreach ($clients as $client)
      <tr>
        <td>{{ $client->id }}</td>
        <td>
          <a href="{{ asset($client->picture) }}" target="_blank">
            <img width="50" height="50" style="border-radius: 50%; object-fit: cover"
              src="{{ asset($client->picture) }}" alt="{{ $client->first_name . ' ' . $client->last_name }}">
          </a>
        </td>
        <td>{{ $client->first_name }}</td>
        <td>{{ $client->last_name }}</td>
        <td>{{ $client->email }}</td>
        <td>{{ $client->dni }}</td>
        <td>{{ $client->address }}</td>
        <td>
          <div class="d-flex flex-nowrap justify-content-between">
            <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-sm btn-success mx-1">Editar</a>
            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
              data-bs-target="#confirmDelete{{ $client->id }}">Borrar</button>
          </div>
        </td>
      </tr>
      <x-modal-action :key="$client->id" message="Esta seguro que desea borrar este cliente?">
        <form method="POST" action="{{ route('clients.destroy', $client->id) }}">
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