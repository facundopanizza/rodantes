@extends('layouts.layout')

@section('title', 'Crear Usuario')

@section('main')
<x-card header="Crear Usuario">
  <form method="POST" action="{{ route('users.store') }}">
    @csrf

    <div class="mb-3">
      <label for="name" class="form-label">Nombre</label>
      <input required name="name" type="text" class="form-control @error('name') is-invalid @enderror"
        placeholder="Juan Perez" value="{{ old('name')}}">
      @error("name")
      <div class="text-danger">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="role" class="form-label">Rol</label>
      <select required id="role" name="role" type="text" class="form-control @error('role') is-invalid @enderror" value="{{ old('role') }}">
        <option value="">Selecciona un rol</option>
        <option value="employee" {{ old("role") === "employee" ? "selected" : "" }}>Operador</option>
        <option value="admin" {{ old("role") === "admin" ? "selected" : "" }}>Admin</option>
        <option value="moderator" {{ old("role") === "moderator" ? "selected" : "" }}>Moderador</option>
      </select>
      @error("role")
      <div class="text-danger">{{ $message }}</div>
      @enderror
    </div>

    <div id="dni" class="mb-3" style="display: {{ old('dni') ? "block" : "none" }}">
      <label for="dni" class="form-label">DNI</label>
      <input name="dni" type="number" class="form-control @error('dni') is-invalid @enderror"
        placeholder="12345678" value="{{ old('dni')}}">
      @error("dni")
      <div class="text-danger">{{ $message }}</div>
      @enderror
    </div>

    <div id="email" class="mb-3" style="display: {{ old('email') ? "block" : "none" }}">
      <label for="email" class="form-label">Email</label>
      <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
        placeholder="juan@perez.com" value="{{ old('email')}}">
      @error("email")
      <div class="text-danger">{{ $message }}</div>
      @enderror
    </div>

    <div id="password" class="mb-3" style="display: {{ old('email') ? "block" : "none" }}">
      <label for="password" class="form-label">Contraseña</label>
      <input name="password" type="password" class="form-control @error('password') is-invalid @enderror"
        placeholder="123456" value="{{ old('password')}}">
      @error("password")
      <div class="text-danger">{{ $message }}</div>
      @enderror
    </div>

    <button class="btn btn-success">Crear</button>
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
