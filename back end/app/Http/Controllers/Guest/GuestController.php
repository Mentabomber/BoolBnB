<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\Message;

use GeoIP;


class GuestController extends Controller
{
    // // Restituisce la lista di tutti gli appartamenti presenti nel db
     
   
    

    public function message(Request $request, $id) {
        
        $data = $request -> all();
        $data['apartment_id'] = $id;
        $message = Message :: create($data);
        return redirect() -> route('guest.apartments.show', $id);
    }
}
