<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoggedController;
use App\Http\Controllers\Guest\GuestController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route :: get('/myapartments', [LoggedController :: class, 'show'])
->middleware(['auth', 'verified'])-> name('auth.my-apartments');

Route :: get('/apartments/{id}', [GuestController :: class, 'show'])
    -> name('guest.show-apartment');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/apartment/create', [LoggedController::class, 'create'])->name('auth.user-crud.create-apartment');
    Route::post('/apartment', [LoggedController::class, 'store'])->name('apartment.store');
    Route :: get('/apartments/{id}/edit', [LoggedController :: class, 'edit'])
        ->middleware(['auth', 'verified'])-> name('auth.user-crud.edit-apartment');

    Route :: put('/apartments/{id}', [LoggedController :: class, 'update'])
        -> middleware(['auth'])
        -> name('guest.show-apartment');
});

require __DIR__.'/auth.php';
