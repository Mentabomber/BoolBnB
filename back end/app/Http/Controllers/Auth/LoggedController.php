<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\Address;
use App\Models\Message;
use App\Models\User;
use App\Models\Sponsorship;
use App\Models\Visit;


class LoggedController extends Controller
{

    public function index() {

        // Richiama tutti gli appartamenti

        $apartments = Apartment :: all();
        $sponsorships = Sponsorship :: all();

        $today = Carbon::now()->toDateString();

        $apartmentsWithValidSponsorship = DB::table('apartment_sponsorship')
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->pluck('apartment_id')
                ->toArray();
        
        $endDate = DB::table('apartment_sponsorship')
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->select(['apartment_id', 'end_date'])
                ->get();

                

        return view('auth.apartments.show', compact('apartments', 'sponsorships', 'today', 'apartmentsWithValidSponsorship', 'endDate'));
    }


    public function create() {

        // Richiama tutti i servizi

        $services = Service :: all();

        return view('auth.apartments.create', compact('services'));
    }
    public function store(Request $request) {

        // Validazione dei dati inviati dall'utente

        $data = $request->only(['latitude', 'longitude']);

        $apartment = $request -> validate([
            "title" => "required | string | min:3 | max:64",
            "rooms" => "required | integer",
            "beds" => "required | integer",
            "bathrooms" => "required | integer",
            "square_meters" => "required | integer",
            "image" => "required | image | mimes:jpg,jpeg,png,svg,webp",
            "visible" => "boolean",
            "services" => "required | array",
        ]);

        // Salvataggio immagini nel db

        $fileName = time() . '.' . $request-> image -> extension();
        $request -> image -> storeAs('uploads', $fileName);
        $apartment['image'] = $fileName;

        // Validazione dei dati inviati dall'utente

        $address = $request -> validate([
            "latitude" => 'required | decimal:2,7',
            "longitude" => 'required | decimal:2,7',
            "address" => "required | string",
            "floor" => "required | integer",
        ]);


        // Acquisisce i valori di latitudie e longitudine da tomtom e li attribuisce ai campi dell'indirizzo utente

        $latitude = $data['latitude'];
        $longitude = $data['longitude'];

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

        return redirect('http://localhost:5174/apartment/' . $user_apartment -> id);
        
    }

    // Mostra i dettagli di un appartamento
    public function show($id) {

        $apartment = Apartment :: findOrFail($id);

        $address = Address ::where('apartment_id', $apartment->id)->firstOrFail();

        return redirect()->route('apartment/' . $apartment->id)->with( ['apartment' => $apartment, 'address' => $address ] );
        // return view('guest.apartments.show', compact('apartment', 'address'));
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
      
        $validator = Validator::make($request->all(), [
            'rooms' => 'numeric|min:0',
            'beds' => 'numeric|min:0',
            'bathrooms' => 'numeric|min:0',
            'square_meters' => 'numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $dataNotValidate = $request -> all();
        $dataValidate = $validator->validated();
        $data = array_merge($dataNotValidate, $dataValidate);

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

        if($data['address'] != null) {
            $address -> update($data);
        }


        return redirect('http://localhost:5174/apartment/' . $apartment -> id);
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

        $today = Carbon::now()->toDateString();

        return redirect()->route('auth.apartments.show', compact('today'));
    }
    // Mostra tutti i messaggi corrispondendti all'appartamento in pagina
    public function showMessages($id) {
        $apartment = Apartment :: findOrFail($id);
        $user = User :: where('id', $apartment->user_id)->firstOrFail();
        $userId = auth()->user()->id;
        $messages = Message::where('apartment_id', $id)->get();
        if ($userId == $user->id) {
            return view('auth.apartments.show-messages', compact('messages','apartment'));
        }
        else {
            return redirect()-> route('welcome');
        }
    }

    public function getAuth (){
        return Auth::check() ? response()->json(['email' => Auth::user()->email, 'name' => Auth::user()->name, 'surname' => Auth::user()->surname ?? 'User' ]) : response()->json(['error' => 'User not authenticated'], 403);
    }
    public function visits($id){

        $yearVisit = [];
        for ($year=2013; $year < 2024; $year++) { 
            $yearVisit[] = Visit::where('apartment_id', $id)->whereYear('visit_date', $year)->count();
        }

       

        
            $monthVisit = Visit::select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(visit_date, '%m-%Y') new_date"),  DB::raw('YEAR(visit_date) year, MONTH(visit_date) month'))
            ->where('apartment_id', $id)
            ->groupBy('year','month')
            ->get();
    
        


        return view('auth.apartments.statistics.stats')->with('yearVisit',json_encode($yearVisit,JSON_NUMERIC_CHECK))->with('monthVisit',json_encode($monthVisit,JSON_NUMERIC_CHECK));

    }
}
