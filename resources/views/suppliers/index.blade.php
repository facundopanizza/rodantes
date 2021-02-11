@extends('layouts.layout')

@section('title', 'Proveedores')

@section('main')
<x-card header="Proveedores">
  <x-table>
    <thead>
      <tr>
        <td>#</td>
        <td>Nombre</td>
        <td></td>
      </tr>
    </thead>
    <tbody>
      @foreach ($suppliers as $supplier)
      <tr>
        <td>{{ $supplier->id }}</td>
        <td>{{ $supplier->name }}</td>
        <td>
          <div class="d-flex flex-nowrap justify-content-between">
            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-success mx-1">Editar</a>
            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
              data-bs-target="#confirmDelete{{ $supplier->id }}">Borrar</button>
          </div>
        </td>
        <x-modal-action :key="$supplier->id" message="Esta seguro que desea borrar este proveedor?">
          <form method="POST" action="{{ route('suppliers.destroy', $supplier->id) }}">
            @csrf
            @method("delete")
            <button type="submit" class="btn btn-outline-danger">Si, borrar</button>
          </form>
        </x-modal-action>
      </tr>
      @endforeach
  </x-table>
</x-card>
@endsection