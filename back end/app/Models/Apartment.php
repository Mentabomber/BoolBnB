<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",          
        "rooms",      
        "beds",       
        "bathrooms",
        "square_meters",
        "image",
        "visible",
        "user_id",
        
        ];
public function user() {
        return $this -> belongsTo(User :: class);
}
public function address() {
        return $this -> hasOne(Address :: class);
}
public function messages() {
        return $this -> hasMany(Message :: class);
}
public function visits() {
        return $this -> hasMany(Visit :: class);
}
public function services() {
        return $this -> belongsToMany(Service :: class);
}
public function sponsorships() {
        return $this -> belongsToMany(Sponsorship :: class);
}
}
