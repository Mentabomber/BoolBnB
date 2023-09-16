<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Sponsorship;


class SponsorshipController extends Controller
{
    public function index()
    {
        $apartment = Apartment :: all();
        $sponsorship = Sponsorship::orderBy('id')->get();
        return view('sponsorship.index', compact('sponsorship', 'apartment'));
    }

    public function ChooseSponsorship (Request $request, $id)
        { 
            $data = $request -> all();
            $apartment = Apartment :: findOrFail($id);
            dd($data);
            $apartment -> sponsorships() -> attach($data['sponsorships']);

            



            

        }
}


