<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


use App\Models\Apartment;
use App\Models\Service;
use App\Models\Address;

class LoggedController extends Controller
{

    public function show() {

        $apartments = Apartment :: all();


        return view('auth.my-apartments', compact('apartments'));
    }


    public function create() {

        // Richiama tutti i servizi

        $services = Service :: all();
        
        return view('auth.user-crud.create-apartment', compact('services'));
    }
    public function store(Request $request) {

        // Validazione dei dati inviati dall'utente
        
        $apartment = $request -> validate([
            "title" => "required | string | min:3 | max:64",
            "rooms" => "required | integer",
            "beds" => "required | integer",
            "bathrooms" => "required | integer",
            "square_meters" => "required | integer",
            "image" => "required | mimes:jpg,jpeg,png",
            "visible" => "boolean",
            "services" => "required | array",
        ]);

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

        // Salvataggio dell'immagine dell'appartamento nella directory uploads

        $img_path = Storage :: put('uploads', $apartment['image']);
        $apartment['image'] = $img_path;

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
        
        return redirect() -> route('guest.show-apartment', $user_apartment -> id);
    }


    public function edit($id) {

        $apartment = Apartment :: findOrFail($id);

        $address = Address :: findOrFail($apartment->id);
        $services = Service :: all();

        return view('auth.user-crud.edit-apartment', compact('address', 'services', 'apartment'));
    }
    public function update(Request $request, $id) {

        $data = $request -> all();

        $apartment = Apartment :: findOrFail($id);

        if (!array_key_exists('image', $data)) {
            $data['image'] = $apartment -> image;
        } else {

            $oldImgPath = $apartment -> image;

            if ($oldImgPath) {

                Storage :: delete($oldImgPath);
            }

            $img_path = Storage :: put('uploads', $data['image']);
            $data['image'] = $img_path;
        }

        $apartment -> update($data);

        $apartment -> services() -> sync(
            array_key_exists('services', $data)
            ? $data['services']
            : []);


        return redirect() -> route('guest.show-apartment', $apartment -> id);
    }
 
    // public function destroy($id) {



    //     $comic = Comic :: findOrFail($id);

    //     $comic -> delete();

    //     return redirect() -> route("comic.index");
    // }
}