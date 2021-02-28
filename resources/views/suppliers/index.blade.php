@extends('layouts.layout')

@section('title', 'Proveedores')

@section('main')
<x-card header="Proveedores">
  <x-table>
    <thead>
      <tr>
        <td>#</td>
        <td>Nombre</td>
        <td class="notexport"></td>
      </tr>
    </thead>
    <tbody>
      @foreach ($suppliers as $supplier)
      <tr>
        <td>{{ $supplier->id }}</td>
        <td>{{ $supplier->name }}</td>
        <td class="notexport">
          <div class="d-flex flex-nowrap justify-content-between">
            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-success mx-1">Editar</a>
            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
              data-bs-target="#confirmDelete{{ $supplier->id }}">Borrar</button>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </x-table>
</x-card>
@endsection