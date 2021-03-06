<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function caravans() {
        return $this->hasMany(Client::class);
    }

    public function getFullName() {
        return $this->first_name . " " . $this->last_name;
    }
}
