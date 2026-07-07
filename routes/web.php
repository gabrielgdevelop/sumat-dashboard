<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContribuyenteController;
use App\Http\Controllers\ContribuyentesAceptados;
use App\Http\Controllers\ContribuyentesGraficas;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // RUTAS PARA LOS CONTRIBUYENTES
    Route::get('/contribuyente-detalles/{id}', [ContribuyenteController::class, 'show'])->name('contribuyentes.show');
    Route::put('/contribuyente/{id}', [ContribuyenteController::class, 'update'])->name('contribuyente.update');
    Route::get('/contribuyentes/create', [ContribuyenteController::class, 'create'])->name('contribuyentes.create');
    Route::post('/contribuyentes', [ContribuyenteController::class, 'store'])->name('contribuyentes.store');
    Route::delete('/contribuyentes/{contribuyente}', [ContribuyenteController::class, 'destroy'])->name('contribuyentes.destroy');
    // Admin contribuyentes module
    Route::get('/admin/contribuyentes', [ContribuyenteController::class, 'adminIndex'])->name('contribuyentes.admin.index');
    Route::get('/admin/contribuyentes/{contribuyente}', [ContribuyenteController::class, 'adminShow'])->name('contribuyentes.admin.show');
    Route::get('/admin/contribuyentes/{contribuyente}/edit', [ContribuyenteController::class, 'adminEdit'])->name('contribuyentes.admin.edit');
    Route::put('/admin/contribuyentes/{contribuyente}', [ContribuyenteController::class, 'adminUpdate'])->name('contribuyentes.admin.update');
    Route::get('/contribuyentes-aceptados', [ContribuyentesAceptados::class, 'index'])->name('contribuyentes.aceptados');
    Route::get('/contribuyentes-dashboard', [ContribuyentesGraficas::class, 'index'])->name('contribuyentes.dashboard');
    Route::post('/grafica/year', [ContribuyentesGraficas::class, 'graficaPorYear']);
});

require __DIR__.'/auth.php';
