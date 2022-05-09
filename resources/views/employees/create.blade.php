@extends('layouts.layout')

@section('title', 'Crear Empleado')

@section('main')
<x-card header="Crear Empleado">
  <form method="POST" action="{{ route('employees.store') }}">
    @csrf
    <div class="mb-3">
      <label for="name" class="form-label">Nombre</label>
      <input required name="name" type="text" class="form-control @error('name') is-invalid @enderror"
        placeholder="Juan Perez" value="{{ old('name')}}">
      @error("name")
      <div class="text-danger">{{ $message }}</div>
      @enderror
    </div>
    <button class="btn btn-success">Crear</button>
  </form>
</x-card>
@endsection
