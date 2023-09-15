<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Api\ApiController;


Route :: prefix('/v1') -> group(function() {

    Route :: get('/apartment-index', [ApiController::class, 'apartmentIndex']);
    Route :: get('/apartment/{id}', [ApiController::class, 'showApartment']);
    Route :: get('/api/get-email', [ApiController::class, 'userEmail']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
