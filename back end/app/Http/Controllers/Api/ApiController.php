<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\Address;
use App\Models\Message;

class ApiController extends Controller
{
    public function apartmentIndex() {
        $apartments = Apartment :: with('address', 'services')->where('visible', 1)->get();
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

    public function searchApartment(Request $request) {

        $data = $request -> all();

        $latitude = $data['latitude'];
        $longitude = $data['longitude'];

        $apartments = Apartment::select('*')
            ->selectRaw(
                '(6371 * acos(cos(radians(' . $latitude . '))
                * cos(radians(addresses.latitude))
                * cos(radians(addresses.longitude)
                - radians(' . $longitude . '))
                + sin(radians(' . $latitude . '))
                * sin(radians(addresses.latitude)))) AS distance'
            )->join('addresses', 'addresses.apartment_id', '=', 'apartments.id')
            ->where('visible', 1)
            ->having('distance', '<=', 20)
            ->orderBy('distance', 'asc')
            ->get();
    
        return response()->json(['apartments' => $apartments]);

    }


    public function filteredApartment(Request $request) {


        $data = $request -> all();

        $latitude = $data['latitude'];
        $longitude = $data['longitude'];
        $radius = $data['kmFilter'];
        $selectedServices = $data['servicesFilter'];
        $filteredApartment = [];
        // $selectedServices = [10];

        // $apartments = Apartment::with('address','services');

        $apartments = Apartment::select('*')
            ->selectRaw(
                '(6371 * acos(cos(radians(' . $latitude . '))
                * cos(radians(addresses.latitude))
                * cos(radians(addresses.longitude)
                - radians(' . $longitude . '))
                + sin(radians(' . $latitude . '))
                * sin(radians(addresses.latitude)))) AS distance'
            )
            ->with('services')
            ->join('addresses', 'addresses.apartment_id', '=', 'apartments.id')
            ->where('visible', 1)
            ->having('distance', '<=', $radius)
            ->orderBy('distance', 'asc');

        $apartments = $apartments->where('rooms', '>=', $data['roomsFilter']);

        $apartments = $apartments->where('beds', '>=', $data['bedsFilter']);
        if ($selectedServices) {
            # code...
        }
        if(count($selectedServices) != 0) {
            // $apartments = Apartment::whereHas('services', function ($query) use ($selectedServices) {
            //     $query->whereIn('id', $selectedServices);})->get();
            $apartments = $apartments->whereHas('services', function ($query) use ($selectedServices) {
                  $query->whereIn('service_id', $selectedServices);}, '=', count($selectedServices))->get();
        }else{
            $apartments = $apartments->get();
        }
        
        
        
            // $test = false;
        // $prova2 = false;
        // $count = 0;
        // $count2 = 0;
        // $sel = [];
        // $serv = [];
        // $contains = false;
        // $length = count($selectedServices);
        // $function = 0;
        // if($length > 0) {
        //     $test = true;

        //     foreach ($apartments as $apartment) {
        //         $count = $count + 1;
        //         foreach ($apartment['services'] as $service) {
        //             $count2 = $count2 +1;
        //             $selectedServices = [1, 2, 3];
        //             $sel = [1, 2];
        //             array_push($serv,$service['id']);
                    
                    
                    
        //             $function = array_diff($selectedServices, );
                    
        //             // if(in_array($service['id'], $apartment['services']['id'])) {

        //             //     if(!in_array($apartment,$filteredApartment)) {
    
        //             //         array_push($filteredApartment, $apartment); 
        //             //     }
        //             // }
        //         }
        //         $serv = [];
        //     }
        // }

        // if(count($filteredApartment) == 0) {
        //     $filteredApartment = $apartments;
        // }
        // $tipoarray = gettype($selectedServices);
        // Filtra per utilities selezionate
        // $apartments = $apartments->where('services.id','=', '1')->get();



        
        // if($data['servicesFilter'] == "") {
        //     $selectedServices = 0;
        // }else {
        // }
        
    //     if($data['bedsFilter'] == "") {
    //         $beds = 0;

    //     } else {
    //         $beds = $data['bedsFilter'];
    //     }

    //     if($data['roomsFilter'] == "") {
    //         $rooms = 0;

    //     } else {
    //         $rooms = $data['roomsFilter'];
    //     }

    //     if($data['kmFilter'] == 20) {
    //            $radius = 20; // in chilometri
    //     } else {
    //         $radius = $data['kmFilter'];
    //    }

    //     $apartments = Apartment::select('*')
    //         ->selectRaw(
    //             '(6371 * acos(cos(radians(' . $latitude . '))
    //             * cos(radians(addresses.latitude))
    //             * cos(radians(addresses.longitude)
    //             - radians(' . $longitude . '))
    //             + sin(radians(' . $latitude . '))
    //             * sin(radians(addresses.latitude)))) AS distance'
    //         )
    //         ->with('services')
    //         ->join('apartment_service', 'apartments.id', '=', 'apartment_service.apartment_id')
    //         ->join('addresses', 'addresses.apartment_id', '=', 'apartments.id')
    //         ->having('distance', '<=', $radius)
    //         ->having('beds', '>=', $beds)
    //         ->having('rooms', '>=', $rooms)
    //         ->where('apartment_service.service_id', $selectedServices)
    //         ->orderBy('distance', 'asc')
    //         ->get();
    // , 'test' => $test, 'prova2' => $prova2, 'leng' => $length, 'count' => $count, 'count2' => $count2, 'sel' => $sel, 'serv' => $serv, 'contains' => $contains, 'filteredApartment' => $filteredApartment, 'selectedService' => $selectedServices, 'function' => $function
        return response()->json(['latitude' => $latitude, 'longitude' => $longitude, 'apartments' => $apartments, 'selectedServices' => $selectedServices]);
    }

    public function serviceList() {

        $services = Service::all();

        return response()-> json(['services' => $services]);
    }

}
