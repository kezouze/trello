<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Api routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/card_lists', [\App\Http\Controllers\Api\CardListController::class, 'index'])->name("card_lists.index");
Route::post('/card_lists/update_order', [\App\Http\Controllers\Api\CardListController::class, 'orderUpdate'])->name("card_lists.update_order");
Route::get('/cards/get_card/{card}', [\App\Http\Controllers\Api\CardController::class, 'get_card'])->name("card_lists.get_card"); 
Route::post('/cards/update', [\App\Http\Controllers\Api\CardController::class, 'update'])->name("cards.update");
