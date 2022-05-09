@extends('layouts.layout')

@section('title', 'Editar Empleado')

@section('main')
<x-card header="Editar Empleado">
  <form method="POST" action="{{ route('employees.update', $employee->id) }}">
    @csrf
    @method("patch")
    <div class="mb-3">
      <label for="name" class="form-label">Nombre</label>
      <input required name="name" type="text" class="form-control @error('name') is-invalid @enderror"
        placeholder="Juan Perez" value="{{ old('name') ? old('name') : $employee->name }}">
      @error("name")
      <div class="text-danger">{{ $message }}</div>
      @enderror
    </div>
    <button class="btn btn-success">Editar</button>
    </div>
  </form>
</x-card>
@endsection
