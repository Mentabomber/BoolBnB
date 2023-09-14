<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\Address;

class ApiController extends Controller
{
    public function apartmentIndex() {
        $apartments = Apartment :: with('address', 'services')->get();
        return response()->json([
            'apartments' => $apartments
        ]);
    }

    public function receiveMessage() {
        // axios.get... 
        // then
        // $message = Message :: create($...);
    }

    public function showApartment($id) {
        
        $apartment = Apartment :: where('id', $id)->with(["services","address"])->get();
        // if (empty($apartment)){
        //     return response()->json(["message"=>"Nessun appartamento trovato con questo nome"]);
        // }
        return response()->json([
            'apartment' => $apartment
        ]);
       
    }
}
