<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\PartyPositionController;
use App\Http\Controllers\PartyPositionCharacterController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\PerkController;
use App\Http\Controllers\CharacterPerkController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\ElementController;
use App\Http\Controllers\WeaponTypeController;
use App\Http\Controllers\WeaponController;
use App\Http\Controllers\WeaponPerkController;
use App\Http\Controllers\ArtifactController;
use App\Http\Controllers\ArtifactPerkController;
use App\Http\Controllers\CharacterWeaponController;
use App\Http\Controllers\CharacterArtifactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PartyWeaponController;
use App\Http\Controllers\PartyArtifactController;
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

// Route::apiResource('party', PartyController::class);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->apiResource('party', PartyController::class);
Route::apiResource('weapon', WeaponController::class);
Route::apiResource('weapon-perk', WeaponPerkController::class);
Route::apiResource('artifact', ArtifactController::class);
Route::apiResource('artifact-perk', ArtifactPerkController::class);
Route::post('weapon/create/api', [WeaponController::class, 'addWeaponsApi']);
Route::apiResource('party-position', PartyPositionController::class);
Route::apiResource('party-position-character', PartyPositionCharacterController::class);
Route::apiResource('character', CharacterController::class);
Route::apiResource('perk', PerkController::class);
Route::apiResource('elements', ElementController::class);
Route::apiResource('weapon-types', WeaponTypeController::class);
Route::apiResource('character-perk', CharacterPerkController::class);
Route::post('character-perk/delete-by-character', [CharacterPerkController::class, 'deletePerkByCharacter']);
Route::post('character/create/api', [CharacterController::class, 'addCharacterApi']);
Route::apiResource('common', CommonController::class);
Route::get('character-get-by-name', [CharacterController::class, 'searchName']);
Route::post('party-image', [PartyController::class, 'addPartyImage']);
Route::post('arrange', [PartyPositionCharacterController::class, 'arrange']);
Route::get('weapon-search', [WeaponController::class, 'searchByPerk']);
Route::get('artifact-search', [ArtifactController::class, 'searchByPerk']);
Route::post('weapon-perk/delete-by-perk', [WeaponPerkController::class, 'deleteWeaponPerkByPerk']);
Route::apiResource('character-weapon', CharacterWeaponController::class);
Route::post('character-weapon/delete-by-weapon', [CharacterWeaponController::class, 'deleteWeaponByCharacter']);
Route::post('artifact-perk/delete-by-perk', [ArtifactPerkController::class, 'deleteAllPerkByArtifact']);
Route::post('character-artifact/delete-by-artifact', [CharacterArtifactController::class, 'deleteArtifactByCharacter']);
Route::apiResource('character-artifact', CharacterArtifactController::class);
Route::post('party/copy-party', [PartyController::class, 'copyParty']);
Route::middleware('auth:sanctum')->get('party-user', [PartyController::class, 'getPartiesUser']);
Route::middleware('auth:sanctum')->get('artifact-user', [ArtifactController::class, 'getArtifactUser']);
Route::middleware('auth:sanctum')->get('character-artifact-user', [CharacterController::class, 'getCharacterArtitactUser']);
Route::middleware('auth:sanctum')->apiResource('party-artifact', PartyArtifactController::class);
Route::middleware('auth:sanctum')->apiResource('party-weapon', PartyWeaponController::class);
Route::get('artifact-by-party', [ArtifactController::class, 'getArtifactByParty']);
Route::get('weapon-by-party', [WeaponController::class, 'getWeaponByParty']);

Route::post('party-weapon/delete', [PartyWeaponController::class, 'deleteWeaponByPartyCharacterId']);
Route::post('party-artifact/delete', [PartyArtifactController::class, 'deleteArtifactByPartyCharacterId']);

