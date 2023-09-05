<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;
    protected $fillable = [
        "visit_date",         
        "ip_address", 
        "apartment_id",
];
    public function apartment() {
        return $this -> belongongsTo(Apartment :: class);
}
}
