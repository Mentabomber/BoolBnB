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
        $data['user_id'] = $userId;

        $apartment = Apartment :: create($data);
        $apartment -> services() -> attach($data['services']);
        $apartment -> addresses() -> attach($data['addresses']);
        var_dump($data);
        // return redirect() -> route('apartment.show', $apartment -> id);
    }


    // public function edit($id) {

    //     $types = Type :: all();
    //     $technologies = Technology :: all();

    //     $project = Project :: findOrFail($id);

    //     return view('edit', compact('types', 'technologies', 'project'));
    // }
    // public function update(Request $request, $id) {

    //     $data = $request -> all();

    //     $project = Project :: findOrFail($id);

    //     if (!array_key_exists('picture', $data)) {
    //         $data['picture'] = $project -> picture;
    //     } else {

    //         $oldImgPath = $project -> picture;

    //         if ($oldImgPath) {

    //             Storage :: delete($oldImgPath);
    //         }

    //         $img_path = Storage :: put('uploads', $data['picture']);
    //         $data['picture'] = $img_path;
    //     }

    //     $project -> update($data);

    //     $project -> technologies() -> sync(
    //         array_key_exists('technologies', $data)
    //         ? $data['technologies']
    //         : []);


    //     return redirect() -> route('project.show', $project -> id);
    // }
}
