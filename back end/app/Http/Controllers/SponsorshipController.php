<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Support\Facades\DB;


use Carbon\Carbon;

class SponsorshipController extends Controller
{
    public function index($id)
    {
        $apartment = Apartment :: findOrFail($id);
        $sponsorship = Sponsorship::orderBy('id')->get();
        return view('sponsorship.index', compact('apartment', 'sponsorship'));
    }

    public function ChooseSponsorship (Request $request, $id) {
        $apartment = Apartment :: findOrFail($id);
        $apartments = Apartment :: all();

            $data = $request -> all();

            $nowDate = Carbon::now()->toDateString();
            $nowDateParse = Carbon::parse($nowDate);

            if ($data['sponsorships'] == 1) {
                $endDate = $nowDateParse -> copy() -> addDays(1);
            } else if ($data['sponsorships'] == 2) {
                $endDate = $nowDateParse -> copy() -> addDays(3);
            } else if ($data['sponsorships'] == 3) {
                $endDate = $nowDateParse -> copy() -> addDays(6);
            }

        if (!$apartment->sponsorships()->where('end_date', '>=', $nowDate)->exists()) {
            $sponsorship = Sponsorship::findOrFail($data['sponsorships']);
            $apartment -> sponsorships() -> attach($sponsorship, ['start_date'=> $nowDate, 'end_date' => $endDate]);
            $message = 'Sponsorizzazione attivata correttamente.';
        } else {
            $message = 'Questo appartamento ha già una sponsorizzazione attiva.';
            // dd($message);
        }
        return view('auth.apartments.sponsorship', compact('message', 'apartments'));

    }

        public function ReturnApartmentsWithValidSponsorship() {

            $nowDate = Carbon::now()->toDateString();

            $apartmentsWithValidSponsorship = DB::table('apartment_sponsorship')
                ->whereDate('start_date', '<=', $nowDate)
                ->whereDate('end_date', '>=', $nowDate)
                ->pluck('apartment_id')
                ->toArray();

            // dd($apartmentsWithValidSponsorship);

            return response()-> json(['appartamentiSponsorizzati' => $apartmentsWithValidSponsorship]);
        }
}


