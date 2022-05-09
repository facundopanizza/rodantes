@extends('layouts.layout')

@section('title', 'Empleados')

@section('main')
<x-card header="Empleados">
  <x-table>
    <thead>
      <tr>
        <td class="notexport"></td>
        <td>Nombre</td>
      </tr>
    </thead>
    <tbody>
      @foreach ($employees as $employee)
      <tr>
        <td class="notexport">
          <div class="d-flex">
            @if(Auth::user()->role === "admin" || Auth::user()->role === "moderator")
              <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-success mx-1">Editar</a>
              <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                data-bs-target="#confirmDelete{{ $employee->id }}">Borrar</button>
            @endif
          </div>
          <x-modal-action :key="$employee->id" message="Esta seguro que desea borrar este empleado?">
            <form method="POST" action="{{ route('employees.destroy', $employee->id) }}">
              @csrf
              @method("delete")
              <button type="submit" class="btn btn-outline-danger">Si, borrar</button>
            </form>
          </x-modal-action>
        </td>
        <td>{{ $employee->name }}</td>
      </tr>
      @endforeach
    </tbody>
  </x-table>
</x-card>
@endsection
