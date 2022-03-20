<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    function getStock() {
        $stock = 0;

        foreach($this->prices as $price) {
            $stock += $price->stock;
        }

        return $stock;
    }

    function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    function category() {
        return $this->belongsTo(Category::class);
    }

    function prices() {
        return $this->hasMany(Price::class);
    }

    function assignCaravan($caravan, $quantity) {
        $totalStock = $this->getStock();

        if ($quantity > $totalStock) {
            return false;
        }

        foreach($this->prices->sortBy("created_at") as $price) {
            if($quantity === 0) {
                break;
            }

            $toAdd = 0;
            if($quantity > $price->stock) {
                $toAdd = $price->stock;
            } else {
                $toAdd = $quantity;
            }

            $quantity -= $toAdd;
            $price->stock -= $toAdd;
            $price->save();
            $priceAlreadyAdded = $caravan->products->where("id", $price->id)->first();

            if($priceAlreadyAdded) {
                $priceAlreadyAdded->pivot->quantity += $toAdd;
                $priceAlreadyAdded->pivot->save();
            } else {
                $caravan->products()->attach($price, [ "quantity" => $toAdd ]);
            }
        }

        return true;
    }
}
