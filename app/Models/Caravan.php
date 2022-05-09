<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caravan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getTotal() {
        $total = 0;

        foreach ($this->products as $product) {
            $total += $product->getTotal();
        }

        return $total;
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function products() {
        return $this->belongsToMany(Price::class)->withPivot("quantity")->withPivot("quantity")->withPivot("id")->withPivot("employee_id")->withTimestamps();
    }
}
