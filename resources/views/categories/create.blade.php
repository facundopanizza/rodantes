@extends('layouts.layout')

@section('title', 'Crear Categoría')

@section('main')
<x-card header="Crear Categoría">
  <form method="POST" action="{{ route('categories.store') }}">
    @csrf
    <div class="mb-3">
      <label for="name" class="form-label">Nombre</label>
      <input required name="name" type="text" class="form-control @error('name') is-invalid @enderror"
        placeholder="Categoría" value="{{ old('name')}}">
      @error("name")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <button class="btn btn-success">Crear</button>
  </form>
</x-card>
@endsection