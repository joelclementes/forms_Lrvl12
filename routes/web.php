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

        Route::get('/{formulario}/campos', [FormularioController::class, 'campos'])->name('campos');
        Route::post('/{formulario}/campos', [FormularioController::class, 'guardarCampo'])->name('campos.store');
        Route::put('/{formulario}/campos/{campo}', [FormularioController::class, 'actualizarCampo'])->name('campos.update');
        Route::delete('/{formulario}/campos/{campo}', [FormularioController::class, 'eliminarCampo'])->name('campos.destroy');
        Route::post('/{formulario}/campos/ordenar', [FormularioController::class, 'ordenarCampos'])->name('campos.ordenar');
    });


});

