<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    function prices() {
        return $this->hasMany(Price::class);
    }
}
