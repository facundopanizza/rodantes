<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="/DataTables/datatables.min.css" />
    <link href={{ asset("css/bootstrap.min.css") }} rel="stylesheet" />
    <title>@yield('title')</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}">Caravana Stock</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'employee' || Auth::user()->role === "moderator")
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Caravanas
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('caravans.index') }}">Ver
                                            Caravanas</a>
                                    </li>
                                    @if (Auth::user()->role === 'admin' || Auth::user()->role === "moderator")
                                        <li>
                                            <a class="dropdown-item" href="{{ route('caravans.create') }}">Crear
                                                Caravanas</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'employee' || Auth::user()->role === 'moderator')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Productos
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('products.index') }}">Ver
                                            productos</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('products.pdf') }}">Descargar PDF con Productos</a>
                                    </li>
                                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'moderator')
                                        <li>
                                            <a class="dropdown-item" href="{{ route('products.create') }}">Crear
                                                Producto</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('stock') }}">Productos con poco
                                                Stock</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'moderator')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Empleados
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('employees.index') }}">Ver
                                            Empleados</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('employees.create') }}">Crear
                                            Empleado</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Categorías
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('categories.index') }}">Ver
                                            Categorías</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('categories.create') }}">Crear
                                            Categoría</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Proveedores
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('suppliers.index') }}">Ver
                                            Proveedores</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('suppliers.create') }}">Crear
                                            Proveedor</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if (Auth::user()->role === 'admin' || Auth::user()->role === "moderator")
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Usuarios
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('users.index') }}">Ver Usuarios</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('users.create') }}">Crear Usuario</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if (Auth::user()->role === 'admin' || Auth::user()->role === "moderator")
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Clientes
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('clients.index') }}">Ver
                                            Clientes</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('clients.create') }}">Crear
                                            Clientes</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link">
                                    {{ Auth::user()->name }}
                                </a>
                            </li>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link class="nav-link" :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar sesión') }}
                            </x-dropdown-link>
                        </form>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container my-4">
        @if(Session::has("message"))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get("message") }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('main')
    </div>

    <footer class="mt-auto bg-dark text-white text-center text-lg-start">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            Caravana Motorhomes - Copyright © {{ date('Y') }}
        </div>
    </footer>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
</script>
<script type="text/javascript" src="/jquery.js"></script>
<script type="text/javascript" src="/DataTables/datatables.min.js"></script>
@yield("scripts")

</html>
