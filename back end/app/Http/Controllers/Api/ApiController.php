<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\Address;
use App\Models\Message;

class ApiController extends Controller
{
    public function apartmentIndex() {
        $apartments = Apartment :: with('address', 'services')->get();
        return response()->json([
            'apartments' => $apartments,
        ]);
    }

    public function receiveMessage(Request $request) {

        $data = [

            'message' => $request['message'],
            'name' => $request['name'],
            'surname' => $request['surname'],
            'email' => $request['email'],
            'apartment_id' => $request['apartment_id'],
        ];

        Message :: create($data);
    }

    public function showApartment($id) {
        $apartment = Apartment::where('id', $id)->with(["services", "address"])->get();
        
        return response()->json(['apartment' => $apartment]);
    }

}
