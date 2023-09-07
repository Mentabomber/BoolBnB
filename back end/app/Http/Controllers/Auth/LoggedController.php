<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\Address;

class LoggedController extends Controller
{

    public function index() {

        // Richiama tutti gli appartamenti

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

        // Creazione dell'URL per la chiamata all'API di tomtom

        $street = str_replace(' ', '%20', $address['street']);
        $url = "https://api.tomtom.com/search/2/structuredGeocode.json?countryCode=IT&streetNumber=" . $address['street_number'] . "&streetName=" . $street . "&municipality=" . $address['city'] . "&countrySecondarySubdivision=Italia&postalCode=" . $address['cap'] . "&view=Unified&key=tjBiGEAUGDCzaAZB0pAlxSemjpDfgVP1";

        // Non richiede la verifica del certificato SSL quando viene effetuata la chiamata all'API

        $client = new Client([
            RequestOptions::VERIFY => false,
        ]);

        // Salva la risposta dell'API di tomtom e ne decodifica il body

        $response = $client->get($url);

        $body = $response->getBody()->getContents();
        $data = json_decode($body, true);
        $data = json_decode($response->getBody(), true);

        // Acquistice i valori di latitudie e longitudine da tomtom e li attribuisce ai campi dell'indirizzo utente

        $latitude = $data['results'][0]['position']['lat'];
        $longitude = $data['results'][0]['position']['lon'];

        $address['latitude'] = $latitude;
        
        $address['longitude'] = $longitude;


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

        return redirect() -> route('guest.apartments.show', $user_apartment -> id);
    }

    // Mostra i dettagli di un appartamento
    public function show($id) {

        $apartment = Apartment :: findOrFail($id);

        $address = Address ::where('apartment_id', $apartment->id)->firstOrFail();

        return view('guest.apartments.show', compact('apartment', 'address'));
    }

    // Permette di accedere alla modifica dell'appartamento
    public function edit($id) {

        $apartment = Apartment :: findOrFail($id);
        $userId = auth()->user()->id;

        // Controlla che l'utente che prova ad effettuare l'accesso sia il proprietario dell'appartamento

        if($apartment->user_id == $userId){
            $address = Address ::where('apartment_id', $apartment->id)->firstOrFail();
            $services = Service :: all();

            return view('auth.apartments.edit', compact('address', 'services', 'apartment'));
        }
        else{
            return redirect() -> route('welcome');
        }

    }

    // Permette l'aggiornamento dei dati di un appartamento
    public function update(Request $request, $id) {

        $data = $request -> all();

        $apartment = Apartment :: findOrFail($id);
        $address = Address ::where('apartment_id', $apartment->id)->firstOrFail();

        // Controlla se è gia presente un immagine nel db e in caso affermativo elimina la vecchia immagine

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

        //  Aggiorna i dati dell'appartamento

        $apartment -> update($data);

        // Se la chiave "services" esiste sincronizza i servizi dell'appartamento con i servizi nell'array altrimenti li sincronizza con un array vuoto

        $apartment -> services() -> sync(
            array_key_exists('services', $data)
            ? $data['services']
            : []);

        //  Aggiorna i dati dell'indirizzo

        $address -> update($data);

        return redirect() -> route('guest.apartments.show', $apartment -> id);
    }

    // Permette la rimozione di un appartamento
    public function delete($id)
    {

        $apartment = Apartment::findOrFail($id);

        // Elimina tutti i messagi riferiti all'appartamento

        foreach($apartment->messages as $message){
            $message->delete();
        }

        // Elimina tutte le visite riferite all'appartamento

        foreach($apartment->visits as $visit){
            $visit->delete();
        }

        // Rimuovi tutte le sponsorizzazioni associate all'appartamento

        $apartment->sponsorships()->detach();

        // Rimuovi tutti i servizi associati all'appartamento

        $apartment->services()->detach();

        // Elimina l'indirizzo associato all'appartamento

        $apartment->address()->delete();

        // Elimina l'immagine dell'appartamento

        $oldImgPath = $apartment -> image;
        Storage::delete($oldImgPath); 

        // Elimina l'appartamento

        $apartment->delete(); 

        return redirect() -> route('auth.apartments.show');
    }

}
