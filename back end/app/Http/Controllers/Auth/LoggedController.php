<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;


use App\Models\Apartment;
use App\Models\Service;
use App\Models\Address;

class LoggedController extends Controller
{

    public function index() {

        $apartments = Apartment :: all();


        return view('auth.apartments.show', compact('apartments'));
    }


    public function create() {

        // Richiama tutti i servizi

        $services = Service :: all();

        return view('auth.apartments.create', compact('services'));
    }
    public function store(Request $request) {

        // Validazione dei dati inviati dall'utente

        $apartment = $request -> validate([
            "title" => "required | string | min:3 | max:64",
            "rooms" => "required | integer",
            "beds" => "required | integer",
            "bathrooms" => "required | integer",
            "square_meters" => "required | integer",
            "image" => "required | image | mimes:jpg,jpeg,png,svg",
            "visible" => "boolean",
            "services" => "required | array",
        ]);
        // Salvataggio immagini nel db

        $fileName = time() . '.' . $request-> image -> extension();
        $request -> image -> storeAs('uploads', $fileName);

        $apartment['image'] = $fileName;

        // Validazione dei dati inviati dall'utente

        $address = $request -> validate([
            "latitude" => "decimal",
            "longitude" => "decimal",
            "street" => "required | string",
            "street_number" => "required | integer",
            "cap" => "required | integer",
            "city" => "required | string",
            "province" => "required | string",
            "floor" => "required | integer",
        ]);
        $street = str_replace(' ', '%20', $address['street']);
        // $url = "https://api.tomtom.com/search/2/structuredGeocode.json?countryCode=IT&streetNumber=" . $address['street_number'] . "&streetName=" . $street . "&municipality=" . $address['city'] . "&countrySecondarySubdivision=Italia&postalCode=" . $address['cap'] . "&view=Unified&key=tjBiGEAUGDCzaAZB0pAlxSemjpDfgVP1";

        // $url = "https://api.tomtom.com/search/2/geocode/" . $address['street'] . " " .  $address['street_number'] . ", " . $address['cap'] . "AG, " . $address['city'] . ".json?key=tjBiGEAUGDCzaAZB0pAlxSemjpDfgVP1";

        $url = 'https://api.tomtom.com/search/2/geocode/json?q=' . $street . "%20%20" . $address['city'] . '%20%20Italia&key=tjBiGEAUGDCzaAZB0pAlxSemjpDfgVP1';


        $response = curl_init($url);
        dd($response);
        curl_setopt($response, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($response);
        curl_close($response);
        $data = json_decode($result, true);
       

        // Decodifica la risposta
        $data = json_decode($result, true);

        // Stampa le coordinate
        echo $data['results'][0]['position']['latitude'] . ', ' . $data['results'][0]['position']['longitude'];
        // $data = $response -> json();

        dd($data);
        // Assegnazione dell'ID dell'utente al record dell'appartamento

        $userId = auth()->user()->id;
        $apartment['user_id'] = $userId;

        // Creazione del record dell'appartamento nel database

        $user_apartment = Apartment :: create($apartment);

        // Creazione delle relazioni tra l'appartamento e i servizi

        $user_apartment -> services() -> attach($apartment['services']);

        // Creazione del record dell'indirizzo

        $address['apartment_id'] = $user_apartment['id'];
        $address = Address :: create($address);

        // return redirect() -> route('guest.apartments.show', $user_apartment -> id);
    }

    public function show($id) {

        $apartment = Apartment :: findOrFail($id);

        // $address = Address :: findOrFail($apartment->id);
        $address = Address ::where('apartment_id', $apartment->id)->firstOrFail();

        return view('guest.apartments.show', compact('apartment', 'address'));
    }

    public function edit($id) {

        $apartment = Apartment :: findOrFail($id);
        $userId = auth()->user()->id;
        if($apartment->user_id == $userId){
            $address = Address ::where('apartment_id', $apartment->id)->firstOrFail();
            $services = Service :: all();

            return view('auth.apartments.edit', compact('address', 'services', 'apartment'));
        }
        else{
            return redirect() -> route('welcome');
        }




    }
    public function update(Request $request, $id) {

        $data = $request -> all();

        $apartment = Apartment :: findOrFail($id);
        $address = Address ::where('apartment_id', $apartment->id)->firstOrFail();

        if (!array_key_exists('image', $data)) {
            $data['image'] = $apartment -> image;
        } else {

            $oldImgPath = $apartment -> image;

            if ($oldImgPath) {

                Storage :: delete($oldImgPath);
            }

            $fileName = time() . '.' . $request-> image -> extension();
            $request -> image -> storeAs('uploads', $fileName);
    
            $data['image'] = $fileName;
        }

        $apartment -> update($data);

        $apartment -> services() -> sync(
            array_key_exists('services', $data)
            ? $data['services']
            : []);

        $address -> update($data);


        return redirect() -> route('guest.apartments.show', $apartment -> id);
    }

    public function delete($id)
    {
        $apartment = Apartment::findOrFail($id);
        foreach($apartment->messages as $message){
            $message->delete();
        }
        foreach($apartment->visits as $visit){
            $visit->delete();
        }
        
        $apartment->sponsorships()->detach(); // Rimuovi tutte le sponsorizzazioni associate all'appartamento
        $apartment->services()->detach(); // Rimuovi tutti i servizi associati all'appartamento
        $apartment->address()->delete(); // Elimina l'indirizzo associato all'appartamento

        $oldImgPath = $apartment -> image;
        Storage::delete($oldImgPath);
  

        $apartment->delete(); // Elimina l'appartamento stesso

        return redirect() -> route('auth.apartments.show');
    }

}
