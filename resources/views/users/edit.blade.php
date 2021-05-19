@extends('layouts.layout')

@section('title', 'Editar Usuario')

@section('main')
<x-card header="Editar Usuario">
  <form method="POST" action="{{ route('users.update', $user->id) }}">
    @csrf
    @method("PATCH")

    <div class="mb-3">
      <label for="name" class="form-label">Nombre</label>
      <input required name="name" type="text" class="form-control @error('name') is-invalid @enderror"
        placeholder="Juan Perez" value="{{ old('name') ? old('name') : $user->name }}">
      @error("name")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="role" class="form-label">Rol</label>
      <select id="role" name="role" type="text" class="form-control @error('role') is-invalid @enderror" value="{{ old('role') }}" >
        <option value="admin" {{ $user->role === "admin" ? "selected" : null }}>Admin</option>
        <option value="employee" {{ $user->role === "employee" ? "selected" : null }}>Empleado</option>
        <option value="moderator" {{ $user->role === "moderator" ? "selected" : null }}>Moderador</option>
      </select>
      @error("role")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div id="dni" class="mb-3" style="@if($user->role !== 'employee') display: none @endif">
      <label for="dni" class="form-label">DNI</label>
      <input name="dni" type="number" class="form-control @error('dni') is-invalid @enderror"
        placeholder="12345678" value="{{ old('dni') ? old('dni') : $user->dni }}">
      @error("dni")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div id="email" class="mb-3" style="@if($user->role === 'employee') display: none @endif">
      <label for="email" class="form-label">Email</label>
      <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
        placeholder="juan@perez.com" value="{{ old('email') ? old('email') : $user->email }}">
      @error("email")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div id="password" class="mb-3" style="@if($user->role === 'employee') display: none @endif">
      <label for="password" class="form-label">Contraseña</label>
      <input name="password" type="password" class="form-control @error('password') is-invalid @enderror"
        placeholder="123456" value="{{ old('password')}}">
      @error("password")
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button class="btn btn-success">Editar</button>
  </form>
</x-card>

<script>
  let role = document.querySelector("#role");
  let dni = document.querySelector("#dni");
  let email = document.querySelector("#email");
  let password = document.querySelector("#password");

  role.addEventListener("change", (e) => {
    if (role.value === "employee") {
      dni.style.display = "block";
      email.style.display = "none";
      password.style.display = "none";
    } else {
      dni.style.display = "none";
      email.style.display = "block";
      password.style.display = "block";
    }
  })
</script>
@endsection