<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {

    Route::resource("field", FieldController::class);
    Route::resource("contact", ContactController::class);
    Route::get('/contact-list/{id}', [ContactController::class, 'getContactList'])->name('contact.getContactList');
    Route::post('/merge-contact', [ContactController::class, 'mergeContact'])->name('contact.mergeContact');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
