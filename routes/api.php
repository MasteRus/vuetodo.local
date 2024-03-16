<?php

use App\Http\Controllers\NoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('notes', NoteController::class);
Route::post('notes/{note}/items', [NoteController::class, 'addItem']);
Route::post('notes/{note}/items/{id}/toggle', [NoteController::class, 'toggleItem']);
Route::put('notes/{note}/items/{id}', [NoteController::class, 'updateItem']);
Route::delete('notes/{note}/items/{id}', [NoteController::class, 'deleteItem']);
