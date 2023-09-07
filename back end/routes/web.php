<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoggedController;
use App\Http\Controllers\Guest\GuestController;


Route::get('/', [GuestController :: class, 'index']) ->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route :: get('/myapartments', [LoggedController :: class, 'index'])  // show
->middleware(['auth', 'verified'])-> name('auth.apartments.show');  // auth.my-apartments

Route::get('/apartments/create', [LoggedController::class, 'create'])
->middleware(['auth'])->name('auth.apartments.create');  // auth.user-crud.create-apartment

Route::post('/apartments', [LoggedController::class, 'store'])->middleware(['auth'])->name('apartment.store');

Route :: get('/apartments/{id}', [LoggedController :: class, 'show'])
    -> name('guest.apartments.show');  // guest.show-apartment

Route :: get('/apartments/{id}/edit', [LoggedController :: class, 'edit'])
->middleware(['auth', 'verified'])-> name('auth.apartments.edit');  // auth.user-crud.edit-apartment

Route :: put('/apartments/{id}', [LoggedController :: class, 'update'])
    -> middleware(['auth'])
    -> name('guest.apartments.update');  // guest.show-apartment

Route :: delete('/apartments/{id}', [LoggedController :: class, 'delete'])
    ->middleware(['auth', 'verified'])-> name('auth.apartments.delete');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
