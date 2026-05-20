<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\AdoptionController;
use App\Http\Controllers\Public\BlogController;
use App\Http\Controllers\Public\CatalogController;
use App\Http\Controllers\Public\CessionController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PageController;
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

// Portal público — accesible para todos
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalogo/{animal}', [CatalogController::class, 'show'])->name('catalog.show');

Route::get('/sobre-nosotros', [PageController::class, 'about'])->name('about');
Route::get('/contacto', [PageController::class, 'contact'])->name('contact');
Route::post('/contacto', [PageController::class, 'sendContact'])->name('contact.send');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/politica-de-privacidad', [PageController::class, 'privacy'])->name('privacy');

// Fase 1: perfil de usuario — F1-T06
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/perfil', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');
});

// Fase 2: solicitudes de adopción — F2-T02, F2-T08
Route::middleware(['auth', 'verified', 'role:adopter'])->group(function () {
    Route::get('/adopcion/{animal}/solicitar', [AdoptionController::class, 'create'])->name('adoption.create');
    Route::post('/adopcion/{animal}/solicitar', [AdoptionController::class, 'store'])->name('adoption.store');
    Route::get('/mis-solicitudes', [AdoptionController::class, 'myRequests'])->name('adoption.my-requests');
});

// DESACTIVADO: Módulo de cesión deshabilitado por decisión del cliente.
// El albergue no acepta animales por cesión, solo rescata. Código conservado para referencia.
// Route::middleware(['auth', 'role:surrenderer'])->group(function () {
//     Route::get('/cesion/solicitar', [CessionController::class, 'create'])->name('cession.create');
//     Route::post('/cesion/solicitar', [CessionController::class, 'store'])->name('cession.store');
//     Route::get('/mis-cesiones', [CessionController::class, 'myRequests'])->name('cession.my-requests');
// });

require __DIR__.'/auth.php';
