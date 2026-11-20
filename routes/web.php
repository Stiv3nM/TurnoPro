<?php

use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequerimientoController;
use App\Http\Controllers\TurnoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('departamentos', DepartamentoController::class)->except('show');
    Route::resource('turnos', TurnoController::class)->except('show');
    Route::resource('empleados', EmpleadoController::class)->except('show');
    Route::get('horarios', [HorarioController::class, 'index'])->name('horarios.index');
    Route::get('mi-horario', [HorarioController::class, 'mio'])->name('mi.horario');
    Route::post('horarios/guardar', [HorarioController::class, 'guardar'])->name('horarios.guardar');
    Route::get('requerimientos', [RequerimientoController::class, 'index'])->name('requerimientos.index');
    Route::post('requerimientos', [RequerimientoController::class, 'store'])->name('requerimientos.store');
});

require __DIR__.'/auth.php';