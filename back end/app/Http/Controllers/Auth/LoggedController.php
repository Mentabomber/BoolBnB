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

        $services = Service :: all();
        $addresses = Address :: all();
        
        return view('auth.user-crud.create-apartment', compact('services','addresses'));
    }
    public function store(Request $request) {
        
        $data = $request -> validate([
            "title" => "required|string",
            "rooms" => "required|integer",
            "beds" => "required|integer",
            "bathrooms" => "required|integer",
            "square_meters" => "required|integer",
            "image" => "required|file|image|mimes:jpg,jpeg,png",
            "visible" => "boolean",
            "user_id" => "required|integer",
            "services" => "nullable|array",
        ]);

        $img_path = Storage :: put('uploads', $data['image']);
        
        $data['image'] = $img_path;

        $data['visible'] = false;

        $userId = auth()->user()->id;
        $data['user_id'] = $userId;

        $apartment = Apartment :: create($data);

        
        $address = Address :: create($data);

        $apartment -> services() -> attach($data['service_id']);
        $apartment -> addresses() -> attach($data['addresses']);
    
        return redirect() -> route('apartment.show', $apartment -> id);
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
