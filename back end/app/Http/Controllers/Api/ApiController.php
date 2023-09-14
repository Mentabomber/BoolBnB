<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\Address;

class ApiController extends Controller
{
    public function apartmentIndex() {
        $apartments = Apartment :: with('address', 'services')->get();
        return response()->json([
            'apartments' => $apartments,
        ]);
    }

    public function receiveMessage() {
        // axios.get... 
        // then
        // $message = Message :: create($...);
    }

    public function showApartment($id) {
        $apartment = Apartment::where('id', $id)->with(["services", "address"])->get();
        
        return response()->json(['apartment' => $apartment]);
    }

    public function userEmail() {
        //se utente è loggato
        if (auth()->check()) {
            $user = auth()->user();
            $email = $user->email;
            
            return response()->json(['email' => $email]);
        } else {
            return response()->json(['email' => '']);
        }
    }
}
