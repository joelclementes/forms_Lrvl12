<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormularioController;


Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('formulario')->name('formularios.')->group(function () {
        Route::get('/', [FormularioController::class, 'index'])->name('index');
        Route::post('/', [FormularioController::class, 'store'])->name('store');
        Route::get('/{formulario}/edit', [FormularioController::class, 'edit'])->name('edit');
        Route::put('/{formulario}', [FormularioController::class, 'update'])->name('update');

        Route::get('/{formulario}/configuracion', [FormularioController::class, 'configuracion'])->name('configuracion');
        Route::put('/{formulario}/configuracion', [FormularioController::class, 'actualizarConfiguracion'])->name('configuracion.update');

        // Route::get('/crear', [FormularioController::class, 'create'])->name('create');
        // Route::post('/', [FormularioController::class, 'store'])->name('store');


        // Route::delete('/{id}', [FormularioController::class, 'destroy'])->name('destroy');
        // Route::post('/orden', [FormularioController::class, 'reorder'])->name('reorder');
    });


});

