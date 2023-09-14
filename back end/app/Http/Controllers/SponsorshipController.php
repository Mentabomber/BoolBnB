<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Sponsorship;


class SponsorshipController extends Controller
{
    public function index(Apartment $apartment)
    {
        $sponsorship = Sponsorship::all();
        return view('sponsorship.index', compact('sponsorship', 'apartment'));
    }
}


