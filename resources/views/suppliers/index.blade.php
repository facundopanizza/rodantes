@extends('layouts.layout')

@section('title', 'Proveedores')

@section('main')
<x-card header="Proveedores">
  <x-table>
    <thead>
      <tr>
        <td class="notexport"></td>
        <td>Nombre</td>
        <td>Teléfono</td>
        <td>Dirección</td>
      </tr>
    </thead>
    <tbody>
      @foreach ($suppliers as $supplier)
      <tr>
        <td class="notexport">
          <div class="d-flex">
            @if(Auth::user()->role === "admin" || Auth::user()->role === "moderator")
              <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-success mx-1">Editar</a>
              <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                data-bs-target="#confirmDelete{{ $supplier->id }}">Borrar</button>
            @endif
          </div>
          <x-modal-action :key="$supplier->id" message="Esta seguro que desea borrar este proveedor?">
            <form method="POST" action="{{ route('suppliers.destroy', $supplier->id) }}">
              @csrf
              @method("delete")
              <button type="submit" class="btn btn-outline-danger">Si, borrar</button>
            </form>
          </x-modal-action>
        </td>
        <td>{{ $supplier->name }}</td>
        <td>{{ $supplier->phone }}</td>
        <td>{{ $supplier->address }}</td>
      </tr>
      @endforeach
    </tbody>
  </x-table>
</x-card>
@endsection