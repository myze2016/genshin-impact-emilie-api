<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\PartyPositionController;
use App\Http\Controllers\PartyPositionCharacterController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\PerkController;
use App\Http\Controllers\CharacterPerkController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('party', PartyController::class);
Route::apiResource('party-position', PartyPositionController::class);
Route::apiResource('party-position-character', PartyPositionCharacterController::class);
Route::apiResource('character', CharacterController::class);
Route::apiResource('perk', PerkController::class);
Route::apiResource('character-perk', CharacterPerkController::class);
Route::post('character-perk/delete-by-character', [CharacterPerkController::class, 'deletePerkByCharacter']);
Route::post('character/create/api', [CharacterController::class, 'addCharacterApi']);