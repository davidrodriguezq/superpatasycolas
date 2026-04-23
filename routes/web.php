<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
 * Acceso por rol:
 * - admin:        acceso total a /admin/*
 * - collaborator: acceso a /admin/* excepto usuarios y configuración
 * - adopter:      perfil, catálogo público, sus solicitudes de adopción
 * - surrenderer:  perfil, formulario de cesión, sus solicitudes de cesión
 *
 * Las rutas de autenticación (login, register, logout, etc.) están en routes/auth.php
 * Las rutas del panel administrativo están en routes/admin.php (prefijo /admin)
 */

Route::get('/', fn () => view('welcome'))->name('home');

// Rutas temporales de verificación de layouts (F0-T08).
// Eliminar cuando existan las vistas reales en Fase 1 y Fase 3.
Route::get('/test-layout', fn () => view('test-public'));
Route::get('/test-admin', fn () => view('test-admin'))->middleware('auth');

// Catálogo público — placeholder hasta Fase 3 (F3-T02)
Route::get('/catalogo', fn () => redirect('/') )->name('catalog.index');

// Fase 1: perfil de usuario — F1-T06
Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';
