<?php

use App\Http\Controllers\FamilyController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('family.index'));
Route::resource('family', FamilyController::class);
Route::get('/family/{family}/details', [FamilyController::class, 'familyDetails'])->name('family.details');
Route::get('/cities', [FamilyController::class, 'getCities'])->name('family.getCities');