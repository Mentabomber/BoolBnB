<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        "latitude",           
        "longitude",      
        "address",
        "floor",
        "apartment_id",
];
public function apartment() {
    return $this -> belongsTo(Apartment :: class);
}
}
