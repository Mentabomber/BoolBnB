<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\Address;

class ApiController extends Controller
{
    public function apartmentIndex() {
        $apartments = Apartment :: all();
        return response()->json([
            'apartments' => $apartments
        ]);
    }
}
