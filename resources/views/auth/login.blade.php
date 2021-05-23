<title>Rodantes - Iniciar sesión</title>
<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <a href="{{ route("empleados.login") }}" class="mt-4 block w-full bg-gray-900 text-white py-2 rounded-md text-center">Operadores</a>

        <a href="{{ route("admins.login") }}" class="my-4 block w-full bg-gray-900 text-white py-2 rounded-md text-center">Administradores</a>

    </x-auth-card>
</x-guest-layout>
