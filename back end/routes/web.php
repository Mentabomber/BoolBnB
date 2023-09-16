<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoggedController;
use App\Http\Controllers\Guest\GuestController;
use App\Http\Controllers\SponsorshipController;
use App\Http\Controllers\PaymentController;


// Rotta che porta alla home del sito

Route::get('/', [GuestController :: class, 'index']) ->name('welcome');

// Rotta che porta alla dashbord dell'utente

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotta che porta alla pagina con tutti gli appartamenti dell'utente

Route :: get('/myapartments', [LoggedController :: class, 'index'])
->middleware(['auth', 'verified'])-> name('auth.apartments.show');

// Rotta che porta alla creazione di un appartamento

Route::get('/apartments/create', [LoggedController::class, 'create'])
->middleware(['auth'])->name('auth.apartments.create');

// Rotta che porta alla dashbord dell'utente

Route::post('/apartments', [LoggedController::class, 'store'])->middleware(['auth'])->name('apartment.store');

// Rotta che porta alla pagina di dettaglio di un appartamento

Route :: get('/apartments/{id}', [LoggedController :: class, 'show'])
    -> name('guest.apartments.show');

    Route::get('/sponsor_plans/{id}', [SponsorshipController::class, 'index'])->name('sponsor_plans');
    Route::get('/sponsor_plans/{id}', [SponsorshipController::class, 'ChooseSponsorship'])->name('confirm_sponsor');
    Route::get('/payment', [PaymentController::class, 'createTransaction']);

// Rotta che porta alla modifica di un appartamento

Route :: get('/apartments/{id}/edit', [LoggedController :: class, 'edit'])
->middleware(['auth', 'verified'])-> name('auth.apartments.edit');

// Rotta che porta all'appartamento appena modificato

Route :: put('/apartments/{id}', [LoggedController :: class, 'update'])
    -> middleware(['auth']) -> name('guest.apartments.update');

// Rotta che porta all'eliminazione di un appartmaneto

Route :: delete('/apartments/{id}', [LoggedController :: class, 'delete'])
    ->middleware(['auth', 'verified'])-> name('auth.apartments.delete');

Route::post('/apartments/search', [GuestController::class, 'cercaAppartamenti'])->name('apartment.search');

// Rotta che manda i messaggi mandati dall'utente in database

Route::post('/apartments/messages/{id}', [GuestController::class, 'message'])->name('apartment.messages');

// Rotta che manda mostra tutti i messaggi di un'appartamento in pagina


Route::get('/apartments/show-messages/{id}', [LoggedController::class, 'showMessages'])
->middleware(['auth', 'verified'])->name('auth.apartments.show-messages');

// Gruppo di rotte che modificano, aggiornano ed eliminano il profilo dell'utente

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
