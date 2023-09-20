<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\Address;
use App\Models\Message;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function apartmentIndex() {
        $apartments = Apartment :: with('address', 'services')->where('visible', 1)->get();
        return response()->json([
            'apartments' => $apartments,
        ]);
    }

    public function receiveMessage(Request $request) {
            $request['send_date'] = $today = Carbon::now();
        $data = [

            'message' => $request['message'],
            'name' => $request['name'],
            'surname' => $request['surname'],
            'email' => $request['email'],
            'send_date' => $request['send_date'],
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
            ->orderBy('distance', 'asc');
            
            $apartments = $apartments->with('services')->get();
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
        
        
        return response()->json(['latitude' => $latitude, 'longitude' => $longitude, 'apartments' => $apartments, 'selectedServices' => $selectedServices]);
    }

    public function serviceList() {

        $services = Service::all();

        return response()-> json(['services' => $services]);
    }

}
