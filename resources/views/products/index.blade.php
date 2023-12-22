@extends('layouts.layout')

@section('title', 'Productos')

@section('main')
    <x-card header="Productos">
        @error('constrained')
            <div class="mb-3">
                <h2 class="text-danger">{{ $message }}</h2>
            </div>
        @enderror

        <x-products-table>
            <thead>
                <tr>
                    <td class="notexport"></td>
                    <td>Código</td>
                    <td>Nombre</td>
                    <td>Descripción</td>
                    <td>Proveedor</td>
                    <td>Stock</td>
                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'moderator')
                        <td>Precios</td>
                    @endif
                </tr>
            </thead>
            <tbody></tbody>
        </x-products-table>
    </x-card>
@endsection
