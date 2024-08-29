<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TipoComponente;
use App\Http\Controllers\DepositoController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ComponenteController;
use App\Http\Controllers\HistoriaController;
use App\Http\Controllers\PcController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\DispositivosController;
use App\Http\Controllers\ImpresoraController;
use App\Http\Controllers\TelefonoController;
use App\Http\Controllers\RouterController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ReportesController;
use Illuminate\Support\Facades\Route;

///////////////////////////


///////////////////////////

Route::get('', function () {
    return view('auth/login');
});

Route::get('', function () {
    return view('auth/login');
})->name('profile_view');

Route::get('/inicio', [InicioController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('inicio');


Route::get('/dispositivos', [DispositivosController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dispositivos');

Route::get('/gest_tipo_componente', [TipoComponente::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('gest_tipo_componente');

Route::post('/gest_tipo_componente/store', [TipoComponente::class, 'store'])
    ->name('store_tipo');

Route::patch('/gest_tipo_componente/patch', [TipoComponente::class, 'edit'])
    ->name('edit_tipo');

Route::post('/gest_tipo_componente/delete', [TipoComponente::class, 'delete'])
    ->name('delete_tipo');

Route::get('/gest_depositos', [DepositoController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('gest_depositos');

Route::post('/gest_depositos/store', [DepositoController::class, 'store'])
    ->name('store_deposito');

Route::patch('/gest_depositos/patch', [DepositoController::class, 'edit'])
    ->name('edit_deposito');

Route::post('/gest_depositos/delete', [DepositoController::class, 'delete'])
    ->name('delete_deposito');

Route::get('/gest_areas', [AreaController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('gest_areas');

Route::post('/gest_areas/store', [AreaController::class, 'store'])
    ->name('store_area');

Route::patch('/gest_areas/patch', [AreaController::class, 'edit'])
    ->name('edit_area');

Route::post('/gest_areas/delete', [AreaController::class, 'delete'])
    ->name('delete_area');

Route::get('/gest_componentes', [ComponenteController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('gest_componentes');

Route::post('/gest_componentes/store', [ComponenteController::class, 'store'])
    ->name('store_componentes');

Route::post('/gest_componentes/add_stock', [ComponenteController::class, 'add_stock'])
    ->name('add_stock_componentes');

Route::post('/gest_componentes/remove_stock', [ComponenteController::class, 'remove_stock'])
    ->name('remove_stock_componentes');

Route::patch('/gest_componentes/patch', [ComponenteController::class, 'edit'])
    ->name('edit_componentes');

Route::post('/gest_componentes/delete', [ComponenteController::class, 'delete'])
    ->name('delete_componentes');

Route::post('/gest_componentes/transfer', [ComponenteController::class, 'transfer'])
    ->name('transfer_componentes');

Route::post('/gest_componentes/state', [ComponenteController::class, 'transferState'])
    ->name('state_componentes');

Route::get('/gest_pc', [PcController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('gest_pc');

Route::post('/gest_pc/store', [PcController::class, 'store'])
    ->name('store_pc');

Route::patch('/gest_pc/patch', [PcController::class, 'edit'])
    ->name('edit_pc');

Route::post('/gest_pc/delete', [PcController::class, 'delete'])
    ->name('delete_pc');

Route::get('/gest_impresoras', [ImpresoraController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('gest_impresoras');

Route::post('/gest_impresoras/store', [ImpresoraController::class, 'store'])
    ->name('store_impresoras');

Route::patch('/gest_impresoras/patch', [ImpresoraController::class, 'edit'])
    ->name('edit_impresoras');

Route::post('/gest_impresoras/delete', [ImpresoraController::class, 'delete'])
    ->name('delete_impresoras');

Route::get('/gest_telefonos', [TelefonoController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('gest_telefonos');

Route::post('/gest_telefonos/store', [TelefonoController::class, 'store'])
    ->name('store_telefonos');

Route::patch('/gest_telefonos/patch', [TelefonoController::class, 'edit'])
    ->name('edit_telefonos');

Route::post('/gest_telefonos/delete', [TelefonoController::class, 'delete'])
    ->name('delete_telefonos');

Route::get('/gest_routers', [RouterController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('gest_routers');

Route::post('/gest_routers/store', [RouterController::class, 'store'])
    ->name('store_routers');

Route::patch('/gest_routers/patch', [RouterController::class, 'edit'])
    ->name('edit_routers');

Route::post('/gest_routers/delete', [RouterController::class, 'delete'])
    ->name('delete_routers');

Route::get('/gest_pc/historia/{tipo}/{id}', [PcController::class, 'getHistoria'])
    ->name('historia.get');


Route::get('/gest_state', [EstadoController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('gest_state');

Route::post('/gest_state/store', [EstadoController::class, 'store'])
    ->name('store_state');

Route::patch('/gest_state/patch', [EstadoController::class, 'edit'])
    ->name('edit_state');

Route::post('/gest_state/delete', [EstadoController::class, 'delete'])
    ->name('delete_state');


Route::get('/historia', [HistoriaController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('historia');

// routes/web.php
Route::get('/filter-reportes', [ReportesController::class, 'filterReportes'])->middleware(['auth', 'verified'])
    ->name('filter_historias');

Route::get('/filter-stock', [ReportesController::class, 'filterStock'])->middleware(['auth', 'verified'])
    ->name('filter_stock');


Route::get('/reportes', [ReportesController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('reportes');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
