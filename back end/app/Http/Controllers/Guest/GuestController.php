<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Apartment;
use App\Models\Address;


class GuestController extends Controller
{
    public function index(){

        $apartments = Apartment:: all();

        return view("guest.index", compact('apartments'));
    }
    public function show($id) {

        $apartment = Apartment :: findOrFail($id);

        $address = Address :: findOrFail($apartment->id);

        return view('guest.show-apartment', compact('apartment', 'address'));
    }
}
