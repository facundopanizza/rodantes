@extends('layouts.layout')

@section('title', 'Editar Cliente')

@section('main')
<x-card header="Editar Cliente">
  <form method="POST" enctype="multipart/form-data" action="{{ route("clients.update", $client->id) }}">
    @csrf
    @method("patch")

    <div class="mb-3">
      <label for="first_name" class="form-label">Nombre</label>
      <input required name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
        placeholder="Juan" value="{{ old('first_name') ? old('first_name') : $client->first_name }}">
      @error("first_name")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="last_name" class="form-label">Apellido</label>
      <input required name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
        placeholder="Perez" value="{{ old('last_name') ? old('last_name') : $client->last_name }}">
      @error("last_name")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input required name="email" type="email" class="form-control @error('email') is-invalid @enderror"
        placeholder="juan@perez.com" value="{{ old('email') ? old('email') : $client->email }}">
      @error("email")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="dni" class="form-label">DNI</label>
      <input required name="dni" type="text" class="form-control @error('dni') is-invalid @enderror"
        placeholder="41231452" value="{{ old('dni') ? old('dni') : $client->dni }}">
      @error("dni")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="phone" class="form-label">Teléfono</label>
      <input required name="phone" type="number" class="form-control @error('phone') is-invalid @enderror"
        placeholder="41231452" value="{{ old('phone') ? old('phone') : $client->phone }}">
      @error("phone")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="address" class="form-label">Dirección</label>
      <textarea required name="address"
        class="form-control @error('address') is-invalid @enderror">{{ old('address') ? old('address') : $client->address }}</textarea>
      @error("address")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="picture" class="form-label">Foto</label>
      <input name="picture" type="file" class="form-control @error('picture') is-invalid @enderror"
        value="{{ old('picture') ? old('picture') : $client->picture }}">
      @error("picture")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button class="btn btn-success">Editar</button>
  </form>
</x-card>
@endsection