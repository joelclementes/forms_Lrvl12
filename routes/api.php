<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FormularioPublicoController;

Route::get('/formularios/{slug}', [FormularioPublicoController::class, 'show']);
Route::post('/formularios/{slug}/respuestas', [FormularioPublicoController::class, 'store']);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
