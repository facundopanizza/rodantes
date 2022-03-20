@extends('layouts.layout')

@section('title', 'Editar Categoría')

@section('main')
<x-card header="Editar Categoría">
  <form method="POST" action="{{ route('categories.update', $category->id) }}">
    @csrf
    @method("patch")
    <div class="mb-3">
      <label for="name" class="form-label">Nombre</label>
      <input required name="name" type="text" class="form-control @error('name') is-invalid @enderror"
        placeholder="Categoría" value="{{ old('name') ? old('name') : $category->name }}">
      @error("name")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <button class="btn btn-success">Editar</button>
    </div>
  </form>
</x-card>
@endsection