<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TemporaryPageController;
use App\Http\Controllers\LuckyController;

Route::get('/', [RegistrationController::class, 'showRegistrationForm']);
Route::post('/register', [RegistrationController::class, 'register']);
Route::get('/temporary-page/{token}', [TemporaryPageController::class, 'show'])
    ->middleware('check.temporary.link')
    ->name('temporary.page');
Route::post('/create-link', [TemporaryPageController::class, 'createLink'])
    ->name('create.link');
Route::post('/temporary-link/deactivate', [TemporaryPageController::class, 'deactivate'])
    ->name('temporary-link.deactivate');
Route::post('/imfeelinglucky', [LuckyController::class, 'play'])
    ->middleware('check.active.link')
    ->name('lucky.play');
Route::get('/last-history', [LuckyController::class, 'lastHistory'])->name('lucky.lastHistory');
