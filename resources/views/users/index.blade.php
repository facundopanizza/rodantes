@extends('layouts.layout')

@section('title', 'Usuarios')

@section('main')
<x-card header="Usuarios">
  <x-table>
    <thead>
      <tr>
        <td class="notexport"></td>
        <td>Nombre</td>
        <td>Email</td>
        <td>DNI</td>
        <td>Rol</td>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
      <tr>
        <td class="notexport">
          <div class="d-flex ">
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-success mx-1">Editar</a>
            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
              data-bs-target="#confirmDelete{{ $user->id }}">Borrar</button>
          </div>
          <x-modal-action :key="$user->id" message="Esta seguro que desea borrar este usuario?">
            <form method="POST" action="{{ route('users.destroy', $user->id) }}">
              @csrf
              @method("delete")
              <button type="submit" class="btn btn-outline-danger">Si, borrar</button>
            </form>
          </x-modal-action>
        </td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->dni }}</td>
        @if($user->role === "employee")
          <td>Operador</td>
        @elseif($user->role === "admin")
          <td>Admin</td>
        @elseif($user->role === "moderator")
          <td>Moderador</td>
        @else
          <td>{{ $user->role }}</td>
        @endif
      </tr>
      @endforeach
    </tbody>
  </x-table>
</x-card>
@endsection