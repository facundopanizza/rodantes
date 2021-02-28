<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $guarded = [];

    function getTotal() {
        return $this->price * $this->pivot->quantity;
    }

    function product() {
        return $this->belongsTo(Product::class);
    }

    function caravans() {
        return $this->belongsToMany(Caravan::class)->withPivot("quantity")->withPivot("id")->withTimestamps();
    }
}
