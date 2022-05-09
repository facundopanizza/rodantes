@extends('layouts.layout')

@section('title', 'Editar Precio')

@section('main')
<x-card header="Editar Precio">
  <form method="POST" action="{{ route('prices.update', $price->id) }}">
    @csrf
    @method("patch")

    <div class="mb-3">
      <label for="price" class="form-label">Precio (Decimal separado por un punto, máximo 2 decimales)</label>
      <input required id="price" name="price" type="text" class="form-control @error('price') is-invalid @enderror"
        placeholder="100" value="{{ old('price') ? old('price') : $price->price}}" min="0">
      @error("price")
      <div class="text-danger">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="iva" class="form-label">Iva</label>
      <input required id="iva" name="iva" type="text" class="form-control @error('iva') is-invalid @enderror"
        placeholder="21" value="{{ old('iva') ? old('iva') : $price->iva }}" min="0">
      @error("iva")
      <div class="text-danger">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="pricePlusIva" class="form-label">Precio con Iva</label>
      <input type="text" id="pricePlusIva" class="form-control" value="0">
    </div>

    <div class="mb-3">
        <a id="calculatePriceWithIva" class="btn btn-secondary">Calcular Precio con Iva</a>
        <a id="calculatePrice" class="btn btn-secondary">Calcular Precio</a>
    </div>

    <div class="mb-3">
      <label for="stock" class="form-label">Stock</label>
      <input name="stock" type="number" class="form-control @error('stock') is-invalid @enderror" placeholder="2"
        value="{{old('stock') ? old('stock') : $price->stock}}" min="0">
      @error("stock")
      <div class="text-danger">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="created_at" class="form-label">Fecha de la compra</label>
      <input name="created_at" type="date" class="form-control @error('created_at') is-invalid @enderror"
        value="{{old('created_at') ? old('created_at') : \Carbon\Carbon::parse($price->created_at)->format("Y-m-d")}}">
      @error("created_at")
      <div class="text-danger">{{ $message }}</div>
      @enderror
    </div>

    <button class="btn btn-success">Editar</button>
  </form>
</x-card>
<script>
  let price = document.querySelector("#price");
  let iva = document.querySelector("#iva");
  let pricePlusIva = document.querySelector("#pricePlusIva");
  let buttonCalculatePriceWithIva = document.querySelector("#calculatePriceWithIva");
  let buttonCalculatePrice = document.querySelector("#calculatePrice");

  const calculatePriceWithIva = () => {
    pricePlusIva.value = Number(price.value) + ((Number(price.value) * Number(iva.value) / 100));
  }

  const calculatePrice = () => {
    price.value = Number(pricePlusIva.value) -  ((Number(iva.value) * Number(pricePlusIva.value)) / (100 + Number(iva.value)));
  }

  buttonCalculatePriceWithIva.addEventListener("click", calculatePriceWithIva);
  buttonCalculatePrice.addEventListener("click", calculatePrice);
</script>
@endsection
