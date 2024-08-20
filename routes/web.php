<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TipoComponente;
use App\Http\Controllers\DepositoController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ComponenteController;
use App\Http\Controllers\HistoriaController;
use App\Http\Controllers\PcController;
use App\Http\Controllers\EstadoController;
use Illuminate\Support\Facades\Route;

///////////////////////////


///////////////////////////

Route::get('/inv-tecnica', function () {
    return view('auth/login');
});

Route::get('/inv-tecnica/inicio', function () {
    return view('inicio');
})->middleware(['auth', 'verified'])->name('inicio');

Route::get('/inv-tecnica/gest_tipo_componente', [TipoComponente::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('gest_tipo_componente');

Route::post('/inv-tecnica/gest_tipo_componente/store', [TipoComponente::class, 'store'])
    ->name('store_tipo');

Route::patch('/inv-tecnica/gest_tipo_componente/patch', [TipoComponente::class, 'edit'])
    ->name('edit_tipo');

Route::post('/inv-tecnica/gest_tipo_componente/delete', [TipoComponente::class, 'delete'])
    ->name('delete_tipo');

Route::get('/inv-tecnica/gest_depositos', [DepositoController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('gest_depositos');

Route::post('/inv-tecnica/gest_depositos/store', [DepositoController::class, 'store'])
    ->name('store_deposito');

Route::patch('/inv-tecnica/gest_depositos/patch', [DepositoController::class, 'edit'])
    ->name('edit_deposito');

Route::post('/inv-tecnica/gest_depositos/delete', [DepositoController::class, 'delete'])
    ->name('delete_deposito');

Route::get('/inv-tecnica/gest_areas', [AreaController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('gest_areas');

Route::post('/inv-tecnica/gest_areas/store', [AreaController::class, 'store'])
    ->name('store_area');

Route::patch('/inv-tecnica/gest_areas/patch', [AreaController::class, 'edit'])
    ->name('edit_area');

Route::post('/inv-tecnica/gest_areas/delete', [AreaController::class, 'delete'])
    ->name('delete_area');

Route::get('/inv-tecnica/gest_componentes', [ComponenteController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('gest_componentes');

Route::post('/inv-tecnica/gest_componentes/store', [ComponenteController::class, 'store'])
    ->name('store_componentes');

Route::post('/inv-tecnica/gest_componentes/add_stock', [ComponenteController::class, 'add_stock'])
    ->name('add_stock_componentes');

Route::post('/inv-tecnica/gest_componentes/remove_stock', [ComponenteController::class, 'remove_stock'])
    ->name('remove_stock_componentes');

Route::patch('/inv-tecnica/gest_componentes/patch', [ComponenteController::class, 'edit'])
    ->name('edit_componentes');

Route::post('/inv-tecnica/gest_componentes/delete', [ComponenteController::class, 'delete'])
    ->name('delete_componentes');

Route::post('/inv-tecnica/gest_componentes/transfer', [ComponenteController::class, 'transfer'])
    ->name('transfer_componentes');

Route::post('/inv-tecnica/gest_componentes/state', [ComponenteController::class, 'transferState'])
    ->name('state_componentes');

Route::get('/inv-tecnica/gest_pc', [PcController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('gest_pc');

Route::post('/inv-tecnica/gest_pc/store', [PcController::class, 'store'])
    ->name('store_pc');

Route::patch('/inv-tecnica/gest_pc/patch', [PcController::class, 'edit'])
    ->name('edit_pc');

Route::post('/inv-tecnica/gest_pc/delete', [PcController::class, 'delete'])
    ->name('delete_pc');

Route::get('/inv-tecnica/gest_pc/historia/{id}', [PcController::class, 'getHistoria']);

Route::get('/inv-tecnica/gest_state', [EstadoController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('gest_state');

Route::post('/inv-tecnica/gest_state/store', [EstadoController::class, 'store'])
    ->name('store_state');

Route::patch('/inv-tecnica/gest_state/patch', [EstadoController::class, 'edit'])
    ->name('edit_state');

Route::post('/inv-tecnica/gest_state/delete', [EstadoController::class, 'delete'])
    ->name('delete_state');


Route::get('/inv-tecnica/historia', [HistoriaController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('historia');

Route::get('/inv-tecnica/reportes', function () {
    return view('reportes');
})->middleware(['auth', 'verified'])->name('reportes');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
