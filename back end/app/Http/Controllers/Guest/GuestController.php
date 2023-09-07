<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Apartment;


class GuestController extends Controller
{
    public function index() {

        $apartments = Apartment :: all();

        return view('welcome', compact('apartments'));
    }
}
