<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Support\Facades\DB;
use Braintree\Gateway;


use Carbon\Carbon;

class SponsorshipController extends Controller
{
    public function index($id)
    {
        $gateway = new Gateway([
            "environment" => env("BRAINTREE_ENVIRONMENT"),
            "merchantId" => env("BRAINTREE_MERCHANT_ID"),
            "publicKey" => env("BRAINTREE_PUBLIC_KEY"),
            "privateKey" => env("BRAINTREE_PRIVATE_KEY"),
        ]);

        $token = $gateway->clientToken()->generate();
        
        $apartment = Apartment :: findOrFail($id);
        $sponsorship = Sponsorship::orderBy('id')->get();
        return view('sponsorship.index', compact('apartment', 'sponsorship','gateway', 'token',));
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


