<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrdenTrabajoController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\Area;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // =========================================================
    // PERFIL
    // =========================================================

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    // =========================================================
    // SUCURSALES
    // =========================================================

    Route::resource('sucursales', SucursalController::class)
        ->parameters([
            'sucursales' => 'sucursal',
        ]);


    // =========================================================
    // ÁREAS
    // =========================================================

    Route::resource('sucursales.areas', AreaController::class)
        ->parameters([
            'sucursales' => 'sucursal',
            'areas' => 'area',
        ]);


    // =========================================================
    // EQUIPOS
    // =========================================================

    Route::get('/equipos', [EquipoController::class, 'general'])
        ->name('equipos.index');

    Route::resource('sucursales.areas.equipos', EquipoController::class)
        ->parameters([
            'sucursales' => 'sucursal',
            'areas' => 'area',
            'equipos' => 'equipo',
        ])
        ->scoped();

    Route::post(
        'sucursales/{sucursal}/areas/{area}/equipos/importar',
        [EquipoController::class, 'importar']
    )->name('sucursales.areas.equipos.importar');


    // =========================================================
    // USUARIOS
    // =========================================================

    Route::resource('usuarios', UserController::class)
        ->parameters([
            'usuarios' => 'usuario',
        ]);


    // =========================================================
    // CAMBIAR SUCURSAL
    // =========================================================

    Route::post('/cambiar-sucursal', function (Request $request) {

        $request->validate([
            'sucursal_id' => ['required', 'exists:sucursales,id'],
        ]);

        $usuario = auth()->user();

        if (! $usuario->sucursales()
            ->whereKey($request->sucursal_id)
            ->exists()) {

            abort(403);
        }

        session([
            'sucursal_id' => $request->sucursal_id,
        ]);

        return back();

    })->name('sucursal.cambiar');


    // =========================================================
    // ÓRDENES DE TRABAJO
    // =========================================================

    Route::resource('ordenes', OrdenTrabajoController::class)
        ->parameters([
            'ordenes' => 'orden',
        ]);


    // =========================================================
    // API - ÁREAS DE UNA SUCURSAL
    // =========================================================

    Route::get('/api/sucursales/{sucursal}/areas', function (Sucursal $sucursal) {

        return response()->json(
            $sucursal->areas()
                ->orderBy('nombre')
                ->get(['id', 'nombre'])
        );

    })->name('api.sucursales.areas');


    // =========================================================
    // API - EQUIPOS DE UN ÁREA
    // =========================================================

    Route::get('/api/areas/{area}/equipos', function (Area $area) {

        return response()->json(
            $area->equipos()
                ->orderBy('nombre')
                ->get(['id', 'nombre'])
        );

    })->name('api.areas.equipos');

    Route::post('/ordenes/{orden}/tomar', [OrdenTrabajoController::class, 'tomar'])
    ->name('ordenes.tomar');

    Route::post(
    '/ordenes/{orden}/cerrar',
    [OrdenTrabajoController::class, 'cerrar']
)->name('ordenes.cerrar');

    


});


require __DIR__.'/auth.php';